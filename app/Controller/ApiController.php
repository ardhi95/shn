<?php
class ApiController extends AppController
{
	public $uses			=	NULL;
	public $settings 		=	false;
	public $debug 			=	false;
	public $components 		=	array("General");
	
	public function beforeFilter()
	{
		//prepare for logging
		/*$requestLog = "\n===========START===========\n";
		foreach($_REQUEST as $key => $requested) {
			$requestLog .= "request['".$key."'] = ".$requested."\n";
		}
		$requestLog .= "===========END===========\n";
		CakeLog::write('apiLog', $requestLog);*/
		
		$this->autoRender = false;
		$this->autoLayout = false;
		define("ERR_00",__("Success"));
		define("ERR_01",__("Wrong username or password"));
		define("ERR_02",__("Data not found"));
		define("ERR_03",__("Validate Failed"));
		define("ERR_04",__("Parameter Not Completed!"));
		define("ERR_05",__("Failed send verification code!"));
		$token			=	(isset($_REQUEST['token'])) ? $_REQUEST['token'] : "";

		if($token !== "e56d867b3506917898f348720130b55d")
		{
			echo json_encode(array("status"=>false,"message"=>__("Invalid Token"),"data"=>NULL,"code"=>"01"));
			exit;
		}
		
		//SETTING
		$this->settings = Cache::read('settings', 'long');
		if(!$this->settings || (isset($_GET['debug']))) {

			$this->loadModel('Setting');
			$settings			=	$this->Setting->find('first');
			$this->settings		=	$settings['Setting'];
			Cache::write('settings', $this->settings, 'long');
		}
		$this->set('settings',$this->settings);
	}

