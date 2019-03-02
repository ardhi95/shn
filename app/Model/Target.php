<?php
class Target extends AppModel
{
	var $aco_id;
	

	public function beforeSave($options = array())
	{
		App::Import("Components","General");
		$General		=	new GeneralComponent();
		
		foreach($this->data[$this->name] as $key => $name)
		{
			if(!is_array($this->data[$this->name][$key]) && isset($this->data[$this->name][$key]))
				$this->data[$this->name][$key]		=	trim($this->data[$this->name][$key]);
		}
		if(isset($this->data[$this->name]['target']))
		{
			$this->data[$this->name]['target']	=	str_replace(",","",$this->data[$this->name]['target']);
		}
		if(isset($this->data[$this->name]['target_date']))
		{
			$this->data[$this->name]['target_date']	=	date('Y-m-d',strtotime($this->data[$this->name]['target_date']));
		}

		return true;
	}

	function afterSave($created,$options = array())
	{
		if($created)
		{
			$Aro	=	ClassRegistry::Init("MyAro");
			$add	=	$Aro->updateAll(
							array(
								"total_admin"	=>	"total_admin + 1"
							),
							array(
								"MyAro.id"		=>	$this->data[$this->name]['aro_id']
							)
						);
		}
	}


	public function beforeDelete($cascade = false)
	{
		//GET DETAIL
		$detail				=	$this->find("first",array(
									"conditions"	=>	array(
										"{$this->name}.id"	=>	$this->id
									)
								));
		$this->aco_id		=	$detail[$this->name]["aro_id"];
	}


	public function afterFind($results, $primary = false) {
		/*App::Import("Components","General");
		$General		=	new GeneralComponent();

		foreach ($results as $key => $val)
		{
			if(isset($results[$key][$this->name]['password']))
			{
				$results[$key][$this->name]['password'] 	=	$General->my_decrypt($val[$this->name]['password']);
			}
		}*/
		return $results;
	}
	

	public function BindDefault($reset	=	true)
	{
		$this->bindModel(array(
			"belongsTo"	=>	array(
				"MyAro"	=>	array(
					"foreignKey"	=>	"aro_id"
				)
			)
		),$reset);
	}


	function ValidateData()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'target' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please enter target")
				)
			),
			'target_date' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please enter month")
				),
				'ValidateStartDate' => array(
					'rule' => "ValidateStartDate",
					'message' => __d('validation',"Target date is inside another target, please select another date")
				)
			)
		);
	}
	
	public function ValidateStartDate()
	{
		if(
			isset($this->data[$this->name]['target_date'])
		)
		{
			$startDate		=	date('Y-m-d',strtotime($this->data[$this->name]['target_date']));
			
			//CHECK RANGE
			$check			=	$this->find("first",array(
									"conditions"	=>	array(
										"{$this->name}.target_date" => $startDate
									)
								));
								
			return empty($check);
		}
		return true;
	}

}
?>
