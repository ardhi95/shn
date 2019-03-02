<?php

App::uses('CakeNumber', 'Utility');
App::uses('Validation', 'Utility');

class SchedulesController extends AppController
{
	var $ControllerName		=	"Schedules";
	var $ModelName 			=	"Schedule";
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

		//DEFINE SALES
		$this->loadModel("User");
		$this->User->VirtualFieldActivated();
		
		$sales_id_list	=	$this->User->find("list",array(
								"conditions"	=>	array(
									"User.status"	=>	"1",
									"User.aro_id"	=>	"4"
								),
								"fields"		=>	array(
									"id",
									"fullname"
								),
								"order"			=>	"User.fullname asc"
							));
							
		//DEFINE STORES
		$this->loadModel("Store");
		$store_id_list	=	$this->Store->find("list",array(
								"conditions"	=>	array(
									"Store.status"	=>	"1"
								),
								"fields"		=>	array(
									"id",
									"name"
								),
								"order"			=>	"Store.name asc"
							));
						
		//DEFINE CHECKIN STATUS
		$this->loadModel("CheckinStatus");
		$checkin_status_list	=	$this->CheckinStatus->find("list",array(
										"fields"		=>	array(
											"id",
											"name"
										),
										"order"			=>	"CheckinStatus.name asc"
									));
		$this->set(compact(
			"page",
			"viewpage",
			"sales_id_list",
			"store_id_list",
			"checkin_status_list"
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
		$this->{$this->ModelName}->BindDefault(false);
		$this->{$this->ModelName}->Sales->virtualFields = array(
			"fullname"		=> "CONCAT(Sales.firstname,' ',COALESCE(Sales.lastname,''))",
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
							   "{$this->ModelName}.id" => "DESC"
							);
			$this->Session->write('Search.' . $this->ControllerName . 'Viewpage', $viewpage);
			$this->Session->write('Search.' . $this->ControllerName . 'Sort', (empty($this->params['named']['sort']) or !isset($this->params['named']['sort'])) ? $order : $this->params['named']['sort'] . " " . $this->params['named']['direction']);
		}

		//DEFINE SEARCH DATA
		if (!empty($this->request->data)) {
			$cond_search = array();
			$operand     = $this->request->data[$this->ModelName]['operator'];
			$this->Session->delete('Search.' . $this->ControllerName);

			
			if (!empty($this->request->data['Search']['sales_id'])) {
				   $cond_search["{$this->ModelName}.sales_id"] = $this->data['Search']['name'];
			}
			
			if (!empty($this->request->data['Search']['store_id'])) {
				   $cond_search["{$this->ModelName}.store_id"] = $this->data['Search']['owner'];
			}
			
			if (!empty($this->request->data['Search']['checkin_status_id'])) {
				   $cond_search["{$this->ModelName}.checkin_status_id"] = $this->data['Search']['address'];
			}
			
			if (!empty($this->data['Search']['schedule_start_date']) && empty($this->data['Search']['schedule_end_date'])) {
				   $cond_search["{$this->ModelName}.schedule_date >= "] = date("Y-m-d H:i:s",strtotime($this->data['Search']['schedule_start_date'] . " 00:00:00"));
			}

			if (empty($this->data['Search']['schedule_start_date']) && !empty($this->data['Search']['schedule_end_date'])) {
				   $cond_search["{$this->ModelName}.schedule_date <= "] = date("Y-m-d H:i:s",strtotime($this->data['Search']['schedule_end_date'] . " 23:59:59"));
			}

			if (!empty($this->data['Search']['schedule_start_date']) && !empty($this->data['Search']['schedule_end_date'])) {
				   $tmp		= $this->data['Search']['schedule_start_date'];
				   $START 	= (strtotime($this->data['Search']['schedule_start_date']) < strtotime($this->data['Search']['schedule_start_date'])) ? $this->data['Search']['schedule_end_date'] : $this->data['Search']['schedule_start_date'];
				   
				   $END		= ($this->data['Search']['schedule_end_date'] < $tmp) ? $tmp : $this->data['Search']['schedule_end_date'];
				   $cond_search["{$this->ModelName}.schedule_date BETWEEN ? AND ? "] = array(
						   date("Y-m-d H:i:s",strtotime($START . " 00:00:00")),
						   date("Y-m-d H:i:s",strtotime($END . " 23:59:59"))
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
										   'limit' 			=>	$viewpage,
                                           "maxLimit"       =>  1000,
										   "recursive"		=>	"2"
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
		 $this->{$this->ModelName}->VirtualFieldActivated();

		$order			=	$this->Session->read("Search.".$this->ControllerName."Sort");
		$viewpage			=	$this->Session->read("Search.".$this->ControllerName."Viewpage");
		$page				=	$this->Session->read("Search.".$this->ControllerName."Page");
		$conditions		=	$this->Session->read("Search.".$this->ControllerName."Conditions");

		$this->paginate		=	array(
									"{$this->ModelName}"	=>	array(
										"order"				=>	$order,
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
			$this->{$this->ModelName}->set($this->request->data);
			$this->{$this->ModelName}->ValidateData();
			
			if($this->{$this->ModelName}->validates())
			{
				
				$save			=	$this->{$this->ModelName}->saveAll($this->request->data,array("validate"=>false));
				
				$ID				=	$this->{$this->ModelName}->getLastInsertId();
				
				$send_notif		=	$this->request->data[$this->ModelName]['send_notif'];
				
				//DETAIL STORE
				$this->loadModel("Store");
				$storeDetail		=	$this->Store->find("first",array(
											"conditions"	=>	array(
												"Store.id"	=>	$this->request->data[$this->ModelName]["store_id"]
											)
										));
				
				
				if($send_notif == "1")
				{
					//=========== SAVE NOTIFICATION ================//
					$this->loadModel("Notification");
					$receiverUserId		=	$this->request->data[$this->ModelName]["sales_id"];
					$listReceiver		=	$this->User->find("list",array(
												"conditions"	=>	array(
													"User.id"	=>	$receiverUserId
												),
												"fields"		=>	array(
													"User.id",
													"User.gcm_id"
												)
											));
					
					if(!empty($listReceiver))
					{
						$arrGcmId			=	array();
						$title				=	"NEW SCHEDULE";
						$message			=	$description   		=	"Store : <b>".$storeDetail["Store"]["name"]."</b><br/>Date : <b>".$this->request->data[$this->ModelName]["schedule_date"]."</b>";
						$created			=	date("Y-m-d H:i:s");
						
						//CREATE NOTIFICATION GROUP
						$this->loadModel("NotificationGroup");
						$this->NotificationGroup->create();
						$this->NotificationGroup->saveAll(
							array(
								"title"			=>	$title,
								"message"		=>	$message,
								"description"	=>	$description,
								"created"		=>	$created
							),
							array(
								"validate"	=>	false
							)
						);
						$notificationGroupId	=	$this->NotificationGroup->id;
						
						foreach($listReceiver as $idReceiver =>	$gcm_id)
						{
							$this->Notification->create();
							$Notif["Notification"]["user_id"]					=	$idReceiver;
							$Notif["Notification"]["gcm_id"]					=	empty($gcm_id) ? NULL : $gcm_id;
							$Notif["Notification"]["notification_group_id"] 	=	$notificationGroupId;
							$Notif["Notification"]["order_id"]					=	$ID;
							$Notif["Notification"]["title"]						=	$title;
							$Notif["Notification"]["params"]					=	json_encode(array(
																						array(
																							"key"	=>	"id",
																							"val"	=>	"1"
																						),
																						array(
																							"key"	=>	"storeId",
																							"val"	=>	$this->request->data[$this->ModelName]["store_id"]
																						)
																					));
							$Notif["Notification"]["message"]					=	$message;
							$Notif["Notification"]["description"]				=	$description;
							$Notif["Notification"]["android_class_name"]		=	'DetailStoreActivity';
							$Notif["Notification"]["created"]					=	$created;
							
							if(!empty($gcm_id))
								$arrGcmId[]								=	$gcm_id;
							$this->Notification->save($Notif,array("validate"=>false));
						}
						
						$res 						=	array();
						$res['data']['title'] 		=	$this->settings['cms_app_name'];
						$res['data']['message'] 	=	$title;
						$res['data']['class_name'] 	=	'DetailStoreActivity';
						$res['data']['params'] 		=	array(
															  array(
																  "key"	=>	"id",
																  "val"	=>	"1"
															  ),
															  array(
																  "key"	=>	"storeId",
																  "val"	=>	$this->request->data[$this->ModelName]["store_id"]
															  )
														  );
						$res['data']['created'] 				=	$created;
						$res['data']['notification_group_id'] 	=	$notificationGroupId;
						
						$fields = array(
							"registration_ids" 		=>	$arrGcmId,
							"data" 					=>	$res,
							"priority"				=>	"high",
							"time_to_live"			=>	2419200
						);
						$push	=	$this->General->sendPushNotification($fields);
						/*
						Configure::write("debug","2");
						pr($push);
						pr(json_encode($fields));*/
					}
					//=========== SAVE NOTIFICATION ================//
				}
				
				$this->Session->setFlash(
					'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><p>Congratulation data successfully saved!</p>',
					'default',
					array(
						'class' => 'alert alert-success',
					)
				);
				if($this->request->data[$this->ModelName]['save_flag'] == "1")
					$this->redirect(array("action"=>"Index"));
				else
					$this->redirect(array("action"=>"Add"));
					
			}//END IF VALIDATE
		}//END IF NOT EMPTY		
		
		
		//DEFINE SALES
		$this->loadModel("User");
		$this->User->VirtualFieldActivated();
		
		$sales_id_list	=	$this->User->find("list",array(
								"conditions"	=>	array(
									"User.status"	=>	"1",
									"User.aro_id"	=>	"4"
								),
								"fields"		=>	array(
									"id",
									"fullname"
								),
								"order"			=>	"User.fullname asc"
							));
							
		//DEFINE STORES
		$this->loadModel("Store");
		$store_id_list	=	$this->Store->find("list",array(
								"conditions"	=>	array(
									"Store.status"	=>	"1"
								),
								"fields"		=>	array(
									"id",
									"name"
								),
								"order"			=>	"Store.name asc"
							));
						
		$this->set(compact(
			"sales_id_list",
			"store_id_list"
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
		$this->{$this->ModelName}->bindModel(array(
			"belongsTo"	=>	array(
				"Store"
			)
		));
		
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
			$this->request->data =	$detail;
			$this->request->data[$this->ModelName]['schedule_date']	=	date("d M Y H:i",strtotime($detail[$this->ModelName]['schedule_date']));
		}
		else
		{
			$this->{$this->ModelName}->set($this->request->data);
			$this->{$this->ModelName}->ValidateData();
			
			if($this->{$this->ModelName}->validates())
			{
				$save			=	$this->{$this->ModelName}->saveAll($this->request->data,array("validate"=>false));
				$send_notif		=	$this->request->data[$this->ModelName]["send_notif"];
				
				if($send_notif == "1")
				{
					if(
							$this->request->data[$this->ModelName]["sales_id"]	!=	$detail[$this->ModelName]["sales_id"] or
							$this->request->data[$this->ModelName]["store_id"]	!=	$detail[$this->ModelName]["store_id"] or
							$this->request->data[$this->ModelName]["schedule_date"]	!=	$detail[$this->ModelName]["schedule_date"]
						)
					{
						//DETAIL STORE
						$this->loadModel("Store");
						$storeDetail		=	$this->Store->find("first",array(
													"conditions"	=>	array(
														"Store.id"	=>	$this->request->data[$this->ModelName]["store_id"]
													)
												));
											
											
						//=========== SAVE NOTIFICATION ================//
						$this->loadModel("Notification");
						$receiverUserId		=	$this->request->data[$this->ModelName]["sales_id"];
						$listReceiver		=	$this->User->find("list",array(
													"conditions"	=>	array(
														"User.id"	=>	$receiverUserId
													),
													"fields"		=>	array(
														"User.id",
														"User.gcm_id"
													)
												));
						
						if(!empty($listReceiver))
						{
							$arrGcmId			=	array();
							
							
							$title    		=	"SCHEDULE UPDATED";
							if(
								$this->request->data[$this->ModelName]["sales_id"]	!=	$detail[$this->ModelName]["sales_id"]
							)
							{
								$title    		=	"NEW SCHEDULE";
							}
							
							$description   		=	$message	=	"<b>BEFORE</b><br>Store : <b>".$detail["Store"]["name"]."</b><br>Date : <b>".date("d F Y H:i",strtotime($detail[$this->ModelName]["schedule_date"]))."</b><br><br><b>UPDATE TO</b><br>Store : <b>".$storeDetail["Store"]["name"]."</b><br>Date : <b>".$this->request->data[$this->ModelName]["schedule_date"]."</b>";
							
							$created			=	date("Y-m-d H:i:s");
							
							//CREATE NOTIFICATION GROUP
							$this->loadModel("NotificationGroup");
							$this->NotificationGroup->create();
							$this->NotificationGroup->saveAll(
								array(
									"title"			=>	$title,
									"message"		=>	$message,
									"description"	=>	$description,
									"created"		=>	$created
								),
								array(
									"validate"		=>	false
								)
							);
							$notificationGroupId	=	$this->NotificationGroup->id;
							
							foreach($listReceiver as $idReceiver =>	$gcm_id)
							{
								$this->Notification->create();
								$Notif["Notification"]["user_id"]					=	$idReceiver;
								$Notif["Notification"]["gcm_id"]					=	empty($gcm_id) ? NULL : $gcm_id;
								$Notif["Notification"]["notification_group_id"] 	=	$notificationGroupId;
								$Notif["Notification"]["order_id"]					=	$ID;
								$Notif["Notification"]["title"]						=	$title;
								$Notif["Notification"]["params"]					=	json_encode(array(
																							array(
																								"key"	=>	"id",
																								"val"	=>	"1"
																							),
																							array(
																								"key"	=>	"storeId",
																								"val"	=>	$this->request->data[$this->ModelName]["store_id"]
																							)
																						));
								$Notif["Notification"]["message"]					=	$message;
								$Notif["Notification"]["description"]				=	$description;
								$Notif["Notification"]["android_class_name"]		=	'DetailStoreActivity';
								$Notif["Notification"]["created"]					=	$created;
								
								if(!empty($gcm_id))
									$arrGcmId[]								=	$gcm_id;
								$this->Notification->save($Notif,array("validate"=>false));
							}
							
							$res 						=	array();
							$res['data']['title'] 		=	$this->settings["cms_app_name"];
							$res['data']['message'] 	=	$title;
							$res['data']['class_name'] 	=	'DetailStoreActivity';
							$res['data']['params'] 		=	array(
																  array(
																	  "key"	=>	"id",
																	  "val"	=>	"1"
																  ),
																   array(
																	  "key"	=>	"storeId",
																	  "val"	=>	$this->request->data[$this->ModelName]["store_id"]
																  )
															  );
							$res['data']['created'] 	=	$created;
							$res['data']['notification_group_id'] 	=	$notificationGroupId;
							
							$fields = array(
								"registration_ids" 		=>	$arrGcmId,
								"data" 					=>	$res,
								"priority"				=>	"high",
								"time_to_live"			=>	2419200
							);
							$push	=	$this->General->sendPushNotification($fields);
							/*
							Configure::write("debug","2");
							pr($push);
							pr(json_encode($fields));*/
						}
						//=========== SAVE NOTIFICATION ================//
					}
				}
				
				$this->Session->setFlash(
					'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><p>Congratulation data successfully updated!</p>',
					'default',
					array(
						'class' => 'alert alert-success',
					)
				);
				if($this->request->data[$this->ModelName]['save_flag'] == "1")
					$this->redirect(array("action"=>"Index"));
				else
					$this->redirect(array("action"=>"Edit",$ID,$page,$viewpage));

			}//END IF VALIDATE
		}
		
		//DEFINE SALES
		$this->loadModel("User");
		$this->User->VirtualFieldActivated();
		
		$sales_id_list	=	$this->User->find("list",array(
								"conditions"	=>	array(
									"User.status"	=>	"1",
									"User.aro_id"	=>	"4"
								),
								"fields"		=>	array(
									"id",
									"fullname"
								),
								"order"			=>	"User.fullname asc"
							));
							
		//DEFINE STORES
		$this->loadModel("Store");
		$store_id_list	=	$this->Store->find("list",array(
								"conditions"	=>	array(
									"Store.status"	=>	"1"
								),
								"fields"		=>	array(
									"id",
									"name"
								),
								"order"			=>	"Store.name asc"
							));
		
		$this->set(compact(
			"detail",
			"sales_id_list",
			"store_id_list",
			"ID",
			"page",
			"viewpage"
		));
	}
	
	function Detail($ID = NULL, $page = 1, $viewpage = 50)
	{
		if ($this->access[$this->aco_id]["_update"] != "1")
		{
			$this->render("/Errors/no_access");
			return;
		}

		$this->loadModel($this->ModelName);
		$this->{$this->ModelName}->BindDefault(false);
		$this->{$this->ModelName}->Sales->virtualFields = array(
			"fullname"		=> "CONCAT(Sales.firstname,' ',COALESCE(Sales.lastname,''))",
		);
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
		
		
		//CHECK RIVAL INFO
		$this->loadModel("CompetitorProduct");
		$joins			=	array(
								array(
									"table"			=>	"schedule_logs",
									"alias"			=>	"ScheduleLog",
									'type'			 => 'LEFT',
									"conditions"	=>	array(
										"ScheduleLog.competitor_product_id	=	CompetitorProduct.id",
										"ScheduleLog.schedule_id	=	$ID"
									)
								)
							);
							
		$scheduleLog	=	$this->CompetitorProduct->find("all",array(
								"order"		=>	"CompetitorProduct.name asc",
								"joins"		=>	$joins,
								"fields"	=>	array(
									"CompetitorProduct.*",
									"ScheduleLog.*"
								)
							));
		
		//CHECK ORDER
		$this->loadModel("Order");
		$this->Order->bindModel(array(
			"hasMany"	=>	array(
				"OrderList"
			)
		));
		$this->Order->OrderList->bindModel(array(
			"belongsTo"	=>	array(
				"Product"
			)
		));
		
		$checkOrder			=	$this->Order->find("first",array(
									"conditions"	=>	array(
										"Order.schedule_id"	=>	$ID
									),
									"order"			=>	"Order.id desc",
									"recursive"		=>	3
								));
								
								
		//HISTORY ORDER
		$listOrder			=	$this->Order->find("list",array(
									"conditions"	=>	array(
										"Order.schedule_id"	=>	$ID
									),
									"fields"		=>	array(
										"id"
									)
								));
		
		$this->loadModel("OrderLog");
		$this->OrderLog->bindModel(array(
			"hasMany"	=>	array(
				"OrderLogList"
			),
			"belongsTo"	=>	array(
				"OrderLogType"
			)
		),false);
		
		$this->OrderLog->OrderLogList->bindModel(array(
			"belongsTo"	=>	array(
				"Product"
			)
		));
		$orderLog			=	$this->OrderLog->find("all",array(
									"conditions"	=>	array(
										"OrderLog.order_id"	=>	$listOrder
									),
									"order"			=>	"OrderLog.order_id asc",
									"recursive"		=>	3
								));
		pr($orderLog);
		$this->set(compact(
			"detail",
			"checkOrder",
			"ID",
			"page",
			"viewpage",
			"scheduleLog",
			"orderLog"
		));
	}

	function ChangeStatus($ID = NULL, $status)
	{
		if ($this->access[$this->aco_id]["_update"] != "1") {
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

		$detail = $this->{$this->ModelName}->find('first', array(
			'conditions' => array(
				"{$this->ModelName}.id" => $ID
			)
		));

		$resultStatus = "0";
		if (empty($detail)){
			$message = __("Item not found.");
		} else {
			$data[$this->ModelName]["id"]     	=	$ID;
			$data[$this->ModelName]["status"] 	=	$status;
			$this->{$this->ModelName}->save($data);
			$message      						=	__("Data has updated.");
			$resultStatus 						=	"1";
		}

		echo json_encode(array(
			"data" => array(
				"status"	=>	$resultStatus,
				"message"	=>	$message
			)
		));
		$this->autoRender = false;
	}

	function ChangeStatusMultiple()
	{
		if ($this->access[$this->aco_id]["_update"] != "1") {
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

		$ID     =	explode(",", $_REQUEST["id"]);
		$status =	$_REQUEST["status"];

		$this->{$this->ModelName}->updateAll(array(
			"status" => "'" . $status . "'"
		), array(
			"{$this->ModelName}.id" => $ID
		));

		$message = "Data has updated.";
		echo json_encode(array(
			"data" => array(
				"status" => "1",
				"message" => $message
			)
		));
		$this->autoRender = false;
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


	function MoveUp($ID = NULL)
	{
		if ($this->access[$this->aco_id]["_update"] != "1") {
			   echo json_encode(array(
					   "data" => array(
							   "status" => "0",
							   "message" => __("No privileges")
					   )
			   ));
			   $this->autoRender = false;
			   $this->autoLayout	=	false;
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
			   $this->{$this->ModelName}->moveUp($ID,1);
			   $message      = __("Item has successfully move up.");
			   $resultStatus = "1";
		}

		echo json_encode(array(
			   "data" => array(
					   "status" 	=> $resultStatus,
					   "message" 	=> $message
			   )
		));
		$this->autoRender = false;
	}

	function MoveDown($ID = NULL)
	{
		if ($this->access[$this->aco_id]["_update"] != "1") {
			echo json_encode(array(
				   "data" => array(
						   "status"  => "0",
						   "message" => __("No privileges")
				   )
			));
			$this->autoRender = false;
			$this->autoLayout	=	false;
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
			   $this->{$this->ModelName}->moveDown($ID,1);
			   $message      = __("Item has successfully move down.");
			   $resultStatus = "1";
		}

		echo json_encode(array(
			   "data" => array(
					   "status" 	=> $resultStatus,
					   "message" 	=> $message
			   )
		));
		$this->autoRender = false;
	}
}