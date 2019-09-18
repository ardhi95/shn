<?php

App::uses('CakeNumber', 'Utility');
App::uses('Validation', 'Utility');

class EmployeesController extends AppController
{
	var $ControllerName		=	"Employees";
	var $ModelName 			=	"Employee";
	var $helpers 			=	array("Text","General");
	var $aco_id;

	function beforeFilter()
	{
		parent::beforeFilter();
		$this->set("ControllerName", $this->ControllerName);
		$this->set("ModelName", $this->ModelName);
		$this->{$this->ModelName}->locale =  $this->Session->read('Config.language');

		//CHECK PRIVILEGES
		$this->loadModel("MyAco");
		$find         =		$this->MyAco->find("first", array(
								 "conditions" => array(
								 	"LOWER(MyAco.controller)" => $this->ControllerName
								 )
							));

		$this->aco_id = $find["MyAco"]["id"];
		$this->set("aco_id", $this->aco_id);
	}

	function Index($page = 1, $viewpage = 50)
	{
		if ($this->access[$this->aco_id]["_read"] != "1"){
			$this->render("/Errors/no_access");
			return;
		}
		
		$this->Session->delete("Search." . $this->ControllerName);
		$this->Session->delete('Search.' . $this->ControllerName . 'Operand');
		$this->Session->delete('Search.' . $this->ControllerName . 'ViewPage');
		$this->Session->delete('Search.' . $this->ControllerName . 'Sort');
		$this->Session->delete('Search.' . $this->ControllerName . 'Page');
		$this->Session->delete('Search.' . $this->ControllerName . 'Conditions');

		$this->set(compact(
			"page",
			"viewpage"
		));
	}

