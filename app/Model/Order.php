<?php
class Order extends AppModel
{
	
	public function beforeSave($options = array())
	{
		return $this->beforeValidate($options);
	}
	
	public function beforeValidate($options = array())
	{
		if(isset($this->data[$this->name]['delivery_date']))
		{
			if(!empty($this->data[$this->name]['delivery_date']))
			{
				$this->data[$this->name]['delivery_date']	=	date("Y-m-d H:i:s",strtotime($this->data[$this->name]['delivery_date'].date("H:i:s")));
			}
		}
		
		if(isset($this->data[$this->name]['update_status_id']))
		{
			if($this->data[$this->name]['update_status_id'] != "4")
			{
				if(!empty($this->data[$this->name]['delivery_date']))
					unset($this->data[$this->name]['delivery_date']);
			}
		}
		return true;
	}
	
	public function afterSave($created,$options = array())
	{
		if($created)
		{
		}
	}
	
	public function afterDelete()
	{
		//DELETE IMAGE CONTENT
		App::import('Component','General');
		$General		=	new GeneralComponent();
		$General->DeleteContent($this->id,$this->name);
	}
	
	function ValidateAddSales()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'schedule_id' => array(
				'ValidateSchedule' => array(
					'rule' => "ValidateSchedule"
				)
			),
			'product_id' => array(
				'ValidateProduct' => array(
					'rule' 		=> "ValidateProduct",
					'message' 	=> __d('validation',"Please insert at least one quantity  of product")
				)
			)
		);
	}
	
	function ValidateUpdateStatus()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'update_status_id' => array(
				'notBlank' => array(
					'rule' 		=> "notBlank",
					"message"	=>	"Please select update status"
				)
			),
			'delivery_date' => array(
				'ValidateUpdateToFinish' => array(
					'rule' 		=> "ValidateUpdateToFinish"
				)
			)
		);
	}
	
	function ValidateUpdateToFinish()
	{
		$update_status_id	=	$this->data[$this->name]["update_status_id"];
		if($update_status_id == "4")
		{
			$deliveryDate	=	$this->data[$this->name]["delivery_date"];
			if(empty($deliveryDate))
			{
				return __d('validation',"Please insert delivery date");
			}
			else
			{
				$detail					=	$this->findById($this->data[$this->name]['id']);
				$orderDateTimeStamp		=	strtotime($detail[$this->name]["modified"]);
				$deliveryDateTimeStamp	=	strtotime($deliveryDate);
				
				if($deliveryDateTimeStamp < $orderDateTimeStamp)
				{
					return __d('validation',"Delivery date must greater than order date");
				}
			}
		}
		return true;
	}
	
	function ValidateProduct()
	{
		if(isset($this->data[$this->name]['product_id']))
		{
			return (is_array($this->data[$this->name]['product_id']) && count($this->data[$this->name]['product_id']) > 0);
		}
		return true;
	}
	
	function ValidateSchedule()
	{
		if(
			isset($this->data[$this->name]['schedule_id']) &&
			isset($this->data[$this->name]['sales_id'])
		)
		{
			if(
				!empty($this->data[$this->name]['schedule_id']) &&
				!empty($this->data[$this->name]['sales_id'])
			)
			{
				$Schedule		=	ClassRegistry::Init("Schedule");
				$check			=	$Schedule->find("first",array(
										"conditions"	=>	array(
											"Schedule.sales_id"		=>	$this->data[$this->name]['sales_id'],
											"Schedule.id"			=>	$this->data[$this->name]['schedule_id']
										)
									));
				if(empty($check))
				{
					return __d('validation',"Schedule not found");
				}
				else
				{
					//CHECK DETAIL SCHEDULE
					$firstInputData	=	$check["Schedule"]["first_input_data"];
					if(!is_null($firstInputData))
					{
						$firstInputDataTimeStamp	=	strtotime($firstInputData);
						$now						=	time();
						
						if(($now - $firstInputDataTimeStamp) > (3600 * 1))
						{
							return __d('validation',"You cannot edit the data after one hour.");
						}
					}
				}
			}
			else if(empty($this->data[$this->name]['schedule_id']))
			{
				return __d('validation',"Schedule not found");
			}
			else if(empty($this->data[$this->name]['sales_id'])) 
			{
				return __d('validation',"Your profile not found");
			}
		}
		else if(!isset($this->data[$this->name]['schedule_id']))
		{
			return __d('validation',"Schedule not found");
		}
		else if(!isset($this->data[$this->name]['sales_id'])) 
		{
			return __d('validation',"Your profile not found");
		}
		return true;
	}
	
	public function GetTotalOrderSales($salesId)
	{
		$totalTarget		=	0;
		$totalOrder			=	0;
		
		//GET SALES TARGET
		$SalesTarget		=	ClassRegistry::Init("SalesTarget");
		$salesTargetData	=	$SalesTarget->find("first",array(
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
		
		
		//GET SALES ORDER
		$Schedule		=	ClassRegistry::Init("Schedule");
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
		
		$checkOrder		=	$Schedule->find("all",array(
								"joins"		=>	$joins,
								"fields"	=>	array(
									"SUM(OrderList.qty*Product.price) as totalOrder"
								),
								"conditions"	=>	array(
									"Schedule.sales_id"		=>	$salesId,
									"Order.order_Status_id"	=>	4,
									"Schedule.schedule_date BETWEEN ? AND ?" => array($salesTargetData["SalesTarget"]["start_date"],$salesTargetData["SalesTarget"]["end_date"])
									
								)
							));
							
		$totalOrder		=	(isset($checkOrder[0][0]['totalOrder'])) ? $checkOrder[0][0]['totalOrder'] : $totalOrder;
		
		$salesTargetId	=	!empty($salesTargetData['SalesTarget']['id']) ? $salesTargetData['SalesTarget']['id'] : false;
		
		return array(
			"totalTarget"	=>	$totalTarget,
			"totalOrder"	=>	$totalOrder,
			"salesTargetId"	=>	$salesTargetId
		);
	}

	
}
?>