	function GetDataNeeded()
	{
		
		$status				=	false;
		$message			=	ERR_04;
		$code				=	"04";
		$data				=	array();
		$User				=	array();
		$user_id			=	NULL;
		$totalTarget		=	0;
		$totalOrder			=	0;
		
		$totalCheckin		=	0;
		$totalAddStore		=	0;
		
		$Notif				=	array();
		$TotalNotif			=	0;
		
		if(isset($_REQUEST['user_id']))
			$user_id	=	$_REQUEST['user_id'];
			
		$request["User"]["gcm_id"]				=	isset($_REQUEST["gcm_id"]) ? (!empty($_REQUEST["gcm_id"]) ? $_REQUEST["gcm_id"] : NULL) : NULL;
		
			
		//SETTINGS
		$settings = Cache::read('settings', 'long');
		if(!$settings || (isset($_GET['debug']))) {

			$this->loadModel('Setting');
			$settings			=	$this->Setting->find('first');
			$settings			=	$settings['Setting'];
			Cache::write('settings', $settings, 'long');
		}
		
		if(!empty($user_id))
		{
			$this->loadModel("User");
			$this->User->BindImage(false);
			$User	=	$this->User->find("first",array(
							"conditions"	=>	array(
								"User.status"	=>	"1",
								"User.id"		=>	$user_id
							)
						));
						
			//GET SALES TARGET
			$this->loadModel("Order");
			$DataTarget			=	$this->Order->GetTotalOrderSales($user_id);
			$totalTarget		=	$DataTarget["totalTarget"];
			$totalOrder			=	$DataTarget["totalOrder"];
			
			//TOTAL CHECKIN
			$this->loadModel("Schedule");
			$totalCheckin		=	$this->Schedule->find("count",array(
										"conditions"	=>	array(
											"Schedule.sales_id"				=>	$user_id,
											"Schedule.checkin_status_id"	=>	"2"
										)
									));
									
			//TOTAL ADD STORE
			$this->loadModel("Store");
			$totalAddStore		=	$this->Store->find("count",array(
										"conditions"	=>	array(
											"Store.creator_id"				=>	$user_id
										)
									));
									
									
			if (!empty($request["User"]["gcm_id"]) && $User['User']['gcm_id'] != $request["User"]["gcm_id"])
			{
				$this->User->updateAll(
					array(
						"gcm_id"				=>	NULL
					),
					array(
						"User.gcm_id"			=>	$request["User"]["gcm_id"]
					)
				);
				
				$this->User->updateAll(
					array(
						"gcm_id"				=>	"'".$request["User"]["gcm_id"]."'"
					),
					array(
						"User.id"				=>	$User["User"]["id"]
					)
				);				
			}
			
			//CHECK NOTIFICATION
			$this->loadModel("Notification");
			$Notif			=	$this->Notification->find("all",array(
									"conditions"	=>	array(
										"Notification.user_id"		=>	$user_id,
										"Notification.is_arrival"	=>	0
									)
								));
						
			$TotalNotif		=	$this->Notification->find("count",array(
									"conditions"	=>	array(
										"Notification.user_id"		=>	$user_id,
										"Notification.is_readed"	=>	0
									)
								));
						
			$this->Notification->updateAll(
				array(
					"is_arrival"	=>	"1",
					"arrival_date"	=>	"'".date("Y-m-d H:i:s")."'"
				),
				array(
					"Notification.user_id"		=>	$user_id
				)
			);
		}
		
		
		//PRODUCT
		$this->loadModel("Product");
		$Product			=	$this->Product->find("all",array(
									"conditions"	=>	array(
										"Product.status"	=>	"1"
									),
									"order"			=>	"Product.name ASC"
								));
								
		//CITY
		$this->loadModel("City");
		$City				=	$this->City->find("all",array(
									"conditions"	=>	array(
										"City.status"	=>	"1"
									),
									"order"			=>	"City.name ASC"
								));
								
		$out				=	array(
			"Setting"				=>	$settings,
			"UserData"				=>	$User,
			"SalesTarget"			=>	$totalTarget,
			"TotalOrder"			=>	$totalOrder,
			"TotalCheckin"			=>	$totalCheckin,
			"TotalAddStore"			=>	$totalAddStore,
			"Product"				=>	$Product,
			"City"					=>	$City,
			"request"				=>	$_REQUEST,
			"file"					=>	$_FILES,
			"Notif"					=>	$Notif,
			"TotalNotif"			=>	$TotalNotif
		);

		$json	=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function Login()
	{
		$status			=	false;
		$message		=	ERR_04;
		$code			=	"04";
		$data			=	array();
        $checkinDetail  =   array();
		$totalTarget	=	0;
		$totalOrder		=	0;
		$totalCheckin	=	0;
		$totalAddStore	=	0;
		
		$request["User"]["email"]		=	empty($_REQUEST["email"]) ? "" : $_REQUEST["email"];
		$request["User"]["password"]	=	empty($_REQUEST["password"]) ? "" : $_REQUEST["password"];
		$request["User"]["gcm_id"]				=	isset($_REQUEST["gcm_id"]) ? (!empty($_REQUEST["gcm_id"]) ? $_REQUEST["gcm_id"] : NULL) : NULL;
		

		$this->loadModel('User');
		$this->User->set($request);
		$this->User->ValidateLoginApp();


		$error									=	$this->User->InvalidFields();
		if(empty($error))
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";

			$this->User->BindDefault(true);
			$this->User->VirtualFieldActivated();
			$this->User->BindImage(false);
			
			$data		=	$this->User->find('first',array(
								"conditions"	=>	array(
									"User.email"		=>	$request["User"]["email"],
									"User.password"		=>	$this->General->my_encrypt($request["User"]["password"]),
									"User.status"		=>	"1"
								)
							));
			
			//GET SALES TARGET
			$this->loadModel("Order");
			$DataTarget			=	$this->Order->GetTotalOrderSales($data["User"]["id"]);
			$totalTarget		=	$DataTarget["totalTarget"];
			$totalOrder			=	$DataTarget["totalOrder"];
			
			//TOTAL CHECKIN
			$this->loadModel("Schedule");
			$totalCheckin		=	$this->Schedule->find("count",array(
										"conditions"	=>	array(
											"Schedule.sales_id"				=>	$data["User"]["id"],
											"Schedule.checkin_status_id"	=>	"2"
										)
									));
									
			//TOTAL ADD STORE
			$this->loadModel("Store");
			$totalAddStore		=	$this->Store->find("count",array(
										"conditions"	=>	array(
											"Store.creator_id"				=>	$data["User"]["id"]
										)
									));
									
									
			
			//UPDATE GCM ID
			if (!empty($request["User"]["gcm_id"]))
			{
				$this->User->updateAll(
					array(
						"gcm_id"				=>	NULL
					),
					array(
						"User.gcm_id"			=>	$request["User"]["gcm_id"]
					)
				);
				
				$this->User->updateAll(
					array(
						"gcm_id"				=>	"'".$request["User"]["gcm_id"]."'"
					),
					array(
						"User.id"				=>	$data["User"]["id"]
					)
				);
			}
			
			
		}
		else
		{
			$status		=	false;
			foreach($error as $k => $v)
			{
				$message	=	$v[0];
				break;
			}
			$code		=	"03";
			$data		=	null;
		}

		$out			=	array(
			"status"				=>	$status,
			"message"				=>	$message,
			"data"					=>	$data,
			"SalesTarget"			=>	$totalTarget,
			"TotalOrder"			=>	$totalOrder,
			"TotalCheckin"			=>	$totalCheckin,
			"TotalAddStore"			=>	$totalAddStore,
			"code"					=>	$code,
			"request"				=>	$_REQUEST,
			"file"					=>	$_FILES
		);


		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function Schedule()
	{
		$status			=	false;
		$message		=	ERR_03;
		$data			=	null;
		$code			=	"03";
		$page			=	(empty($_REQUEST['page'])) ? 1 : $_REQUEST['page'];
		$user_id		=	(empty($_REQUEST['user_id'])) ? "" : $_REQUEST['user_id'];
		
		
		$this->loadModel("Schedule");
		$this->Schedule->bindModel(array(
			"belongsTo"	=>	array(
				"Store"
			),
			"hasOne"	=>	array(
				"ScheduleLog"
			)
		));
			
		$conditions			=	array(
									"Schedule.sales_id"			=>	$user_id,
									"DATE_FORMAT(Schedule.schedule_date,'%Y-%m-%d')"	=>	date("Y-m-d")
								);
								
		$this->paginate		=	array(
			"Schedule"	=>	array(
				"order"			=>	"Schedule.schedule_date asc",
				"page"			=>	$page,		
				"limit"			=>	10,
				"conditions"	=>	$conditions,
				"recursive"		=>	3,
				"group"			=>	"Schedule.id"
			)
		);
		
		try
		{
			$fData			=	$this->paginate("Schedule");
		}
		catch(NotFoundException $e)
		{
			$fData		=	array();
		}
		
		
		if(empty($fData))
		{
			$status		=	true;
			$message	=	ERR_02;
			$data		=	array();
			$code		=	"02";
		}
		else
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
			$data		=	$fData;
		}
		
		$out	=	array(
						"status"	=>	$status,
						"message"	=>	$message,
						"data"		=>	$data,
						"code"		=>	$code,
						"pageCount"	=>	$this->params['paging']['Schedule']['pageCount'],
						"page"		=>	$this->params['paging']['Schedule']['page'],
						"totalData"	=>	$this->params['paging']['Schedule']['count'],
						"nextPage"	=>	$this->params['paging']['Schedule']['nextPage'],
						"request"	=>	$_REQUEST
					);
		
		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function Checkin()
	{
		$status			=	false;
		$message		=	ERR_04;
		$code			=	"04";
		$data			=	array();
        $checkinDetail  =   array();
		$totalCheckin	=	"0";
		
		$request["Schedule"]["id"]	=	$scheduleId		=	empty($_REQUEST["schedule_id"]) ? "" : $_REQUEST["schedule_id"];
		
		$request["Schedule"]["sales_id"]	=	$salesId	=	empty($_REQUEST["sales_id"]) ?NULL : $_REQUEST["sales_id"];
		
		$this->loadModel('Schedule');
		$this->Schedule->set($request);
		$this->Schedule->ValidateCheckin();
		$error									=	$this->Schedule->InvalidFields();
		
		if(empty($error))
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
			
			$this->Schedule->updateAll(
				array(
					"checkin_status_id"		=>	"2",
					"checkin_date"			=>	"'".date("Y-m-d H:i:s")."'"
				),
				array(
					"Schedule.id"			=>	$scheduleId
				)
			);
			
			$this->Schedule->bindModel(array(
				"hasOne"	=>	array(
					"ScheduleLog"
				),
				"belongsTo"	=>	array(
					"Store"
				)
			));
			
			$data		=	$this->Schedule->find("first",array(
								"conditions"	=>	array(
									"Schedule.id"	=>		$scheduleId
								),
								"group"			=>	"Schedule.id"
							));
							
			//TOTAL CHECKIN
			$this->loadModel("Schedule");
			$totalCheckin		=	$this->Schedule->find("count",array(
										"conditions"	=>	array(
											"Schedule.sales_id"				=>	$salesId,
											"Schedule.checkin_status_id"	=>	"2"
										)
									));
									
		}
		else
		{
			$status		=	false;
			foreach($error as $k => $v)
			{
				$message	=	$v[0];
				break;
			}
			$code		=	"03";
			$data		=	null;
		}

		$out			=	array(
			"status"				=>	$status,
			"message"				=>	$message,
			"data"					=>	$data,
			"TotalCheckin"			=>	$totalCheckin,
			"code"					=>	$code,
			"request"				=>	$_REQUEST,
			"file"					=>	$_FILES
		);


		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function GetRivalProduct()
	{
		$status			=	false;
		$message		=	ERR_03;
		$data			=	null;
		$code			=	"03";
		$Schedule		=	array();
		$EnabledEdit	=	true;

		$scheduleId		=	empty($_REQUEST["schedule_id"]) ? "" : $_REQUEST["schedule_id"];
		$salesId		=	empty($_REQUEST["user_id"]) ? "" : $_REQUEST["user_id"];
		
		$this->loadModel("CompetitorProduct");
		$this->CompetitorProduct->bindModel(array(
			"hasOne"	=>	array(
				"ScheduleLog"	=>	array(
					"conditions"	=>	array(
						"ScheduleLog.schedule_id"	=>	$scheduleId
					)
				)
			)
		));
		
		$conditions			=	array();
		$fData				=	$this->CompetitorProduct->find("all",array(
									"order"			=>	"CompetitorProduct.name asc",
									"conditions"	=>	array(
										"CompetitorProduct.status"	=>	"1"
									)
								));
		
		if(empty($fData))
		{
			$status		=	false;
			$message	=	ERR_02;
			$data		=	array();
			$code		=	"02";
		}
		else
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
			$data		=	$fData;
			
			//CHECK DETAIL SCHEDULE
			$this->loadModel("Schedule");
			$Schedule	=	$this->Schedule->find("first",array(
				"conditions"	=>	array(
					"Schedule.id"	=>	$scheduleId
				)
			));
			
			$firstInputData	=	$Schedule["Schedule"]["first_input_data"];
			if(!is_null($firstInputData))
			{
				$firstInputDataTimeStamp	=	strtotime($firstInputData);
				$now	=	time();
				
				if(($now - $firstInputDataTimeStamp) > (3600 * 1))
				{
					$EnabledEdit = false;
				}
			}
		}
		
		$out	=	array(
						"status"		=>	$status,
						"message"		=>	$message,
						"data"			=>	$data,
						"code"			=>	$code,
						"Schedule"		=>	!empty($Schedule) ? $Schedule["Schedule"] : $Schedule,
						"EnabledEdit"	=>	$EnabledEdit,
						"request"		=>	$_REQUEST
					);
		
		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function ValidateCheckRival()
	{
		$status			=	false;
		$message		=	ERR_04;
		$code			=	"04";
		$data			=	array();
        $checkinDetail  =   array();

		$request["ScheduleLog"]["schedule_id"]				=	$schedule_id	=	empty($_REQUEST["schedule_id"]) ? "" : $_REQUEST["schedule_id"];
		
		$request["ScheduleLog"]["sales_id"]	=	$salesId	=	empty($_REQUEST["sales_id"]) ? "" : $_REQUEST["sales_id"];
		
		$request["ScheduleLog"]["competitor_product_id"]	=	$competitor_product_id	=	empty($_REQUEST["competitor_product_id"]) ? NULL : $_REQUEST["competitor_product_id"];
		
		$request["ScheduleLog"]["qty"] 						=	$qty	=	empty($_REQUEST["qty"]) ? NULL : $_REQUEST["qty"];
		
		$request["ScheduleLog"]["check_rival_notes"]		=	$notes	=	empty($_REQUEST["check_rival_notes"]) ? NULL : $_REQUEST["check_rival_notes"];

		$this->loadModel("ScheduleLog");
		$this->ScheduleLog->set($request);
		$this->ScheduleLog->ValidateCheckRival();
		$error									=	$this->ScheduleLog->InvalidFields();
		
		if(empty($error))
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
		}
		else
		{
			$status		=	false;
			foreach($error as $k => $v)
			{
				$message	=	$v[0];
				break;
			}
			$code		=	"03";
			$data		=	null;
		}

		$out			=	array(
			"status"				=>	$status,
			"message"				=>	$message,
			"data"					=>	$data,
			"code"					=>	$code,
			"request"				=>	$_REQUEST,
			"file"					=>	$_FILES
		);


		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function ValidateAddSales()
	{
		$status			=	false;
		$message		=	ERR_04;
		$code			=	"04";
		$data			=	array();

		$request["Order"]["sales_id"]		=	$salesId	=	empty($_REQUEST["sales_id"]) ? "" : $_REQUEST["sales_id"];
		
		$request["Order"]["schedule_id"]	=	$schedule_id	=	empty($_REQUEST["schedule_id"]) ? "" : $_REQUEST["schedule_id"];
		
		$request["Order"]["product_id"]		=	$product_id		=	empty($_REQUEST["product_id"]) ? "" : $_REQUEST["product_id"];
		
		$request["Order"]["qty"]			=	$qty	=	empty($_REQUEST["qty"]) ? "" : $_REQUEST["qty"];
		
		$request["Order"]["notes"]			=	$notes	=	empty($_REQUEST["notes"]) ? NULL : $_REQUEST["notes"];
		
		$request["Order"]["created"]		=	$dateTime	=	date("Y-m-d H:i:s");
		$request["Order"]["modified"]		=	$dateTime;
		
		
		$this->loadModel("Order");
		$this->loadModel("OrderLog");
		$this->loadModel("OrderList");
		$this->loadModel("OrderLogList");
		
		$this->Order->set($request);
		$this->Order->ValidateAddSales();
		$error	=	$this->Order->InvalidFields();
		
		if(empty($error))
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
		}
		else
		{
			$status		=	false;
			foreach($error as $k => $v)
			{
				$message	=	$v[0];
				break;
			}
			$code		=	"03";
			$data		=	null;
		}

		//GET SALES TARGET
		$this->loadModel("Order");
		$DataTarget			=	$this->Order->GetTotalOrderSales($salesId);
		$totalTarget		=	$DataTarget["totalTarget"];
		$totalOrder			=	$DataTarget["totalOrder"];
			
		$out			=	array(
			"status"				=>	$status,
			"message"				=>	$message,
			"data"					=>	$data,
			"code"					=>	$code,
			"totalTarget"			=>	$totalTarget,
			"totalOrder"			=>	$totalOrder,
			"request"				=>	$_REQUEST,
			"file"					=>	$_FILES
		);


		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	
	function Order()
	{
		$status			=	false;
		$message		=	ERR_04;
		$code			=	"04";
		$data			=	array();
        $checkinDetail  =   array();

		$request["ScheduleLog"]["schedule_id"]				=	$schedule_id	=	empty($_REQUEST["schedule_id"]) ? "" : $_REQUEST["schedule_id"];
		
		$request["ScheduleLog"]["sales_id"]					=	$salesId	=	empty($_REQUEST["sales_id"]) ? "" : $_REQUEST["sales_id"];
		
		$request["ScheduleLog"]["competitor_product_id"]	=	$competitor_product_id	=	empty($_REQUEST["competitor_product_id"]) ? NULL : $_REQUEST["competitor_product_id"];
		
		$request["ScheduleLog"]["qty"] 						=	$qtyRival	=	empty($_REQUEST["qty_rival"]) ? NULL : $_REQUEST["qty_rival"];
		
		$request["ScheduleLog"]["check_rival_notes"]		=	$check_rival_notes	=	empty($_REQUEST["check_rival_notes"]) ? NULL : $_REQUEST["check_rival_notes"];
		
		$request["Order"]["sales_id"]						=	$salesId;
		
		$request["Order"]["schedule_id"]					=	$schedule_id;
		
		$request["Order"]["product_id"]						=	$product_id		=	empty($_REQUEST["product_id"]) ? "" : $_REQUEST["product_id"];
		
		$request["Order"]["qty"]							=	$qtyProduct		=	empty($_REQUEST["qty_product"]) ? NULL : $_REQUEST["qty_product"];
		
		$request["Order"]["notes"]							=	$notes			=	empty($_REQUEST["notes"]) ? NULL : $_REQUEST["notes"];
		
		$request["Order"]["created"]						=	$dateTime		=	date("Y-m-d H:i:s");
		$request["Order"]["modified"]						=	$dateTime;


		$this->loadModel("ScheduleLog");
		$this->loadModel("Order");
		$this->loadModel("OrderLog");
		$this->loadModel("OrderList");
		$this->loadModel("OrderLogList");
		
		/*$this->ScheduleLog->find("all");
		$this->OrderLog->find("all");
		$this->OrderList->find("all");
		$this->OrderLogList->find("all");
		$this->OrderLogList->find("all");*/
		
		$error	=	array();
		if(empty($error))
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
			
			//=================== SAVE SCHEDULE LOG ===================//
			if(is_array($competitor_product_id))
			{
				if(!empty($competitor_product_id))
				{
					$this->ScheduleLog->deleteAll(array(
						"ScheduleLog.schedule_id"	=>	$schedule_id
					));
					
					foreach($competitor_product_id as $k => $v)
					{
						$this->ScheduleLog->create();
						$this->ScheduleLog->saveAll(
							array(
								"schedule_id"				=>	$schedule_id,
								"competitor_product_id"		=>	$v,
								"qty"						=>	$qtyRival[$k]
							),
							array(
								"validate"	=>	false
							)
						);
					}
				}
			}
			//=================== SAVE SCHEDULE LOG ===================//
			
			//=================== SAVE ORDER ===================//
			if(is_array($product_id))
			{
				if(!empty($product_id))
				{
					$emptyOrder				=	true;
					$order_log_type_id		=	"1";
					
					foreach($product_id as $k => $v)
					{
						if($qtyProduct[$k]!="" && $qtyProduct[$k]!="0" && intval($qtyProduct[$k]) > 0)
						{
							$emptyOrder		=	false;
						}	
					}
					
					$detailOrder	=	$this->Order->find("first",array(
											"conditions"	=>	array(
												"Order.schedule_id"	=>	$schedule_id
											),
											"order"			=>	"Order.id desc"
										));
					
					if(!$emptyOrder)
					{
						if(empty($detailOrder))
						{
							$save					=	$this->Order->save($request,array("validate" => false));
							$orderId				=	$this->Order->getLastInsertId();
							$order_log_type_id		=	"1";
						}
						else
						{
							$orderId				=	$detailOrder["Order"]["id"];
							$order_log_type_id		=	"2";
							
							/*
							* Kalo status order sudah di cancel atau sudah proses pengantaran
							* atau sudah finished
							*/
							if(in_array($detailOrder["Order"]["order_status_id"],array("2","3","4")))
							{
								$save					=	$this->Order->save($request,array("validate" => false));
								$orderId				=	$this->Order->getLastInsertId();
								$order_log_type_id		=	"1";
							}
							
							if(!is_null($notes))
							{
								$this->Order->updateAll(
									array(
										"notes"		=>	"'".$notes."'",
										"modified"	=>	"'".$dateTime."'"
									),
									array(
										"Order.id"	=>	$orderId
									)
								);
							}
							
							$this->OrderList->deleteAll(array(
								"OrderList.order_id"	=>	$orderId
							),false,true);
						}
						
						//SAVE ORDER LOG
						$this->OrderLog->create();
						$this->OrderLog->saveAll(
							array(
								"order_id"				=>	$orderId,
								"creator_id"			=>	$salesId,
								"aro_id"				=>	"4",//ARO ID UNTUK SALES
								"notes"					=>	$notes,
								"order_log_type_id"		=>	$order_log_type_id
							),
							array(
								"validate"				=>	false
							)
						);
						$orderLogId		=	$this->OrderLog->getLastInsertId();
						
						
						//SAVE ORDER LIST 
						foreach($product_id as $k => $v)
						{
							$this->OrderList->create();
							$this->OrderList->saveAll(
								array(
									"order_id"					=>	$orderId,
									"product_id"				=>	$v,
									"qty"						=>	$qtyProduct[$k]
								),
								array(
									"validate"	=>	false
								)
							);
							
							$this->OrderLogList->create();
							$this->OrderLogList->saveAll(
								array(
									"order_log_id"				=>	$orderLogId,
									"product_id"				=>	$v,
									"qty"						=>	$qtyProduct[$k]
								),
								array(
									"validate"	=>	false
								)
							);
						}//END SAVE ORDER
					}//END EMPTY ORDER
					else
					{
						if(!empty($detailOrder))
						{
							if($detailOrder["Order"]["order_status_id"] == "1")
							{
								//UPDATE STATUS ORDER
								$this->Order->updateAll(
									array(
										"order_status_id" 	=> "3"
									),
									array(
										"Order.id"			=>	$detailOrder["Order"]["id"]
									)
								);
								
								/*//DELETE ALL ORDER LIST
								$this->OrderList->deleteAll(array(
									"OrderList.order_id"	=>	$detailOrder["Order"]["id"]
								));*/
								
								//SAVE ORDER LOG
								$this->OrderLog->create();
								$this->OrderLog->saveAll(
									array(
										"order_id"				=>	$detailOrder["Order"]["id"],
										"creator_id"			=>	$salesId,
										"aro_id"				=>	"4",//ARO ID UNTUK SALES
										"notes"					=>	$notes,
										"order_log_type_id"		=>	"3"
									),
									array(
										"validate"				=>	false
									)
								);
								$orderLogId	=	$this->OrderLog->id;
								
								//SAVE ORDER LOG LIST
								$listOrder	=	$this->OrderList->find("all",array(
													"conditions"	=>	array(
														"OrderList.order_id"	=>	$detailOrder["Order"]["id"]
													),
													"order"			=>	"OrderList.id asc"
												));
												
								foreach($listOrder as $listOrder)
								{
									$this->OrderLogList->create();
									$this->OrderLogList->saveAll(
										array(
											"order_log_id"				=>	$orderLogId,
											"product_id"				=>	$listOrder["OrderList"]["product_id"],
											"qty"						=>	$listOrder["OrderList"]["qty"]
										),
										array(
											"validate"	=>	false
										)
									);
								}
								
							}//END if($detail["Order"]["order_status_id"] == "1")
							else if($detail["Order"]["order_status_id"] == "2")
							{
								
							}
						}//END IF(!empty($detailOrder))
					}
				}
			}
			//=================== SAVE ORDER ===================//
			
			//UPDATE FIRST INPUT DATA SCHEDULE
			$this->loadModel("Schedule");
			$detailSchedule	=	$this->Schedule->find("first",array(
									"Schedule.id"	=>	$schedule_id
								));
								
			$this->Schedule->updateAll(
				array(
					"check_rival_notes"	=>	is_null($check_rival_notes) ? NULL : "'".$check_rival_notes."'",
					"modified"			=>	"'".$dateTime."'"
				),
				array(
					"Schedule.id"		=>	$schedule_id
				)
			);
			
			if(is_null($detailSchedule["Schedule"]["first_input_data"]))
			{
				$this->Schedule->updateAll(
					array(
						"first_input_data"	=>	"'".$dateTime."'"
					),
					array(
						"Schedule.id"		=>	$schedule_id
					)
				);
			}
		}
		else
		{
			$status		=	false;
			foreach($error as $k => $v)
			{
				$message	=	$v[0];
				break;
			}
			$code		=	"03";
			$data		=	null;
		}

		$out			=	array(
			"status"				=>	$status,
			"message"				=>	$message,
			"data"					=>	$data,
			"code"					=>	$code,
			"request"				=>	$_REQUEST,
			"file"					=>	$_FILES
		);


		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function CheckRival()
	{
		$status			=	false;
		$message		=	ERR_04;
		$code			=	"04";
		$data			=	array();
        $checkinDetail  =   array();

		$request["ScheduleLog"]["schedule_id"]				=	$schedule_id	=	empty($_REQUEST["schedule_id"]) ? "" : $_REQUEST["schedule_id"];
		
		$request["ScheduleLog"]["sales_id"]	=	$salesId	=	empty($_REQUEST["sales_id"]) ? "" : $_REQUEST["sales_id"];
		
		$request["ScheduleLog"]["competitor_product_id"]	=	$competitor_product_id	=	empty($_REQUEST["competitor_product_id"]) ? NULL : $_REQUEST["competitor_product_id"];
		
		$request["ScheduleLog"]["qty"] 						=	$qty	=	empty($_REQUEST["qty"]) ? NULL : $_REQUEST["qty"];
		
		$request["ScheduleLog"]["check_rival_notes"]		=	$notes	=	empty($_REQUEST["check_rival_notes"]) ? NULL : $_REQUEST["check_rival_notes"];

		$this->loadModel("ScheduleLog");
		$this->ScheduleLog->set($request);
		$this->ScheduleLog->ValidateCheckRival();
		$error									=	$this->ScheduleLog->InvalidFields();
		
		if(empty($error))
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
			
			if(is_array($competitor_product_id))
			{
				if(!empty($competitor_product_id))
				{
					$this->ScheduleLog->deleteAll(array(
						"ScheduleLog.schedule_id"	=>	$schedule_id
					));
					
					foreach($competitor_product_id as $k => $v)
					{
						$this->ScheduleLog->create();
						$this->ScheduleLog->saveAll(
							array(
								"schedule_id"				=>	$schedule_id,
								"competitor_product_id"		=>	$v,
								"qty"						=>	$qty[$k]
							),
							array(
								"validate"	=>	false
							)
						);
					}
					
					//UPDATE FIRST INPUT DATA SCHEDULE
					$this->loadModel("Schedule");
					$detailSchedule	=	$this->Schedule->find("first",array(
											"Schedule.id"	=>	$schedule_id
										));
										
					$this->Schedule->updateAll(
						array(
							"check_rival_notes"	=>	"'".$notes."'"
						),
						array(
							"Schedule.id"		=>	$schedule_id
						)
					);
					
					if(is_null($detailSchedule["Schedule"]["first_input_data"]))
					{
						$this->Schedule->updateAll(
							array(
								"first_input_data"	=>	"'".date("Y-m-d H:i:s")."'"
							),
							array(
								"Schedule.id"		=>	$schedule_id
							)
						);
					}
				}
			}
			
		}
		else
		{
			$status		=	false;
			foreach($error as $k => $v)
			{
				$message	=	$v[0];
				break;
			}
			$code		=	"03";
			$data		=	null;
		}

		$out			=	array(
			"status"				=>	$status,
			"message"				=>	$message,
			"data"					=>	$data,
			"code"					=>	$code,
			"request"				=>	$_REQUEST,
			"file"					=>	$_FILES
		);


		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function AddSales()
	{
		$status			=	false;
		$message		=	ERR_04;
		$code			=	"04";
		$data			=	array();

		$request["Order"]["sales_id"]		=	$salesId	=	empty($_REQUEST["sales_id"]) ? "" : $_REQUEST["sales_id"];
		
		$request["Order"]["schedule_id"]	=	$schedule_id	=	empty($_REQUEST["schedule_id"]) ? "" : $_REQUEST["schedule_id"];
		
		$request["Order"]["product_id"]		=	$product_id		=	empty($_REQUEST["product_id"]) ? "" : $_REQUEST["product_id"];
		
		$request["Order"]["qty"]			=	$qty	=	empty($_REQUEST["qty"]) ? "" : $_REQUEST["qty"];
		
		$request["Order"]["notes"]			=	$notes	=	empty($_REQUEST["notes"]) ? NULL : $_REQUEST["notes"];
		
		$request["Order"]["created"]		=	$dateTime	=	date("Y-m-d H:i:s");
		$request["Order"]["modified"]		=	$dateTime;
		
		
		$this->loadModel("Order");
		$this->loadModel("OrderLog");
		$this->loadModel("OrderList");
		$this->loadModel("OrderLogList");
		
		/*$this->Order->find("all");
		$this->OrderLog->find("all");
		$this->OrderList->find("all");
		$this->OrderLogList->find("all");*/
		
		$this->Order->set($request);
		$this->Order->ValidateAddSales();
		$error	=	$this->Order->InvalidFields();
		
		if(empty($error))
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
			
			if(is_array($product_id))
			{
				if(!empty($product_id))
				{
					$detailOrder	=	$this->Order->find("first",array(
											"conditions"	=>	array(
												"Order.schedule_id"	=>	$schedule_id
											)
										));
					
					if(empty($detailOrder))
					{
						$save		=	$this->Order->save($request,array("validate" => false));
						$orderId	=	$this->Order->getLastInsertId();
					}
					else
					{
						$orderId	=	$detailOrder["Order"]["id"];
						if(!is_null($notes))
						{
							$this->Order->updateAll(
								array(
									"notes"		=>	"'".$notes."'",
									"modified"	=>	"'".$dateTime."'"
								),
								array(
									"Order.id"	=>	$orderId
								)
							);
						}
						
						$this->OrderList->deleteAll(array(
							"OrderList.order_id"	=>	$orderId
						),false,true);
					}
					
					//SAVE ORDER LOG
					$this->OrderLog->create();
					$this->OrderLog->saveAll(
						array(
							"order_id"				=>	$orderId,
							"sales_id"				=>	$salesId,
							"notes"					=>	$notes
						),
						array(
							"validate"				=>	false
						)
					);
					$orderLogId	=	$this->OrderLog->getLastInsertId();
					
					
					//SAVE ORDER IST 
					foreach($product_id as $k => $v)
					{
						$this->OrderList->create();
						$this->OrderList->saveAll(
							array(
								"order_id"					=>	$orderId,
								"product_id"				=>	$v,
								"qty"						=>	$qty[$k]
							),
							array(
								"validate"	=>	false
							)
						);
						
						$this->OrderLogList->create();
						$this->OrderLogList->saveAll(
							array(
								"order_log_id"				=>	$orderLogId,
								"product_id"				=>	$v,
								"qty"						=>	$qty[$k]
							),
							array(
								"validate"	=>	false
							)
						);
					}//END SAVE ORDER
					
					//UPDATE FIRST INPUT DATA SCHEDULE
					$this->loadModel("Schedule");
					$detailSchedule	=	$this->Schedule->find("first",array(
											"Schedule.id"	=>	$schedule_id
										));
					
					if(is_null($detailSchedule["Schedule"]["first_input_data"]))
					{
						$this->Schedule->updateAll(
							array(
								"first_input_data"	=>	"'".date("Y-m-d H:i:s")."'"
							),
							array(
								"Schedule.id"		=>	$schedule_id
							)
						);
					}
				}
			}
		}
		else
		{
			$status		=	false;
			foreach($error as $k => $v)
			{
				$message	=	$v[0];
				break;
			}
			$code		=	"03";
			$data		=	null;
		}

		//GET SALES TARGET
		$this->loadModel("Order");
		$DataTarget			=	$this->Order->GetTotalOrderSales($salesId);
		$totalTarget		=	$DataTarget["totalTarget"];
		$totalOrder			=	$DataTarget["totalOrder"];
			
		$out			=	array(
			"status"				=>	$status,
			"message"				=>	$message,
			"data"					=>	$data,
			"code"					=>	$code,
			"totalTarget"			=>	$totalTarget,
			"totalOrder"			=>	$totalOrder,
			"request"				=>	$_REQUEST,
			"file"					=>	$_FILES
		);


		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function AddStore()
	{
		$status				=	false;
		$message			=	ERR_04;
		$code				=	"04";
		$data				=	array();
        $canAddToSchedule  	=	false;
		$totalAddStore		=	"0";

		$request["Store"]["creator_id"]		=	empty($_REQUEST["creator_id"]) ? "" : $_REQUEST["creator_id"];
		
		$request["Store"]["name"]			=	empty($_REQUEST["name"]) ? "" : $_REQUEST["name"];
		
		$request["Store"]["address"]		=	empty($_REQUEST["address"]) ? "" : $_REQUEST["address"];
		
		$request["Store"]["city_id"]		=	empty($_REQUEST["city_id"]) ? "" : $_REQUEST["city_id"];
		
		$request["Store"]["postal_code"]	=	empty($_REQUEST["postal_code"]) ? NULL : $_REQUEST["postal_code"];
		
		$request["Store"]["owner"]			=	empty($_REQUEST["owner"]) ? NULL : $_REQUEST["owner"];
		
		$request["Store"]["phone1"]			=	empty($_REQUEST["phone1"]) ? NULL : $_REQUEST["phone1"];
		
		$request["Store"]["latitude"]		=	empty($_REQUEST["latitude"]) ? NULL : $_REQUEST["latitude"];
		
		$request["Store"]["longitude"]		=	empty($_REQUEST["longitude"]) ? NULL : $_REQUEST["longitude"];
		
		$request["Store"]["images"]			=	isset($_FILES['images']) ? $_FILES['images'] : NULL;
		
		$this->loadModel('Store');
		$this->Store->set($request);
		$this->Store->ValidateAddStore();
		$error								=	$this->Store->InvalidFields();
		
		if(empty($error))
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
			
			$this->Store->save($request,array("validate"=>false));
			$ID			=	$this->Store->id;
			$data		=	$this->Store->find("first",array(
								"conditions"	=>	array(
									"Store.id"	=>	$ID
								)
							));
			
			//=============== UPLOAD IMAGES =====================//
			if(!empty($_FILES['images']['name']))
			{
				$tmp_name							=	$_FILES['images']["name"];
				$tmp								=	$_FILES['images']["tmp_name"];
				

				$path_tmp							=	ROOT.DS.'app'.DS.'tmp'.DS.'upload'.DS;
					if(!is_dir($path_tmp)) mkdir($path_tmp,0777);

				$ext								=	pathinfo($tmp_name,PATHINFO_EXTENSION);
				$tmp_file_name						=	md5(time());
				$tmp_images1_img					=	$path_tmp.$tmp_file_name.".".$ext;
				$upload 							=	move_uploaded_file($tmp,$tmp_images1_img);
				
				if($upload)
				{
					list($width, $height)			=	getimagesize($tmp_images1_img);
					$mime_type						=	"image/jpeg";
					$width							=	$width > 800 ? 800 : $width;
					
					$resize							=	$this->General->ResizeImageContent(
																$tmp_images1_img,
																$this->settings["cms_url"],
																$ID,
																"Store",
																"square",
																$mime_type,
																300,
																300,
																"cropResize"
															);

						$resize							=	$this->General->ResizeImageContent(
																$tmp_images1_img,
																$this->settings["cms_url"],
																$ID,
																"Store",
																"maxwidth",
																$mime_type,
																$width,
																$width,
																"resizeMaxWidth"
															);

				}
				@unlink($tmp_images1_img);
			}
			//=============== UPLOAD IMAGES =====================//
			
			//=============== CHECK IS CAN STORE ADD TO SCHEDULE ===============//
			$now			=	time();
			$jobStart		=	mktime(7,0,0,date("n"),date("j"),date("Y"));
			$jobEnd			=	mktime(21,59,59,date("n"),date("j"),date("Y"));
			
			if($now>$jobStart && $now < $jobEnd)
			{
				$canAddToSchedule = true;
			}
			//=============== CHECK IS CAN STORE ADD TO SCHEDULE ===============//
			
			//TOTAL ADD STORE
			$this->loadModel("Store");
			$totalAddStore		=	$this->Store->find("count",array(
										"conditions"	=>	array(
											"Store.creator_id"				=>	$request["Store"]["creator_id"]
										)
									));
									
		}
		else
		{
			$status		=	false;
			foreach($error as $k => $v)
			{
				$message	=	$v[0];
				break;
			}
			$code		=	"03";
			$data		=	null;
		}

		$out			=	array(
			"status"				=>	$status,
			"message"				=>	$message,
			"data"					=>	$data,
			"TotalAddStore"			=>	$totalAddStore,
			"canAddToSchedule"		=>	$canAddToSchedule,
			"code"					=>	$code,
			"request"				=>	$_REQUEST,
			"file"					=>	$_FILES
		);


		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function AddStoreToSchedule()
	{
		
		$status				=	false;
		$message			=	ERR_04;
		$code				=	"04";
		$data				=	array();
        $canAddToSchedule  	=	false;
		

		$request["Schedule"]["sales_id"]		=	empty($_REQUEST["sales_id"]) ? "" : $_REQUEST["sales_id"];
		
		$request["Schedule"]["store_id"]		=	empty($_REQUEST["store_id"]) ? "" : $_REQUEST["store_id"];
		
		$request["Schedule"]["schedule_date"]	=	date("Y-m-d H:i");
		
		$this->loadModel('Schedule');
		$this->Schedule->set($request);
		$this->Schedule->ValidateAddStoreToScchedule();
		$error									=	$this->Schedule->InvalidFields();
		
		if(empty($error))
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
			$this->Schedule->save($request,array("validate"=>false));
		}
		else
		{
			$status		=	false;
			foreach($error as $k => $v)
			{
				$message	=	$v[0];
				break;
			}
			$code		=	"03";
			$data		=	null;
		}

		$out			=	array(
			"status"				=>	$status,
			"message"				=>	$message,
			"data"					=>	$data,
			"canAddToSchedule"		=>	$canAddToSchedule,
			"code"					=>	$code,
			"request"				=>	$_REQUEST,
			"file"					=>	$_FILES
		);


		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function UserLogout()
	{
		$status			=	false;
		$message		=	ERR_04;
		$code			=	"04";
		$data			=	array();
        $checkinDetail  =   array();

		$user_id		=	isset($_REQUEST["user_id"]) ? (!empty($_REQUEST["user_id"]) ? $_REQUEST["user_id"] : NULL) : NULL;
		
		$this->loadModel("User");
		$checkUser		=	$this->User->find("first",array(
								"conditions"	=>	array(
									"User.id"		=>	$user_id,
									"User.status"	=>	"1"
								)
							));
							
		if(!empty($checkUser))
		{
			$this->User->updateAll(
				array(
					"gcm_id"	=>	NULL
				),
				array(
					"User.id"	=>	$user_id
				)
			);
		}
	}
	
	function CheckinHistory()
	{
		$status			=	false;
		$message		=	ERR_03;
		$data			=	null;
		$code			=	"03";
		$page			=	(empty($_REQUEST['page'])) ? 1 : $_REQUEST['page'];
		$user_id		=	(empty($_REQUEST['user_id'])) ? "" : $_REQUEST['user_id'];
		
		
		$this->loadModel("Schedule");
		$this->Schedule->bindModel(array(
			"belongsTo"	=>	array(
				"Store"
			)
		));
		
		$this->Schedule->virtualFields = array(
			"Ago"		=> "IF((DATE_FORMAT(Schedule.checkin_date,'%Y-%m-%d')=DATE_FORMAT(now(),'%Y-%m-%d')),'TODAY',
			IF(DATE_FORMAT(Schedule.checkin_date,'%Y-%m-%d')=DATE_FORMAT(DATE_ADD(now(),INTERVAL -1 DAY),'%Y-%m-%d'),'YESTERDAY',UPPER(DATE_FORMAT(Schedule.checkin_date,'%a, %b %d %h:%i %p'))))",
		);
			
		$conditions			=	array(
									"Schedule.sales_id"				=>	$user_id,
									"Schedule.checkin_status_id"	=>	"2"
								);
		
		$this->paginate		=	array(
			"Schedule"	=>	array(
				"order"			=>	"Schedule.checkin_date desc",
				"page"			=>	$page,		
				"limit"			=>	10,
				"conditions"	=>	$conditions,
				"recursive"		=>	3,
				"group"			=>	"Schedule.id"
			)
		);
		
		try
		{
			$fData			=	$this->paginate("Schedule");
		}
		catch(NotFoundException $e)
		{
			$fData		=	array();
		}
		
		
		if(empty($fData))
		{
			$status		=	true;
			$message	=	ERR_02;
			$data		=	array();
			$code		=	"02";
		}
		else
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
			$data		=	$fData;
		}
		
