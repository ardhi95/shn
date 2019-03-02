<?php
class SalesTarget extends AppModel
{
	
	public function beforeSave($options = array())
	{
		return $this->beforeValidate($options);
	}
	
	public function beforeValidate($options = array())
	{
		if(isset($this->data[$this->name]['start_date']) && !empty($this->data[$this->name]['start_date']))
		{
			$this->data[$this->name]['start_date']	=	date("Y-m-d",strtotime($this->data[$this->name]['start_date']))." 00:00:00";
		}
		if(isset($this->data[$this->name]['end_date']) && !empty($this->data[$this->name]['end_date']))
		{
			$this->data[$this->name]['end_date']	=	date("Y-m-d",strtotime($this->data[$this->name]['end_date']))." 23:59:59";
		}
		
		if(isset($this->data[$this->name]['total']))
		{
			$this->data[$this->name]['total']	=	str_replace(",","",$this->data[$this->name]['total']);
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
	}
	
	function ValidateData()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'sales_id' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Sales ID not found!")
				)
			),
			'start_date' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please select target start date")
				),
				'ValidateStartDate' => array(
					'rule' => "ValidateStartDate",
					'message' => __d('validation',"Target date range is inside another range target, please select another date range")
				)
			),
			'end_date' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please select target end date")
				)
			),
			'total' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please insert total target")
				)
			)
		);
	}
	
	public function ValidateStartDate()
	{
		if(
			isset($this->data[$this->name]['start_date']) &&
			isset($this->data[$this->name]['end_date'])
		)
		{
			$startDate		=	$this->data[$this->name]['start_date'];
			$endDate		=	$this->data[$this->name]['end_date'];
			$salesId		=	$this->data[$this->name]['sales_id'];
			
			//CHECK RANGE
			$check			=	$this->find("first",array(
									"conditions"	=>	array(
										"OR"	=>	array(
											"'".$startDate."' BETWEEN {$this->name}.start_date AND {$this->name}.end_date",
											"'".$endDate."' BETWEEN {$this->name}.start_date AND {$this->name}.end_date",
										),
										"{$this->name}.sales_id"	=>	$salesId
									)
								));
								
			return empty($check);
		}
		return true;
	}
}
?>