	function ListItem($excel = "false")
	{
		$this->layout		=	"ajax";
		$fullScreenMode		=	$this->params['named']['fullScreenMode'];

		if ($this->access[$this->aco_id]["_read"] != "1") {
			   $data = array();
			   $this->set(compact("data"));
			   return;
		}

		$this->loadModel($this->ModelName);
		// $this->{$this->ModelName}->VirtualFieldActivated();
		$this->loadModel("WorkUnit");
		$this->loadModel("WorkShift");
		$joins			=	array(
								array(
									"table"			=>	"work_units",
									"alias"			=>	"WorkUnit",
									'type'			 => 'LEFT',
									"conditions"	=>	array(
										"{$this->ModelName}.work_unit_id = WorkUnit.id"
									)
								),
								array(
									"table"			=>	"work_shifts",
									"alias"			=>	"WorkShift",
									'type'			 => 'LEFT',
									"conditions"	=>	array(
										"{$this->ModelName}.work_shift_id = WorkShift.id"
									)
								)
							);
		
		//DEFINE LAYOUT, LIMIT AND OPERAND
		$operand  	=	"AND";
		if($excel == "true")
		{
			$order		=	$this->Session->read("Search.".$this->ControllerName."Sort");
			$viewpage	=	$this->Session->read("Search.".$this->ControllerName."Viewpage");
		}
		else
		{
			$viewpage	=	empty($this->params['named']['limit']) ? 50 : $this->params['named']['limit'];
			$order    	= 	array(
							   "{$this->ModelName}.id" => "ASC"
							);
			$this->Session->write('Search.' . $this->ControllerName . 'Viewpage', $viewpage);
			$this->Session->write('Search.' . $this->ControllerName . 'Sort', (empty($this->params['named']['sort']) or !isset($this->params['named']['sort'])) ? $order : $this->params['named']['sort'] . " " . $this->params['named']['direction']);
		}

		//DEFINE SEARCH DATA
		if (!empty($this->request->data)) {
			$cond_search = array();
			$operand     = $this->request->data[$this->ModelName]['operator'];
			$this->Session->delete('Search.' . $this->ControllerName);

			
			if (!empty($this->request->data['Search']['id'])) {
				   $cond_search["{$this->ModelName}.id"] = $this->data['Search']['id'];
			}
			
			if (!empty($this->request->data['Search']['name'])) {
				   $cond_search["{$this->ModelName}.name LIKE "] = "%".$this->data['Search']['name']."%";
			}
			
			if (!empty($this->data['Search']['start_date']) && empty($this->data['Search']['end_date'])) {
				   $cond_search["{$this->ModelName}.created >= "] = $this->data['Search']['start_date'] . " 00:00:00";
			}

			if (empty($this->data['Search']['start_date']) && !empty($this->data['Search']['end_date'])) {
				   $cond_search["{$this->ModelName}.created <= "] = $this->data['Search']['end_date'] . " 23:59:59";
			}

			if (!empty($this->data['Search']['start_date']) && !empty($this->data['Search']['end_date'])) {
				   $tmp                                                            = $this->data['Search']['start_date'];
				   $START                                                          = (strtotime($this->data['Search']['end_date']) < strtotime($this->data['Search']['start_date'])) ? $this->data['Search']['end_date'] : $this->data['Search']['start_date'];
				   $END                                                            = ($this->data['Search']['end_date'] < $tmp) ? $tmp : $this->data['Search']['end_date'];
				   $cond_search["{$this->ModelName}.created BETWEEN ? AND ? "] = array(
						   $START . " 00:00:00",
						   $END . " 23:59:59"
				   );
			}

			if ($this->request->data["Search"]['reset'] == "0") {
				   $this->Session->write("Search." . $this->ControllerName, $cond_search);
				   $this->Session->write('Search.' . $this->ControllerName . 'Operand', $operand);
			}
		}

		$this->Session->write('Search.' . $this->ControllerName . 'Viewpage', $viewpage);
		$this->Session->write('Search.' . $this->ControllerName . 'Sort', (empty($this->params['named']['sort']) or !isset($this->params['named']['sort'])) ? $order : $this->params['named']['sort'] . " " . $this->params['named']['direction']);

		$cond_search     	=	array();
		$filter_paginate 	=	array();

		//DEFINE CURRENT PAGE
		if (
			isset($this->params['named']['page']) &&
			$this->params['named']['page'] >
			$this->params['paging'][$this->ModelName]['pageCount']
		)
		{
			   $this->params['named']['page'] = $this->params['paging'][$this->ModelName]['pageCount'];
		}

		if($excel == "true")
		{
			$page			=	$this->Session->read("Search.".$this->ControllerName."Page");
		}
		else
		{
			$page 	= empty($this->params['named']['page']) ? 1 : $this->params['named']['page'];
			$this->Session->write('Search.' . $this->ControllerName . 'Page', $page);
		}

		$this->paginate  	=	array(
									"{$this->ModelName}" => array(
										   "order" 			=>	$order,
										   "joins"			=>	$joins,
										   "fields"			=>	array(
										   		"Employee.*",
										   		"WorkShift.*",
										   		"WorkUnit.*"
										   ),
										   'limit' 			=>	$viewpage,
                                           "maxLimit"       =>  1000
									)
								);

		$ses_cond    		=	$this->Session->read("Search." . $this->ControllerName);
		$cond_search 		=	isset($ses_cond) ? $ses_cond : array();
		$ses_operand 		=	$this->Session->read("Search." . $this->ControllerName . "Operand");
		$operand     		=	isset($ses_operand) ? $ses_operand : "AND";
		$merge_cond  		=	empty($cond_search) ? $filter_paginate : array_merge($filter_paginate, array(
			   $operand => $cond_search
		));
		
		$data				=	array();

		try {
			$data        		= $this->paginate("{$this->ModelName}", $merge_cond);
			pr($data);
		}
		catch (NotFoundException $e) {
			$count 				= $this->{$this->ModelName}->find('count',array("conditions"=>$merge_cond));
			$pageCount 			= intval(ceil($count / $viewpage));
			$this->request->params['named']['page'] = $pageCount;
			$this->Session->write('Search.' . $this->ControllerName . 'Page', $pageCount);
			$this->{$this->ModelName}->BindDefault(false);
			$data        		= $this->paginate("{$this->ModelName}", $merge_cond);
    	}
		$this->Session->write('Search.' . $this->ControllerName . 'Conditions', $merge_cond);

		pr($data);

		$this->set(compact(
			'data',
			'page',
			'viewpage',
			'fullScreenMode'
		));

		$filename		=	$this->ControllerName."-".date("dMY").".xlsx";
		if($excel == "true") {
			$this->set('filename',$filename);
			$this->render('excel');
		} else {
			$this->render('list_item');
		}
	}

