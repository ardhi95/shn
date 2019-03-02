<?php
class DashboardsController extends AppController
{
	var $helpers			=	array("Tree");
	var $ControllerName		=	"Dashboards";
	var $ModelName 			=	"CmsMenu";

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->set("ControllerName", $this->ControllerName);
		$this->set("ModelName", $this->ModelName);

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

	function Index()
	{
		if ($this->access[$this->aco_id]["_read"] != "1"){
			$this->render("/Errors/no_access");
			return;
		}

		/*===== Get Sales Active =====*/
		$this->loadModel('Users');
		$data 		=	$this->Users->find('count', array(
				'conditions'	=>	array(
						'Users.aro_id'	=>	'4',
						'Users.status'	=>	'1'
					)
			)
		);
		pr($data);
		$this->set(compact(
			"data"
		));

		/*=====  Get Order This Month =====*/
		$this->loadModel('Order');
		$dataOr 		=	$this->Order->find('count', array(
				'conditions'	=>	array(
						'Order.order_status_id'	=>	'4',
						'MONTH(Order.modified)'	=>  date('n'),
						'YEAR(Order.modified)'		=>	date('Y')
					)
			)
		);
		$this->set(compact(
			"dataOr"
		));

		/*===== Get Total This Month =====*/
		$dataTotal 		=	$this->Order->find('all', 
			array(
				'fields' => array(
					'MONTH(Order.modified) as month',
					'SUM(order_lists.qty * products.price) as total'
				),
				'joins' => array(
					array(
						'table' => 'order_lists',
						'type' => 'LEFT',
						'conditions' => array(
							'Order.id=order_lists.order_id',
						)
					),
					array(
						'table' => 'products',
						'type' => 'LEFT',
						'conditions' => array(
							'order_lists.product_id = products.id',
						)
					)
				),
				'conditions'	=>	array(
						'Order.order_status_id'	=>	'4',
						'MONTH(Order.modified)' 	=>  date('n'),
						'YEAR(Order.modified)'		=>	date('Y')
					)
			)
		); 

		$angka	=	$dataTotal['0']['0']['total'];
		$len	=	strlen($angka);

        if ($len <= 6) {
        	$convTotal	=	number_format($angka,0,',','.');
        }elseif ($len < 10) {
        	$bagi	=	$angka/1000000;
			$fix	=	floor($bagi);
			$convTotal 	=	$fix." Juta";
        }else{
        	$bagi	=	$angka/1000000000;
			$fix	=	round($bagi, 1);
			$convTotal 	=	$fix." Miliar";
        }


		$this->set(compact(
			"dataTotal",
			"convTotal"
		));

		/*===== Percentage UWE =====*/
		$this->loadModel('OrderList');
		$dataUwe 		=	$this->OrderList->find('all', 
			array(
				'fields' => array(
					'SUM(qty) as uwe'
				)
			)
		);

		$this->loadModel('ScheduleLogs');
		$dataCompetitor 		=	$this->ScheduleLogs->find('all', 
			array(
				'fields' => array(
					'SUM(qty) as competitor'
				)
			)
		);

		$uwe 			=	$dataUwe['0']['0']['uwe'];
		$competitor 	=	$dataCompetitor['0']['0']['competitor'];
		
		$percentage		=	intval(($uwe+$competitor)) >0 ? ($uwe/($uwe+$competitor))*100:0;
		
		$round			=	floor($percentage);	
		$this->set(compact(
			"uwe",
			"round"
		));


		/*===== Schedules Today =====*/
		$this->loadModel('Schedule');
		$this->Schedule->bindModel(array(
			"belongsTo" =>	array(
				"Users"	=>	array(
					'fields'		=>	array(
							'Users.id',
							'Users.firstname',
							'Users.lastname'
						),
					"foreignKey"	=>	"sales_id"
				)
			),
			"hasOne"	=>	array(
				"SalesTargets"	=>	array(
					"foreignKey"	=>	false,
					'conditions'	=> "Schedule.sales_id = SalesTargets.sales_id AND (DATE(NOW()) BETWEEN SalesTargets.start_date AND SalesTargets.end_date)" 
				)
			)
		));

		$dataSchedules 		=	$this->Schedule->find('all', array(
				'conditions'	=>	array(
						'DATE(Schedule.schedule_date)' => date('Y-m-d')
					),
				'group'	=>	'Users.firstname',
				"recursive"	=>	"2"
			)
		);
		
		
		$this->loadModel('Order');
		$this->loadModel('Schedule');
		$this->loadModel('SalesTarget');
		$joins			=	array(
								array(
									"table"			=>	"orders",
									"alias"			=>	"Order",
									'type'			 => 'LEFT',
									"conditions"	=>	array(
										"Order.schedule_id	=	Schedule.id"
									)
								),
								array(
									"table"			=>	"order_lists",
									"alias"			=>	"OrderList",
									'type'			 => 'LEFT',
									"conditions"	=>	array(
										"OrderList.order_id	=	Order.id"
									)
								),
								array(
									"table"			=>	"products",
									"alias"			=>	"Product",
									'type'			 => 'LEFT',
									"conditions"	=>	array(
										"OrderList.product_id	=	Product.id"
									)
								)
							);
							
		if (!empty($dataSchedules)) {
			foreach ($dataSchedules as $k	=>	$v)
			{
				$salesId		=	$v["Users"]["id"];
				$checkOrder		=	$this->Schedule->find("all",array(
										"joins"		=>	$joins,
										"fields"	=>	array(
											"SUM(OrderList.qty*Product.price) as totalOrder"
										),
										"conditions"	=>	array(
											"Schedule.sales_id"		=>	$salesId,
											"Order.order_status_id"	=>	4,
											"DATE(Order.modified)" =>	date("Y-m-d")
											
										)
									));
							
				$totalOrder		=	(isset($checkOrder[0][0]['totalOrder'])) ? $checkOrder[0][0]['totalOrder'] : $totalOrder;
				
				
				$salesTargetData	=	$this->SalesTarget->find("first",array(
											"conditions"	=>	array(
												"SalesTarget.sales_id"	=>	$salesId,
												"'".date("Y-m-d")."' BETWEEN SalesTarget.start_date AND SalesTarget.end_date"
											),
											"fields"		=>	array(
												"SalesTarget.total",
												"SalesTarget.start_date",
												"SalesTarget.end_date"
											)
										));
				
				$totalTarget		=	!empty($salesTargetData) ? $salesTargetData['SalesTarget']['total'] : $totalTarget;

				if (!empty($totalTarget)) {
					$prcnTarget		=	($totalOrder/$totalTarget)*100;
				}else{
					$prcnTarget = 0;
				}

				if ($prcnTarget < 50) {
					$statusBar	=	"progress-bar progress-bar-danger";
				}elseif ($prcnTarget <70) {
					$statusBar	=	"progress-bar progress-bar-warning";
				}elseif ($prcnTarget < 90) {
					$statusBar	=	"progress-bar progress-bar-info";
				}else{
					$statusBar	=	"progress-bar progress-bar-success";
				}
				
				$dataSchedules[$k]["Income"]["totalTarget"]	=	$totalTarget;
				$dataSchedules[$k]["Income"]["totalOrder"]	=	$totalOrder;
				$dataSchedules[$k]["Income"]["percent"]		=	empty($totalTarget) ? 0 : floor(($totalOrder/$totalTarget)*100);
				$dataSchedules[$k]["Income"]["bar"]			=	$statusBar;
			}
		}else{
			$idSales = null;
		}
		pr($dataSchedules);
		

		$lenS	=	strlen($totalOrder);

		if ($lenS <= 6) {
			$totalOrderToday	=	number_format($totalOrder,0,',','.');
		}elseif ($lenS < 10) {
			$bagiS	=	$totalOrder/1000000;
			$fixS	=	floor($bagiS);
			$totalOrderToday 	=	$fixS." Juta";
		}else{
			$bagiS	=	$totalOrder/1000000000;
			$fixS	=	round($bagiS, 1);
			$totalOrderToday 	=	$fixS." Miliar";
		}

		$this->set(compact(
			'dataSchedules',
			'prcnTarget',
			'statusBar',
			'totalOrderToday'
		));

		/*===== Get Chart =====*/
		$dataChart 		=	$this->Order->find('all', 
			array(
				'fields' => array(
					'DATE(Order.modified) AS tanggal',
					'SUM(CASE WHEN OrderList.product_id = '.'1'.' THEN OrderList.qty ELSE 0 END) as galon',
					'SUM(CASE WHEN OrderList.product_id = '.'2'.' THEN OrderList.qty ELSE 0 END) as gelas'
				),
				'joins' => array(
					array(
						'table' => 'order_lists',
						'alias'	=>	'OrderList',
						'type' => 'LEFT',
						'conditions' => array(
							'Order.id=OrderList.order_id',
						)
					)
				),
				'conditions'	=>	array(
						'Order.order_status_id'	=>	'4',
						'MONTH(Order.modified)' 	=>  date('m'),
						'YEAR(Order.modified)'		=>	date('Y')
					),
				'group'			=>	'DATE(tanggal)'
			)
		);

		$this->set(compact(
			'dataChart'
		));

		$this->loadModel('Target');
		/*===== Get Chart =====*/
		$datatarget 		=	$this->Target->find('first', 
			array(
				'conditions'	=>	array(
						'MONTH(target_date)' 	=>  date('m'),
						'YEAR(target_date)'		=>	date('Y')
					)
			)
		);
		pr($datatarget);

		$targetnya	=	$datatarget['Target']['target'];
		$persenTarget = (($angka/$targetnya)*100);

		$this->set(compact(
			'persenTarget',
			'datatarget'
		));
		/* Competitor Chart */
		$this->loadModel('CompetitorProducts');
		$dataComp 	=	$this->CompetitorProducts->find('all',array(
				'fields' => array(
						'CompetitorProducts.name', 
						'SUM(CASE WHEN schedule_logs.competitor_product_id = CompetitorProducts.id THEN schedule_logs.qty ELSE 0 END) as total'
				),
				'joins' => array(
					array(
						'table' => 'schedule_logs',
						'type' => 'LEFT',
						'conditions' => array(
							'CompetitorProducts.id=schedule_logs.competitor_product_id',
						)
					)
				),
				'conditions'	=>	array(
						'MONTH(schedule_logs.created)' 	=>  date('m'),
						'YEAR(schedule_logs.created)' 	=>  date('Y')
					),
				'group'			=>	'CompetitorProducts.name'
			)
		);
		$this->set(compact(
			'dataComp'
		));

		/* Maps Store */
		$dataStore 	=	$this->Schedule->find('all',array(
				'fields' => array(
					'Schedule.store_id, stores.name ,stores.latitude, stores.longitude', 
				),
				'joins' => array(
					array(
						'table' => 'stores',
						'type' => 'LEFT',
						'conditions' => array(
							'Schedule.store_id = stores.id',
						)
					)
				),
				'group'			=>	'Schedule.store_id'
			)
		);
		$this->set(compact(
			'dataStore'
		));
	
	/*===== TOP SALES =====*/
	$dataTop 		=	$this->Schedule->find('all', array(
			'fields'		=>	array(
									'User.id',
									'User.firstname',
									'User.lastname',
									'SUM(order_lists.qty * products.price) as Subtotal',
									'contents.url'
									),
			'joins'			=>	array(
									array(
									'table' => 	'users',
									'alias'	=>	'User',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Schedule.sales_id = User.id',
									)
								),
									array(
									'table' => 	'orders',
									'alias'	=>	'Orders',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Orders.schedule_id = Schedule.id',
										'Orders.order_status_id = 4'
									)
								),
									array(
									'table' => 	'order_lists',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Orders.id = order_lists.order_id'
									)
								),
									array(
									'table' => 	'products',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'products.id	=	order_lists.product_id'
									)
								),
									array(
									'table' => 	'sales_targets',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Schedule.sales_id	=	sales_targets.sales_id',
										'('.date('m').' BETWEEN sales_targets.start_date AND sales_targets.end_date )'
									)
								),
									array(
									'table'		=>	'contents',
									'type'		=>	'LEFT',
									'conditions'	=>	array(
										'model 	=	"user"',
										'type	=	"square"',
										'User.id = contents.model_id'
									)
								)
			),
			'conditions'	=>	array(
					'MONTH(Schedule.modified)'	=> date('m')
			),
			'group'			=> 	'User.id',
			'order' 		=>	array('Subtotal' => 'desc'),
			'limit'			=>	'10'
		));

		$this->set(compact(
			'dataTop'
		));

	}


	public function FunctionName()
	{
		# code...
		$this->autoRender	=	false;
		$this->autoLayout	=	false;
		
		
		$this->loadModel('Order');
		$this->loadModel('Schedule');
		$this->loadModel('User');
		
		$data 		=	$this->Schedule->find('all', array(
			'fields'		=>	array(
									'Users.id',
									'Users.firstname',
									'Users.lastname',
									'SUM(order_lists.qty * products.price) as Subtotal',
									'contents.url'
									),
			'joins'			=>	array(
									array(
									'table' => 	'Users',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Schedule.sales_id = Users.id',
									)
								),
									array(
									'table' => 	'orders',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Orders.schedule_id = Schedule.id',
										'Orders.order_status_id = 4'
									)
								),
									array(
									'table' => 	'order_lists',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Orders.id = order_lists.order_id'
									)
								),
									array(
									'table' => 	'products',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'products.id	=	order_lists.product_id'
									)
								),
									array(
									'table' => 	'sales_targets',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Schedule.sales_id	=	sales_targets.sales_id',
										'('.date('m').' BETWEEN sales_targets.start_date AND sales_targets.end_date )'
									)
								),
									array(
									'table'		=>	'contents',
									'type'		=>	'LEFT',
									'conditions'	=>	array(
										'model 	=	"user"',
										'type	=	"square"',
										'users.id = contents.model_id'
									)
								)
			),
			'conditions'	=>	array(
					'MONTH(Schedule.modified)'	=> date('m')
			),
			'group'			=> 	'users.id',
			'order' 		=>	array('Subtotal' => 'desc'),
			'limit'			=>	'10'
		));

		$total = 0;
		foreach ($data as $key) {
			# code...
			$total = ($key[0]['Subtotal'])+$total;
		}
		
		$fix = array();
		foreach ($data as $test) {
			$hem	=	$test[0]['Subtotal'];
			$percentage 	=	($hem/$total)*100;
			$fix[] = array('percentage' => floor($percentage));
		}
		/*pr($fix);
		pr($data);*/
		
	}

	/*
	
	*/
	public function ReportOrder()
	{
		# code...
		if ($this->access[$this->aco_id]["_read"] != "1"){
			$this->render("/Errors/no_access");
			return;
		}
		$this->loadModel("Schedule");
		$data 		=	$this->Schedule->find('all', array(
			'fields'		=>	array(
									'orders.id',
									'DATE(orders.modified) AS date',
									'CONCAT(users.firstname, users.lastname) AS sales',
									'stores.name AS store',
									'stores.address'
									/*'SUM(CASE WHEN order_lists.product_id = 1 THEN order_lists.qty ELSE 0 END) AS glass',
									'SUM(CASE WHEN order_lists.product_id = 2 THEN order_lists.qty ELSE 0 END) AS galon'*/
									),
			'joins'			=>	array(
									array(
									'table' => 	'users',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Schedule.sales_id = users.id',
									)
								),
									array(
									'table' => 	'orders',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'orders.schedule_id = Schedule.id',
										'orders.order_status_id = 4'
									)
								),
									array(
									'table' => 	'order_lists',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'orders.id = order_lists.order_id'
									)
								),
									array(
									'table' => 	'stores',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Schedule.store_id = stores.id'
									)
								)
			),
			'conditions'	=>	array(
					'orders.order_status_id' => '4',
					/*'DATE(orders.modified) BETWEEN ? AND ?' => array($start_date, $end_date)*/
			),
			'group'			=> 	'orders.id',
			'order' 		=>	array('orders.id' => 'asc')
		));

		$this->loadModel('Order');
		$totaltoday 	= $this->Order->find('first', array(
				'fields'		=>	'COUNT(id) AS today',
				'conditions'	=>	array(
						'order_status_id'	=> '4',
						'DATE(modified)'	=> date('Y-m-d')
					)
			)
		);
		$totalmonth 	= $this->Order->find('first', array(
				'fields'		=>	'COUNT(id) AS month',
				'conditions'	=>	array(
						'order_status_id'	=> '4',
						'YEAR(modified)'	=> date('Y'),
						'MONTH(modified)'	=> date('m')
					)
			)
		);
		$totallast 	= $this->Order->find('first', array(
				'fields'		=>	'COUNT(id) AS last',
				'conditions'	=>	array(
						'order_status_id'	=> '4',
						'YEAR(modified)'	=> date('Y'),
						'MONTH(modified)'	=> date("m", strtotime("-1 months"))
					)
			)
		);
		$totalyear 	= $this->Order->find('first', array(
				'fields'		=>	'COUNT(id) AS year',
				'conditions'	=>	array(
						'order_status_id'	=> '4',
						'YEAR(modified)'	=> date('Y')
					)
			)
		);

			/*pr($totaltoday);
			pr($totalmonth);
			pr($totallast);
			pr($totalyear);*/
		
		$this->set(compact(
			'data',
			'totaltoday',
			'totalmonth',
			'totallast',
			'totalyear'
		));
	}

	function GetData($start_date = null, $end_date = null)
	{
		$this->autoRender	=	false;
		$this->autoLayout	=	false;

		$this->loadModel("Schedule");
		$data 		=	$this->Schedule->find('all', array(
			'fields'		=>	array(
									'orders.id',
									'DATE(orders.modified) AS date',
									'CONCAT(users.firstname, users.lastname) AS sales',
									'stores.name AS store',
									'stores.address',
									'SUM(CASE WHEN order_lists.product_id = 1 THEN order_lists.qty ELSE 0 END) AS glass',
									'SUM(CASE WHEN order_lists.product_id = 2 THEN order_lists.qty ELSE 0 END) AS galon'
									),
			'joins'			=>	array(
									array(
									'table' => 	'Users',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Schedule.sales_id = Users.id',
									)
								),
									array(
									'table' => 	'orders',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Orders.schedule_id = Schedule.id',
										'Orders.order_status_id = 4'
									)
								),
									array(
									'table' => 	'order_lists',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Orders.id = order_lists.order_id'
									)
								),
									array(
									'table' => 	'stores',
									'type' 	=> 	'LEFT',
									'conditions' => array(
										'Schedule.store_id = stores.id'
									)
								)
			),
			'conditions'	=>	array(
					'orders.order_status_id' => '4',
					'DATE(orders.modified) BETWEEN ? AND ?' => array($start_date, $end_date)
			),
			'group'			=> 	'orders.id',
			'order' 		=>	array('orders.id' => 'asc')
		));

		pr($data);

	}

}
