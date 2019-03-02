<?php
class ScheduleLog extends AppModel
{
	function ValidateCheckRival()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'schedule_id' => array(
				'ValidateSchedule' => array(
					'rule' => "ValidateSchedule"
				)
			),
			'competitor_product_id' => array(
				'ValidateCompetitorProduct' => array(
					'rule' => "ValidateCompetitorProduct",
					'message' => __d('validation',"Please insert competitor product quantity")
				)
			)
		);
	}
	
	
	function ValidateCompetitorProduct()
	{
		if(isset($this->data[$this->name]['competitor_product_id']))
		{
			return (is_array($this->data[$this->name]['competitor_product_id']) && count($this->data[$this->name]['competitor_product_id']) > 0);
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
}
?>