		$out	=	array(
						"status"	=>	$status,
						"message"	=>	$message,
						"data"		=>	$data,
						"code"		=>	$code,
						"pageCount"	=>	$this->params['paging']['Schedule']['pageCount'],
						"page"		=>	$this->params['paging']['Schedule']['page'],
						"totalData"	=>	$this->params['paging']['Schedule']['count'],
						"nextPage"	=>	$this->params['paging']['Schedule']['nextPage'],
						"request"	=>	$_REQUEST
					);
		
		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function AddStoreHistory()
	{
		$status			=	false;
		$message		=	ERR_03;
		$data			=	null;
		$code			=	"03";
		$page			=	(empty($_REQUEST['page'])) ? 1 : $_REQUEST['page'];
		$user_id		=	(empty($_REQUEST['user_id'])) ? "" : $_REQUEST['user_id'];
		
		
		$this->loadModel("Store");
		
		$this->Store->virtualFields = array(
			"Ago"		=> "IF((DATE_FORMAT(Store.created,'%Y-%m-%d')=DATE_FORMAT(now(),'%Y-%m-%d')),'TODAY',
			IF(DATE_FORMAT(Store.created,'%Y-%m-%d')=DATE_FORMAT(DATE_ADD(now(),INTERVAL -1 DAY),'%Y-%m-%d'),'YESTERDAY',UPPER(DATE_FORMAT(Store.created,'%a, %b %d %h:%i %p'))))",
		);
			
