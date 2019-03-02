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
		$this->loadModel('Employee');
		$data 			=	$this->Employee->find('count');
		$dataMale		=	$this->Employee->find('count', array(
							'conditions'	=>	array(
								"Employee.gender"	=>	"m"
							)
						));
		$dataFemale		=	$this->Employee->find('count', array(
							'conditions'	=>	array(
								"Employee.gender"	=>	"f"
							)
						));
		$dataMarital	=	$this->Employee->find('all', array(
							'fields'	=>	array(
								"IF(marital_status = 'm', 'Married', 'Single') AS marital_status",
								"COUNT(`marital_status`) as total"
							),
							'group'		=>	"Employee.marital_status"
						));
		// var_dump($dataMarital);
		/*===== Health employees =====*/
		$dataHB			=	$this->Employee->find('count', array(
							'conditions'	=>	array(
								"Employee.health_record"	=>	"b"
							)
						));
		$dataHG			=	$this->Employee->find('count', array(
							'conditions'	=>	array(
								"Employee.health_record"	=>	"g"
							)
						));

		$dataHealtly 	=	round(($dataHG/($dataHG + $dataHB))*100);
		/*===== Health employees =====*/

		$this->set(compact(
			"data",
			"dataMale",
			"dataFemale",
			"dataMarital",
			"dataHealtly"
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