	function Excel()
	{
		if($this->access[$this->aco_id]["_read"] != "1")
		{
			$this->render("/Errors/no_access");
			return;
		}

		$this->layout		=	"ajax";
		$this->{$this->ModelName}->BindDefault(false);
		// $this->{$this->ModelName}->VirtualFieldActivated();

		$this->loadModel("WorkUnit");
		$this->loadModel("WorkShift");
		$joins			=	array(
								array(
									"table"			=>	"work_units",
									"alias"			=>	"WorkUnit",
									'type'			 => 'LEFT',
									"conditions"	=>	array(
										"{$this->ModelName}.work_unit_id = WorkUnit.id"
									)
								),
								array(
									"table"			=>	"work_shifts",
									"alias"			=>	"WorkShift",
									'type'			 => 'LEFT',
									"conditions"	=>	array(
										"{$this->ModelName}.work_shift_id = WorkShift.id"
									)
								)
							);

		$order			=	$this->Session->read("Search.".$this->ControllerName."Sort");
		$viewpage			=	$this->Session->read("Search.".$this->ControllerName."Viewpage");
		$page				=	$this->Session->read("Search.".$this->ControllerName."Page");
		$conditions		=	$this->Session->read("Search.".$this->ControllerName."Conditions");

		$this->paginate		=	array(
									"{$this->ModelName}"	=>	array(
										"order"				=>	$order,
										"joins"			=>	$joins,
										   "fields"			=>	array(
										   		"Employee.*",
										   		"WorkUnit.name",
										   		"WorkShift.name"
										   ),
										"limit"				=>	$viewpage,
										"conditions"		=>	$conditions,
										"page"				=>	$page
									)
								);

		$data				=	$this->paginate("{$this->ModelName}",$conditions);
		$title			=	$this->ModelName;
		$filename			=	$this->ControllerName."-".date("dMY").".xlsx";
		$this->set(compact("data","title","page","viewpage","filename"));
	}

	function Add()
	{
		if($this->access[$this->aco_id]["_create"] != "1")
		{
			$this->render("/Errors/no_access");
			return;
		}
		
		if(!empty($this->request->data))
		{
			// ===== Set Rule ===== //
			$this->loadModel("Employee");
			$get_gender		=	$this->request->data['Employee']['gender'];
			$get_age 		=	(int)$this->request->data['Employee']['age'];
			$get_distance	=	(int)$this->request->data['Employee']['house'];
			$get_unit		=	$this->request->data['Employee']['work_unit_id'];
			$get_health 	=	$this->request->data['Employee']['health_record'];

			if ($get_age <= (int)"29") {
				if ($get_gender == "m") {
					if ($get_health == "g") {
						// 4 = U-Quality, 5 = U-Produksi, 6 = U-Proses, 11= U-Keamanan
						if (($get_unit == "4") || ($get_unit == "5") || ($get_unit == "6") || ($get_unit == "11") ) {
							$this->request->data['Employee']['work_shift_id'] 	=	"2"; // Shift Malam
						} else {
							$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
						}
					} else { 
						$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
					}
				} else {
					$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
				}
			} else {
				$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
			}
			// if ($get_gender == "m") {
			// 	if ($get_age > (int)"35.5") {
			// 		$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
			// 	} else if ($get_age <= (int)"35.5") {
			// 		if ($get_distance > (int)"3.5") {
			// 			$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
			// 		} else if ($get_distance <= (int)"3.5") {
			// 			// HRD
			// 			if ($get_unit == "10") {
			// 				if ($this->Employee->getCountWorkUnit($get_unit, "1") <= (int)"2") {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
			// 				} else {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"2"; // Shift Malam
			// 				}
			// 			} else if ($get_unit == "11") {
			// 				if ($this->Employee->getCountWorkUnit($get_unit, "2") <= (int)"2") {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"2"; // Shift Siang
			// 				} else {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Malam
			// 				}
			// 			} else if ($get_unit == "8") {
			// 				if ($this->Employee->getCountWorkUnit($get_unit, "1") <= (int)"3") {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
			// 				} else {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"2"; // Shift Malam
			// 				}
			// 			} else if ($get_unit == "5") {
			// 				if ($this->Employee->getCountWorkUnit($get_unit, "1") <= (int)"8") {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
			// 				} else {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"2"; // Shift Malam
			// 				}
			// 			} else if ($get_unit == "6") {
			// 				if ($this->Employee->getCountWorkUnit($get_unit, "1") <= (int)"2") {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
			// 				} else {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"2"; // Shift Malam
			// 				}
			// 			} else if ($get_unit == "4") {
			// 				if ($this->Employee->getCountWorkUnit($get_unit, "1") <= (int)"4") {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
			// 				} else {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"2"; // Shift Malam
			// 				}
			// 			} else if ($get_unit == "2") {
			// 				if ($this->Employee->getCountWorkUnit($get_unit, "1") <= (int)"9") {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
			// 				} else {
			// 					$this->request->data['Employee']['work_shift_id'] 	=	"2"; // Shift Malam
			// 				}
			// 			} else {
			// 				$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
			// 			}

			// 		}
			// 	}
			// } else {
			// 	$this->request->data['Employee']['work_shift_id'] 	=	"1"; // Shift Siang
			// }
			// ===== Set Rule ===== //

			$this->{$this->ModelName}->set($this->request->data);
			$this->{$this->ModelName}->ValidateData();
			
			if($this->{$this->ModelName}->validates())
			{
				
				$save	=	$this->{$this->ModelName}->saveAll($this->request->data,array("validate"=>false));
				$ID		=	$this->{$this->ModelName}->getLastInsertId();
				
				
				if($this->request->data[$this->ModelName]['save_flag'] == "1")
					$this->redirect(array("action"=>"Index"));
				else
				{
					$this->Session->setFlash(
						'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><p>Congratulation data successfully saved!</p>',
						'default',
						array(
							'class' => 'alert alert-success',
						)
					);
					$this->redirect(array("action"=>"Add"));
				}	
			}//END IF VALIDATE
		}//END IF NOT EMPTY		
					
		$this->loadModel("WorkUnit");
		$this->loadModel("WorkShift");

		$work_unit_list 	=	$this->WorkUnit->find('list', 
									array(
										"fields"	=>	array(
											"WorkUnit.id",
											"WorkUnit.name"
										)
									)
								);

		$work_shift_list 	=	$this->WorkShift->find('list', 
									array(
										"fields"	=>	array(
											"WorkShift.id",
											"WorkShift.name"
										)
									)
								);
		$this->set(compact(
			"work_unit_list",
			"work_shift_list",
			"category_id_list"
		));
	}

