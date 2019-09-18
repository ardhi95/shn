<?php
class Schedule extends AppModel
{
	
	public function beforeSave($options = array())
	{
		return $this->beforeValidate($options);
	}
	
	public function beforeValidate($options = array())
	{
		if(isset($this->data[$this->name]['schedule_date']))
		{
			if(!empty($this->data[$this->name]['schedule_date']))
			{
				$this->data[$this->name]['schedule_date']	=	date("Y-m-d H:i:s",strtotime($this->data[$this->name]['schedule_date'].":00"));
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
		
		/*//DELETE SCHEDULE
		$ScheduleLog		=	ClassRegistry::Init("ScheduleLog");
		$ScheduleLog->deleteAll(array("schedule_id" => $this->id),true,true);*/
	}
	
	function ValidateData()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'schedule_date' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please insert schedule date")
				),
				'GreaterToDay' => array(
					'rule' => "GreaterToDay",
					'message' => __d('validation',"Schedule date must higher or equal than today")
				)
			),
			'sales_id' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please select sales")
				)
			),
			'store_id' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please select store")
				)
			)
		);
	}
	
	function ValidateAddStoreToScchedule()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'sales_id' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Your profile not found")
				)
			),
			'store_id' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Store not found")
				),
				'ValidateStoreAddSchedule' => array(
					'rule' 		=> "ValidateStoreAddSchedule",
					'message' 	=> __d('validation',"Store not found")
				),
				'CanAddSchedule' => array(
					'rule' 		=> "CanAddSchedule",
					'message' 	=> __d('validation',"Cannot add schedule, schedule only can add between 07:00 AM until 10:00 PM")
				)
			)
		);
	}
	
	function ValidateStoreAddSchedule()
	{
		$storeId	=	$this->data[$this->name]["store_id"];
		$creatorId	=	$this->data[$this->name]["sales_id"];
		
		$Store		=	ClassRegistry::Init("Store");
		$check		=	$Store->find("first",array(
							"conditions"	=>	array(
								"Store.id"				=>	$storeId,
								"Store.creator_id"		=>	$creatorId
							)
						));
						
		return !empty($check);
	}
	
	function CanAddSchedule()
	{
		$now			=	time();
		$jobStart		=	mktime(7,0,0,date("n"),date("j"),date("Y"));
		$jobEnd			=	mktime(21,59,59,date("n"),date("j"),date("Y"));
		
		return ($now>$jobStart && $now < $jobEnd);
	}
	
	function ValidateCheckin()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'id' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Schedule not found")
				),
				'ValidateCheckinId' => array(
					'rule' => "ValidateCheckinId"
				)
			),
			'sales_id' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Your account not found!")
				)
			)
		);
	}
	
	
	function ValidateCheckinId()
	{
		if(isset($this->data[$this->name]["id"]) && isset($this->data[$this->name]["sales_id"]))
		{
			$scheduleId		=	$this->data[$this->name]["id"];
			$salesId		=	$this->data[$this->name]["sales_id"];
			
			$check			=	$this->find("first",array(
									"conditions"	=>	array(
										"{$this->name}.id"			=>	$scheduleId
									)
								));
			
			if(!empty($check))
			{			
				if($check[$this->name]["sales_id"] != $salesId)
				{
					return "Schedule not found!";
				}
				else if($check[$this->name]["checkin_status_id"] != "1")
				{
					return "You already checkin here!";
				}
			}
			else
			{
				return "Schedule not found!";
			}
		}
		return true;
	}
	
	function GreaterToDay()
	{
		if(isset($this->data[$this->name]['schedule_date']))
		{
			if(!empty($this->data[$this->name]['schedule_date']))
			{
				$scheduleDate	=	strtotime($this->data[$this->name]['schedule_date']);
				$now			=	mktime(0,0,0,date("n"),date("j"),date("Y"));
				return $scheduleDate > $now;
			}
		}
		return true;
	}
	
	function VirtualFieldActivated()
	{
		$this->virtualFields = array(
			"SStatus"		=> 'IF(('.$this->name.'.status=\'1\'),\'Active\',\'Not Active\')'
		);
	}
	
	public function BindImageContent($reset	=	true)
	{
		$this->bindModel(array(
			"hasOne"	=>	array(
				"Thumbnail"	=>	array(
					"className"	=>	"Content",
					"foreignKey"	=>	"model_id",
					"conditions"	=>	array(
						"Thumbnail.model"	=>	$this->name,
						"Thumbnail.type"	=>	"square"
					)
				),
				"MaxWidth"	=>	array(
					"className"	=>	"Content",
					"foreignKey"	=>	"model_id",
					"conditions"	=>	array(
						"MaxWidth.model"	=>	$this->name,
						"MaxWidth.type"		=>	"maxwidth"
					)
				)
			)
		),$reset);
	}
	
	public function BindDefault($reset	=	true)
	{
		$this->bindModel(array(
			"belongsTo"	=>	array(
				"Sales"	=>	array(
					"foreignKey"	=>	"sales_id",
					"className"		=>	"User"
				),
				"Store"	=>	array(
					"foreignKey"	=>	"store_id",
					"className"		=>	"Store"
				),
				"CheckinStatus"	=>	array(
					"foreignKey"	=>	"checkin_status_id",
					"className"		=>	"CheckinStatus"
				)
			)
		),$reset);
	}
	
	function size( $field=array(), $aloowedsize)
    {
		foreach( $field as $key => $value ){
            $size = intval($value['size']);
            if($size > $aloowedsize) {
                return FALSE;
            } else {
                continue;
            }
        }
        return TRUE;
    }


	function notEmptyImage($fields = array())
	{
		foreach($fields as $key=>$value)
		{
			if(empty($value['name']))
			{
				return false;
			}
		}

		return true;
	}

	function validateName($file=array(),$ext=array())
	{
		$err	=	array();
		$i=0;

		foreach($file as $file)
		{
			$i++;

			if(!empty($file['name']))
			{
				if(!Validation::extension($file['name'], $ext))
				{
					return false;
				}
			}
		}
		return true;
	}

	function imagewidth($field=array(), $allowwidth=0)
	{

		foreach( $field as $key => $value ){
			if(!empty($value['name']))
			{
				$imgInfo	= getimagesize($value['tmp_name']);
				$width		= $imgInfo[0];

				if($width < $allowwidth)
				{
					return false;
				}
			}
        }
        return TRUE;
	}

	function imageheight($field=array(), $allowheight=0)
	{
		foreach( $field as $key => $value ){
			if(!empty($value['name']))
			{
				$imgInfo	= getimagesize($value['tmp_name']);
				$height		= $imgInfo[1];

				if($height < $allowheight)
				{
					return false;
				}
			}
        }
        return TRUE;
	}
}
?>