		$conditions			=	array(
									"Store.creator_id"				=>	$user_id
								);
		
		$this->paginate		=	array(
			"Store"	=>	array(
				"order"			=>	"Store.created desc",
				"page"			=>	$page,		
				"limit"			=>	10,
				"conditions"	=>	$conditions,
				"recursive"		=>	3,
				"group"			=>	"Store.id"
			)
		);
		
		try
		{
			$fData			=	$this->paginate("Store");
		}
		catch(NotFoundException $e)
		{
			$fData		=	array();
		}
		
		
		if(empty($fData))
		{
			$status		=	true;
			$message	=	ERR_02;
			$data		=	array();
			$code		=	"02";
		}
		else
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
			$data		=	$fData;
		}
		
		$out	=	array(
						"status"	=>	$status,
						"message"	=>	$message,
						"data"		=>	$data,
						"code"		=>	$code,
						"pageCount"	=>	$this->params['paging']['Store']['pageCount'],
						"page"		=>	$this->params['paging']['Store']['page'],
						"totalData"	=>	$this->params['paging']['Store']['count'],
						"nextPage"	=>	$this->params['paging']['Store']['nextPage'],
						"request"	=>	$_REQUEST
					);
		
		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function GetStoreOrder()
	{
		$status			=	false;
		$message		=	ERR_03;
		$data			=	null;
		$code			=	"03";
		$Schedule		=	array();
		$EnabledEdit	=	true;

		$scheduleId		=	empty($_REQUEST["schedule_id"]) ? "" : $_REQUEST["schedule_id"];
		$salesId		=	empty($_REQUEST["user_id"]) ? "" : $_REQUEST["user_id"];
		
		//CHECK ORDER
		$this->loadModel("Order");
		$order			=	$this->Order->find("first",array(
								"conditions"	=>	array(
									"Order.schedule_id"	=>	$scheduleId
								),
								"order"			=>	"Order.id desc"
							));
							
		$order_id		=	isset($order["Order"]["id"]) ? $order["Order"]["id"] : "";
		
		$this->loadModel("Product");
		$this->Product->bindModel(array(
			"hasOne"	=>	array(
				"OrderList"	=>	array(
					"conditions"	=>	array(
						"OrderList.order_id"	=>	$order_id
					)
				)
			)
		));
		$this->Product->OrderList->bindModel(array(
			"belongsTo"	=>	array(
				"Order"
			)
		));
			
		$conditions			=	array();
		$fData				=	$this->Product->find("all",array(
									"order"			=>	"Product.name asc",
									"conditions"	=>	array(
										"Product.status"	=>	"1"
									),
									"group"			=>	"Product.id",
									"recursive"		=>	3
								));
		
		if(empty($fData))
		{
			$status		=	false;
			$message	=	ERR_02;
			$data		=	array();
			$code		=	"02";
		}
		else
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
			$data		=	$fData;
			
			//CHECK DETAIL SCHEDULE
			$this->loadModel("Schedule");
			$Schedule	=	$this->Schedule->find("first",array(
				"conditions"	=>	array(
					"Schedule.id"	=>	$scheduleId
				)
			));
			
			$firstInputData	=	$Schedule["Schedule"]["first_input_data"];
			if(!is_null($firstInputData))
			{
				$firstInputDataTimeStamp	=	strtotime($firstInputData);
				$now	=	time();
				
				if(($now - $firstInputDataTimeStamp) > (3600 * 1))
				{
					$EnabledEdit = false;
				}
			}
		}
		
		$out	=	array(
						"status"		=>	$status,
						"message"		=>	$message,
						"data"			=>	$data,
						"code"			=>	$code,
						"Order"			=>	!empty($order) ? $order["Order"] : array(),
						"EnabledEdit"	=>	$EnabledEdit,
						"request"		=>	$_REQUEST
					);
		
		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function UpdateGcmId()
	{
		$gcm_id		=	isset($_REQUEST['gcm_id']) ? (!empty($_REQUEST['gcm_id']) ? $_REQUEST['gcm_id'] : NULL) : NULL;
		
		$user_id	=	isset($_REQUEST['user_id']) ? (!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : NULL) : NULL;
		
		$this->loadModel("User");
		$check	=	$this->User->find("first",array(
						"conditions"	=>	array(
							"User.id"	=>	$user_id
						)
					));
					
		if(!empty($check))
		{
			$this->User->updateAll(
				array(
					"gcm_id"		=>	NULL
				),
				array(
					"User.gcm_id"	=>	$gcm_id
				)
			);
			
			$this->User->updateAll(
				array(
					"gcm_id"		=>	"'".$gcm_id."'"
				),
				array(
					"User.id"		=>	$user_id
				)
			);
		}
		
		$out			=	array(
			"request"				=>	$_REQUEST
		);


		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function NotificationList()
	{
		$status			=	false;
		$message		=	ERR_03;
		$data			=	null;
		$code			=	"03";
		$user_id		=	$_REQUEST['user_id'];
		$page			=	(empty($_REQUEST['page'])) ? 1 : $_REQUEST['page'];
		
		//CHECK USER ID
		$this->loadModel("User");
		$check			=	$this->User->find("first",array(
								"conditions"	=>	array(
									"User.id"		=>	$user_id
								)
							));
		
		if(empty($check))
		{				
			$out	=	array(
							"status"	=>	false,
							"message"	=>	"Not authorized",
							"data"		=>	array(),
							"code"		=>	"00",
							"request"	=>	$_REQUEST
						);
			
			$json		=	json_encode($out);
			$this->response->type('json');
			$this->response->body($json);
			return;
		}
		
		
		$this->loadModel("Notification");
		$conditions			=	array(
									"Notification.user_id"	=>	$user_id
								);
								
		$totalNotRead		=	$this->Notification->find("count",array(
									"conditions"	=>	array(
										"Notification.user_id"		=>	$user_id,
										"Notification.is_readed"	=>	"0"
									)
								));
								
		$this->paginate		=	array(
			"Notification"	=>	array(
				"order"			=>	"Notification.id desc, Notification.is_readed desc",
				"page"			=>	$page,		
				"limit"			=>	10,
				"conditions"	=>	$conditions,
				"recursive"		=>	3,
				"fields"		=>	array(
					"Notification.*"
				)
			)
		);
		
		try
		{
			$fData			=	$this->paginate("Notification");
		}
		catch(NotFoundException $e)
		{
			$fData		=	array();
		}
		
		
		if(empty($fData))
		{
			$status		=	true;
			$message	=	ERR_02;
			$data		=	array();
			$code		=	"02";
		}
		else
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
			$data		=	$fData;
		}
		
		$out	=	array(
						"status"	=>	$status,
						"message"	=>	$message,
						"data"		=>	$data,
						"code"		=>	$code,
						"totalNotRead"	=>	$totalNotRead,
						"pageCount"	=>	$this->params['paging']['Notification']['pageCount'],
						"page"		=>	$this->params['paging']['Notification']['page'],
						"totalData"	=>	$this->params['paging']['Notification']['count'],
						"nextPage"	=>	$this->params['paging']['Notification']['nextPage'],
						"request"	=>	$_REQUEST
					);
		
		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function UpdateNotificationReadedStatus()
	{
		$notification_group_id		=	isset($_REQUEST['notification_group_id']) ? (!empty($_REQUEST['notification_group_id']) ? $_REQUEST['notification_group_id'] : NULL) : NULL;
		
		$user_id					=	isset($_REQUEST['user_id']) ? (!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : NULL) : NULL;
		
		$id		=	isset($_REQUEST['id']) ? (!empty($_REQUEST['id']) ? $_REQUEST['id'] : NULL) : NULL;
		$totalNotRead	=	0;
		
		$this->loadModel("User");
		$this->loadModel("Notification");
		$check	=	$this->User->find("first",array(
						"conditions"	=>	array(
							"User.id"	=>	$user_id
						)
					));
					
		if(!empty($check))
		{				
			if(!empty($id))
			{
				$checkNotifId	=	$this->Notification->findById($id);
				
				if(!empty($checkNotifId) && $checkNotifId["Notification"]["is_readed"] == "0")
				{
					$this->Notification->updateAll(
						array(
							"is_readed"				=>	"1",
							"read_date"				=>	"'".date("Y-m-d H:i:s")."'"
						),
						array(
							"Notification.user_id"	=>	$user_id,
							"Notification.id"		=>	$id
						)
					);
					
					$detailNotification	=	$this->Notification->findById($id);
					if(!empty($detailNotification["Notification"]["notification_group_id"]))
					{
						$this->Notification->updateCounterCache(
							array(
								'notification_group_id' => $detailNotification["Notification"]["notification_group_id"]
							)
						);
					}
				}
			}
			else
			{
				$this->Notification->updateAll(
					array(
						"is_readed"				=>	"1",
						"read_date"				=>	"'".date("Y-m-d H:i:s")."'"
					),
					array(
						"Notification.user_id"					=>	$user_id,
						"Notification.notification_group_id"	=>	$notification_group_id
					)
				);
				
				$this->Notification->updateCounterCache(
					array(
						'notification_group_id' => $notification_group_id
					)
				);
			}
			
			$totalNotRead		=	$this->Notification->find("count",array(
									"conditions"	=>	array(
										"Notification.user_id"		=>	$user_id,
										"Notification.is_readed"	=>	"0"
									)
								));
		}
		
		$out			=	array(
			"request"				=>	$_REQUEST,
			"file"					=>	$_FILES,
			"totalNotRead"			=>	$totalNotRead
		);
		
		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function UpdateNotificationDeliveryStatus()
	{
		$notification_group_id		=	isset($_REQUEST['notification_group_id']) ? (!empty($_REQUEST['notification_group_id']) ? $_REQUEST['notification_group_id'] : NULL) : NULL;
		
		$user_id					=	isset($_REQUEST['user_id']) ? (!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : NULL) : NULL;
		
		$id							=	isset($_REQUEST['id']) ? (!empty($_REQUEST['id']) ? $_REQUEST['id'] : NULL) : NULL;
		$totalNotRead				=	0;
		
		$this->loadModel("User");
		$this->loadModel("Notification");
		$check	=	$this->User->find("first",array(
						"conditions"	=>	array(
							"User.id"	=>	$user_id
						)
					));
					
		if(!empty($check))
		{
			$conditions	=	array(
								"Notification.user_id"					=>	$user_id,
								"Notification.notification_group_id"	=>	$notification_group_id
							);
							
			if(!empty($id))
			{
				$conditions	=	array(
									"Notification.user_id"	=>	$user_id,
									"Notification.id"		=>	$id
								);
			}
			
			$this->Notification->updateAll(
				array(
					"is_arrival"			=>	"1",
					"arrival_date"			=>	"'".date("Y-m-d H:i:s")."'"
				),
				$conditions
			);
			
			if(empty($id) && !empty($notification_group_id))
			{
				$this->Notification->updateCounterCache(
					array(
						'notification_group_id' => $notification_group_id
					)
				);
			}
			else if(!empty($id))
			{
				$detailNotification	=	$this->Notification->findById($id);
				if(!empty($detailNotification["Notification"]["notification_group_id"]))
				{
					$this->Notification->updateCounterCache(
						array(
							'notification_group_id' => $detailNotification["Notification"]["notification_group_id"]
						)
					);
				}
			}
			
			$totalNotRead		=	$this->Notification->find("count",array(
									"conditions"	=>	array(
										"Notification.user_id"		=>	$user_id,
										"Notification.is_readed"	=>	"0"
									)
								));
		}
		
		$out			=	array(
			"request"				=>	$_REQUEST,
			"file"					=>	$_FILES,
			"totalNotRead"			=>	$totalNotRead
		);
		
		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function DetailStore()
	{
		$status			=	false;
		$message		=	ERR_02;
		$data			=	array();
		$code			=	"02";
		$storeId		=	isset($_REQUEST['store_id']) ? $_REQUEST['store_id'] : "";
		$userId			=	isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
		
		
		$this->loadModel("Store");
		$this->Store->bindModel(array(
			"hasOne"	=>	array(
				"Image"	=>	array(
					"className"	=>	"Content",
					"foreignKey"	=>	"model_id",
					"conditions"	=>	array(
						"Image.model"	=>	"Store",
						"Image.type"	=>	"maxwidth"
					)
				)
			)
		));
		
		$fData	=	$this->Store->find("first",array(
						"conditions"	=>	array(
							"Store.id"		=>	$storeId,
							"Store.status"	=>	"1"
						)
					));
					
		if(empty($fData))
		{
			$status		=	false;
			$message	=	ERR_02;
			$data		=	array();
			$code		=	"02";
		}
		else
		{
			$status		=	true;
			$message	=	ERR_00;
			$code		=	"00";
			$data		=	$fData;
		}
		
		$out	=	array(
						"status"			=>	$status,
						"message"			=>	$message,
						"data"				=>	$data,
						"code"				=>	$code,
						"request"			=>	$_REQUEST
					);
		
		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}

	function GetLocation()
	{
		$this->loadModel("User");
		$userId		=	$_GET["user_id"];
		
		$User		=	$this->User->find("first",array(
							"conditions"	=>	array(
								"User.id"	=>	$userId
							)
						));
		
		$out	=	array(
						"latitude"			=>	$User["User"]["current_latitude"],
						"longitude"			=>	$User["User"]["current_longitude"]
					);
		
		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}

	function UpdateUserLocation()
	{
		$user_id	=	isset($_REQUEST['user_id']) ? (!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : NULL) : NULL;
		
		$latitude	=	isset($_REQUEST['latitude']) ? (!empty($_REQUEST['latitude']) ? $_REQUEST['latitude'] : NULL) : NULL;
		
		$longitude	=	isset($_REQUEST['longitude']) ? (!empty($_REQUEST['longitude']) ? $_REQUEST['longitude'] : NULL) : NULL;
		
		$this->loadModel("User");
		$check	=	$this->User->find("first",array(
						"conditions"	=>	array(
							"User.id"	=>	$user_id
						)
					));
					
		if(!empty($check))
		{
			$this->User->updateAll(
				array(
					"current_latitude"		=>	$latitude,
					"current_longitude"		=>	$longitude
				),
				array(
					"User.id"	=>	$user_id
				)
			);
		}
		
		$out			=	array(
			"request"				=>	$_REQUEST,
			"file"					=>	$_FILES
		);
		$json		=	json_encode($out);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			pr($out);
		}
	}
	
	function SelesChartData() {

		$this->loadModel("Schedule");
		$userId		=	$_GET["user_id"];
		$firstdate 	=	$_GET["firstdate"];
		$enddate	=	$_GET["enddate"];

		$dataChart		=	$this->Schedule->find('all',
			array(
				'fields'	=>	array(
						'DATE(orders.modified) as y',
					    'SUM(products.price * order_lists.qty) as a'
					),
				'joins' => array(
					array(
						'table' 	=>	'orders',
						'type' 		=>	'LEFT',
						'conditions'=>	array(
							'orders.schedule_id = Schedule.id'
						)
					),
					array(
						'table'		=>	'order_lists',
						'type'		=>	'LEFT',
						'conditions'=>	array(
								'order_lists.order_id = orders.id'
							)
						),
					array(
						'table'		=>	'products',
						'type'		=>	'LEFT',
						'conditions'=>	array(
							'order_lists.product_id = products.id'
							)
						),
					array(
						'table'		=>	'stores',
						'type'		=>	'LEFT',
						'conditions'=>	array(
							'stores.id = Schedule.store_id'
						)
					)
				),
				'conditions'	=>	array(
						'orders.order_status_id'	=>	'4',
						'Schedule.sales_id' 	=>  $userId,
						/*'YEAR(orders.modified)'	=> date('Y'),*/
						"DATE(orders.modified) BETWEEN DATE('".$firstdate."') AND DATE('".$enddate."')"
				),
				'group'		=>	'orders.modified'

			)
		);
		$out 	= array();

		foreach ($dataChart as $key) {
			$out[]	=	array(
				"y"	=>	$key[0]['y'],
				"a"	=>	$key[0]['a']
			);
		}
		$data 	= array(
			"data"	=> $out
		);
		pr($data);
		$json		=	json_encode($data);
		$this->response->type('json');
		$this->response->body($json);
		if(isset($_GET['debug']) && $_GET['debug'] == "1")
		{
			
		}
	}

	function GetDetailIncome(){
		$this->loadModel("Schedule");
		$userId		=	$_GET["user_id"];
		$firstdate 	=	$_GET["firstdate"];
		$enddate	=	$_GET["enddate"];

		$dataChart		=	$this->Schedule->find('all',
			array(
				'fields'	=>	array(
						'orders.id',
						'stores.name',
						'stores.address',
						'DATE(orders.modified) as modified',
					    'SUM(products.price * order_lists.qty) as Pendapatan'
					),
				'joins' => array(
					array(
						'table' 	=>	'orders',
						'type' 		=>	'LEFT',
						'conditions'=>	array(
							'orders.schedule_id = Schedule.id'
						)
					),
					array(
						'table'		=>	'order_lists',
						'type'		=>	'LEFT',
						'conditions'=>	array(
								'order_lists.order_id = orders.id'
							)
						),
					array(
						'table'		=>	'products',
						'type'		=>	'LEFT',
						'conditions'=>	array(
							'order_lists.product_id = products.id'
							)
						),
					array(
						'table'		=>	'stores',
						'type'		=>	'LEFT',
						'conditions'=>	array(
							'stores.id = Schedule.store_id'
						)
					)
				),
				'conditions'	=>	array(
						'orders.order_status_id'	=>	'4',
						'Schedule.sales_id' 	=>  $userId,
						/*'YEAR(orders.modified)'	=> date('Y'),*/
						"DATE(orders.modified) BETWEEN DATE('".$firstdate."') AND DATE('".$enddate."')"
				),
				'group'		=>	'orders.modified'

			)
		);
			$out 	= array();
			$no 	= 0;
			foreach ($dataChart as $key) {
				$no++;
				$out[]	=	array(
					"no"		=>	$no,
					"orderId"	=>	$key['orders']['id'],
					"stores"	=>	$key['stores']['name'],
					"address"	=>	$key['stores']['address'],
					"date"		=>	$key[0]['modified'],
					"income"		=>	$key[0]['Pendapatan'],
				);
			}
			$data 	= array(
				"data"	=> $out
			);
			pr($data);
			$json		=	json_encode($data);
			$this->response->type('json');
			$this->response->body($json);
			if(isset($_GET['debug']) && $_GET['debug'] == "1"){
				
			}
	}
	function GetReportOrder(){
		$this->loadModel("Schedule");
		$firstdate 	=	$_GET["firstdate"];
		$enddate	=	$_GET["enddate"];

		$dataChart		=	$this->Schedule->find('all',
			array(
				'fields'	=>	array(
						'orders.id',
						'stores.name',
						'stores.address',
						'DATE(orders.modified) as modified',
					    'SUM(products.price * order_lists.qty) as Pendapatan'
					),
				'joins' => array(
					array(
						'table' 	=>	'orders',
						'type' 		=>	'LEFT',
						'conditions'=>	array(
							'orders.schedule_id = Schedule.id'
						)
					),
					array(
						'table'		=>	'order_lists',
						'type'		=>	'LEFT',
						'conditions'=>	array(
								'order_lists.order_id = orders.id'
							)
						),
					array(
						'table'		=>	'products',
						'type'		=>	'LEFT',
						'conditions'=>	array(
							'order_lists.product_id = products.id'
							)
						),
					array(
						'table'		=>	'stores',
						'type'		=>	'LEFT',
						'conditions'=>	array(
							'stores.id = Schedule.store_id'
						)
					)
				),
				'conditions'	=>	array(
						'orders.order_status_id'	=>	'4',
						"DATE(orders.modified) BETWEEN DATE('".$firstdate."') AND DATE('".$enddate."')"
				),
				'group'		=>	'orders.modified'

			)
		);
			$out 	= array();
			$no 	= 0;
			foreach ($dataChart as $key) {
				$no++;
				$out[]	=	array(
					"no"		=>	$no,
					"orderId"	=>	$key['orders']['id'],
					"date"		=>	$key[0]['modified'],
					"sales"	=>	$key['stores']['name'],
					"stores"	=>	$key['stores']['name'],
					"address"	=>	$key['stores']['address']
				);
			}
			$data 	= array(
				"data"	=> $out
			);
			pr($data);
			$json		=	json_encode($data);
			$this->response->type('json');
			$this->response->body($json);
			if(isset($_GET['debug']) && $_GET['debug'] == "1"){
				
			}
	}
}
?>
