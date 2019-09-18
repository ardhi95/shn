<?php
class Activity extends AppModel
{
	public function BindDefault($reset	=	true)
	{
		$this->bindModel(array(
			"belongsTo"	=>	array(
				"LogBook",
				"User",
				"ActivityType",
				"Gerombolan"
			)
		),$reset);
	}
	
	
	public function beforeSave($options = array())
	{
		$this->beforeValidate($options);
		return true;	
	}
	
	public function beforeValidate($options = array())
	{
		if(
			isset($this->data[$this->name]["activity_date"]) && 
			isset($this->data[$this->name]["activity_start_time"]) && 
			isset($this->data[$this->name]["activity_end_time"])
		)
		{
			$this->data[$this->name]["start_date"]	=	$this->data[$this->name]["activity_date"]." ".$this->data[$this->name]["activity_start_time"].":00";
			$this->data[$this->name]["end_date"]	=	$this->data[$this->name]["activity_date"]." ".$this->data[$this->name]["activity_end_time"].":00";
		}
		return true;
	}
	
	function ValidateData()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'user_id' => array(
				'notBlank'	=> array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation',"Maaf profil Anda tidak ditemukan")
				)
			),
			'log_book_id' => array(
				'notBlank'	=> array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation',"Maaf no SIPI Anda tidak ditemukan")
				)
			),
			'activity_type_id' => array(
				'notBlank'	=> array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation',"Pilih tipe aktifitas")
				)
			),
			'activity_date' => array(
				'notBlank'	=> array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation',"Masukkan tanggal aktifitas")
				)
			),
			'activity_start_time' => array(
				'notBlank'	=> array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation',"Masukkan jam mulai aktifitas")
				)
			),
			'activity_end_time' => array(
				'notBlank'	=> array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation',"Masukkan jam selesai aktifitas")
				)
			),
			'lama_pancing' => array(
				'ValidateLama'	=> array(
					'rule' 		=> "ValidateLama"
				)
			),
			'jmlh_mata_pancing' => array(
				'ValidateJmlh'	=> array(
					'rule' 		=> "ValidateJmlh"
				)
			),
			'jarak_mata_pancing' => array(
				'ValidateJarak'	=> array(
					'rule' 		=> "ValidateJarak"
				)
			),
			'activity_date' => array(
				'notBlank'	=> array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation',"Pilih tanggal aktifitas")
				)
			),
			'activity_start_time' => array(
				'notBlank'	=> array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation',"Pilih jam mulai aktifitas")
				)
			),
			'activity_end_time' => array(
				'notBlank'	=> array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation',"Pilih jam selesai aktifitas")
				)
			)
		);
	}
	
	
	function ValidateJmlh()
	{
		
		if(!empty($this->data[$this->name]["activity_type_id"]))
		{
			$activityTypeId	=	$this->data[$this->name]["activity_type_id"];
			if($activityTypeId == "2")
			{
				if(strlen($this->data[$this->name]["jmlh_mata_pancing"])<=0)
				{
					return "Masukkan jumlah mata pancing";
				}
			}
		}
		
		return true;
	}
	
	function ValidateJarak()
	{
		
		if(!empty($this->data[$this->name]["activity_type_id"]))
		{
			$activityTypeId	=	$this->data[$this->name]["activity_type_id"];
			if($activityTypeId == "2")
			{
				if(strlen($this->data[$this->name]["jarak_mata_pancing"])<=0)
				{
					return "Masukkan jarak mata pancing";
				}
			}
		}
		
		return true;
	}
	
	function ValidateLama()
	{
		
		if(!empty($this->data[$this->name]["activity_type_id"]))
		{
			$activityTypeId	=	$this->data[$this->name]["activity_type_id"];
			if($activityTypeId == "2")
			{
				if(strlen($this->data[$this->name]["lama_pancing"])<=0)
				{
					return "Masukkan lama pancing";
				}
			}
		}
		
		return true;
	}
	
	
	function ValidateUserId()
	{
		if(isset($this->data[$this->name]["user_id"]))
		{
			$User		=	ClassRegistry::Init("User");
			$user_id	=	$this->data[$this->name]["user_id"];
			$checkUser	=	$User->find("first",array(
								"conditions"	=>	array(
									"User.id"		=>	$user_id,
									"User.status"	=>	"1"
								)
							));
			return !empty($checkUser);
		}
		return false;
	}
	
	function ValidateStudioId()
	{
		if(isset($this->data[$this->name]["studio_id"]))
		{
			$Studio		=	ClassRegistry::Init("Studio");
			$studio_id	=	$this->data[$this->name]["studio_id"];
			$check		=	$Studio->find("first",array(
								"conditions"	=>	array(
									"Studio.id"		=>	$studio_id,
									"Studio.status"	=>	"1"
								)
							));
			return !empty($check);
		}
		return false;
	}
	
	function ValidateStar()
	{
		if(isset($this->data[$this->name]["star"]))
		{
			$star			=	$this->data[$this->name]["star"];
			$description	=	$this->data[$this->name]["description"];
			
			if(empty($star) && empty($description))
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		return false;
	}
}
?>