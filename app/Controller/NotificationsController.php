<?php

App::uses('CakeNumber', 'Utility');
App::uses('Validation', 'Utility');

class NotificationsController extends AppController
{
	var $ControllerName		=	"Notifications";
	var $ModelName 			=	"NotificationGroup";
	var $helpers 			=	array("Text","General");
	var $aco_id;

	function beforeFilter()
	{
		parent::beforeFilter();
		$this->set("ControllerName", $this->ControllerName);
		$this->set("ModelName", $this->ModelName);
		$this->loadModel($this->ModelName);

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

			
			if (!empty($this->request->data['Search']['name'])) {
				   $cond_search["{$this->ModelName}.name LIKE "] = "%".$this->data['Search']['name']."%";
			}
			
			if (!empty($this->request->data['Search']['owner'])) {
				   $cond_search["{$this->ModelName}.owner LIKE "] = "%".$this->data['Search']['owner']."%";
			}
			
			if (!empty($this->request->data['Search']['address'])) {
				   $cond_search["{$this->ModelName}.address LIKE "] = "%".$this->data['Search']['address']."%";
			}
			
			if (!empty($this->request->data['Search']['phone1'])) {
				   $cond_search["{$this->ModelName}.phone1 LIKE "] = "%".$this->data['Search']['phone1']."%";
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
										   'limit' 			=>	$viewpage,
                                           "maxLimit"       =>  1000,
										   "recursive"		=>	"3"
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
				$ID				=	$notificationGroupId	=	$this->{$this->ModelName}->getLastInsertId();
				
				$recipient_id	=	$this->request->data[$this->ModelName]['recipient_id'];
				$title			=	$this->request->data[$this->ModelName]['title'];
				$message    	=	$this->request->data[$this->ModelName]['message'];
				$description   	=	$this->request->data[$this->ModelName]['description'];
				$created		=	date("Y-m-d H:i:s");
				
				//SAVE NOTIFICATION
				$this->loadModel('User');
				$listReceiver		=	$this->User->find("list",array(
											"conditions"	=>	array(
												"User.id"	=>	$recipient_id
											),
											"fields"		=>	array(
												"User.id",
												"User.gcm_id"
											)
										));
										
				$this->loadModel("Notification");
				if(!empty($listReceiver))
				{
					$arrGcmId			=	array();
					foreach($listReceiver as $idReceiver =>	$gcm_id)
					{
						$this->Notification->create();
						$Notif["Notification"]["user_id"]					=	$idReceiver;
						$Notif["Notification"]["gcm_id"]					=	empty($gcm_id) ? NULL : $gcm_id;
						$Notif["Notification"]["notification_group_id"] 	=	$notificationGroupId;
						$Notif["Notification"]["order_id"]					=	NULL;
						$Notif["Notification"]["title"]						=	$title;
						
						$Notif["Notification"]["params"]					=	json_encode(array(
																					array(
																						"key"	=>	"description",
																						"val"	=>	$description
																					),
																					array(
																						"key"	=>	"title",
																						"val"	=>	$title
																					)
																				));
																				
						$Notif["Notification"]["message"]					=	$message;
						$Notif["Notification"]["description"]				=	$description;
						$Notif["Notification"]["android_class_name"]		=	'DetailNotificationActivity';
						$Notif["Notification"]["created"]					=	$created;
						
						if(!empty($gcm_id))
							$arrGcmId[]	=	$gcm_id;
							
						$this->Notification->save($Notif,array("validate"=>false));
						$notifId		=	$this->Notification->id;
						
						/*$params			=	json_encode(array(
												array(
													"key"	=>	"notification_id",
													"val"	=>	$notifId
												)
											));
											
						$this->Notification->updateAll(
							array(
								"params"			=>	"'".$params."'"	
							),
							array(
								"Notification.id"	=>	$notifId
							)
						);*/
						
					}//ENDFOR
					
					$res 						=	array();
					$res['data']['title'] 		=	$this->settings["cms_app_name"];
					$res['data']['message'] 	=	$title;
					$res['data']['class_name'] 	=	'NotificationsActivity';
					$res['data']['params'] 		=	array(
														  array(
															  "key"	=>	"id",
															  "val"	=>	"1"
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
				}
				$this->redirect(array("action"=>"Index"));
					
			}//END IF VALIDATE
		}//END IF NOT EMPTY		
		
		
		//DEFINE SALES
		$this->loadModel("User");
		$this->User->virtualFields = array(
			"fullname"		=> "CONCAT(User.firstname,' ',COALESCE(User.lastname,''))",
		);
		
		$sales_id_list		=	$this->User->find("list",array(
									"conditions"	=>	array(
										"User.aro_id"	=>	4,
										"User.status"	=>	1
									),
									"order"			=>	"User.firstname asc",
									"fields"		=>	array(
										"id",
										"fullname"
									)
								));
					
		$this->set(compact(
			"sales_id_list"
		));
	}
}