	function Edit($ID = NULL, $page = 1, $viewpage = 50)
	{
		if ($this->access[$this->aco_id]["_update"] != "1")
		{
			$this->render("/Errors/no_access");
			return;
		}

		$this->{$this->ModelName}->set($this->request->data);
		$detail		=	$this->{$this->ModelName}->find('first', array(
							'conditions' => array(
								"{$this->ModelName}.id" => $ID
							),
							"recursive"	=>	2
						));
		
		if(empty($detail))
		{
		   $this->render("/Errors/error404");
		   return;
		}

		if(empty($this->data))
		{
			$this->request->data										=	$detail;
		}
		else
		{
			$this->{$this->ModelName}->set($this->request->data);
			$this->{$this->ModelName}->ValidateData();
			if($this->{$this->ModelName}->validates())
			{
				$save	=	$this->{$this->ModelName}->saveAll($this->request->data,array("validate"=>false));
				
				
				
				if($this->request->data[$this->ModelName]['save_flag'] == "1")
					$this->redirect(array("action"=>"Index"));
				else
				{
					$this->Session->setFlash(
						'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><p>Congratulation data successfully updated!</p>',
						'default',
						array(
							'class' => 'alert alert-success',
						)
					);
					$this->redirect(array("action"=>"Edit",$ID,$page,$viewpage));
				}
			}//END IF VALIDATE
		}
		
		$this->loadModel("WorkUnit");
		$this->loadModel("WorkShift");

		$work_unit_list 	=	$this->WorkUnit->find('list', 
									array(
										"fields"	=>	array(
											"WorkUnit.id",
											"WorkUnit.name"
										)
									)
								);

		$work_shift_list 	=	$this->WorkShift->find('list', 
									array(
										"fields"	=>	array(
											"WorkShift.id",
											"WorkShift.name"
										)
									)
								);

		$this->set(compact(
			"work_unit_list",
			"work_shift_list",
			"detail",
			"ID",
			"page",
			"viewpage"
		));
	}

	function Delete($ID = NULL)
	{
		if ($this->access[$this->aco_id]["_delete"] != "1") {
			   echo json_encode(array(
					   "data" => array(
							   "status" => "0",
							   "message" => __("No privileges")
					   )
			   ));
			   $this->autoRender = false;
			   $this->autoLayout = false;
			   return;
		}

		$detail       = $this->{$this->ModelName}->find('first', array(
			   'conditions' => array(
					   "{$this->ModelName}.id" => $ID
			   )
		));
		$resultStatus = "0";

		if (empty($detail)) {
			   $message      = __("Item not found.");
			   $resultStatus = "0";
		} else {
			   $this->{$this->ModelName}->delete($ID, false);
			   $message      = __("Data has deleted.");
			   $resultStatus = "1";
		}

		echo json_encode(array(
			   "data" => array(
					   "status" => $resultStatus,
					   "message" => $message
			   )
		));
		$this->autoRender = false;
	}

	function DeleteMultiple()
	{
		if ($this->access[$this->aco_id]["_delete"] != "1") {
			echo json_encode(array(
				   "data" => array(
						   "status"  => "0",
						   "message" => __("No privileges")
				   )
			));
			$this->autoRender	=	false;
			$this->autoLayout	=	false;
			return;
		}

		$id = explode(",", $_REQUEST["id"]);
		$this->{$this->ModelName}->deleteAll(array(
			   "id" => $id
		), false, true);
		$message = __("Data has deleted.");

		echo json_encode(array(
			   "data" => array(
					   "status" => "1",
					   "message" => $message
			   )
		));
		$this->autoRender = false;
	}
}