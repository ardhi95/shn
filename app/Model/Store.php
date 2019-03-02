<?php
class Store extends AppModel
{
	
	public function beforeSave($options = array())
	{
		return $this->beforeValidate($options);
	}
	
	public function beforeValidate($options = array())
	{
		if(isset($this->data[$this->name]['latitude']))
		{
			$this->data[$this->name]['latitude']	=	empty($this->data[$this->name]['latitude']) ? NULL : $this->data[$this->name]['latitude'];
		}
		if(isset($this->data[$this->name]['longitude']))
		{
			$this->data[$this->name]['longitude']	=	empty($this->data[$this->name]['longitude']) ? NULL : $this->data[$this->name]['longitude'];
		}
		if(isset($this->data[$this->name]['phone1']))
		{
			$this->data[$this->name]['phone1']	=	empty($this->data[$this->name]['phone1']) ? NULL : $this->data[$this->name]['phone1'];
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
		$Schedule		=	ClassRegistry::Init("Schedule");
		$Schedule->deleteAll(array("store_id" => $this->id),true,true);*/
	}
	
	function ValidateData()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'name' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please insert store name")
				)
			),
			'address' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please insert store address")
				)
			),
			'owner' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please insert owner name")
				)
			),
			'images' => array(
				'imagewidth'	=> array(
					'rule' 		=> array('imagewidth',300),
					'message' 	=> __d('validation','Please upload image with minimum width is %s px',array(300))
				),
				'imageheight'	=> array(
					'rule' 		=> array('imageheight',300),
					'message' 	=> __d('validation','Please upload image with minimum width is %s px',array(300))
				),
				'extension' => array(
					'rule' => array('validateName', array('gif','jpeg','jpg','png')),
					'message' => __d('validation','Only (*.gif,*.jpeg,*.jpg,*.png) are allowed.')
				)
			),
			'latitude' => array(
				'notBlank'	=>	array(
					'rule' 			=>	"notBlank",
					'message' 		=>	__d('validation',"Select store position")
				)
			)
		);
	}
	
	
	function ValidateAddStore()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'creator_id' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Your profile not found")
				)
			),
			'name' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please insert store name")
				),
				'minLength' => array(
					'rule' 		=> array("minLength","3"),
					'message' 	=> __d('validation',"Store name is too short")
				),
				'maxLength' => array(
					'rule' 		=> array("maxLength",200),
					'message' 	=> __d('validation',"Store name is too long")
				)
			),
			'address' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please insert store address")
				),
				'minLength' => array(
					'rule' 		=> array("minLength","3"),
					'message' 	=> __d('validation',"Store address is too short")
				),
				'maxLength' => array(
					'rule' 		=> array("maxLength",200),
					'message' 	=> __d('validation',"Store address is too long")
				)
			),
			'latitude' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please set map location for store")
				)
			),
			'city_id' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please select city")
				)
			),
			'owner' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please insert owner name")
				)
			)
		);
	}
	
	function ValidateCreatorId()
	{
		if(isset($this->data[$this->name]["creator_id"]))
		{
			$creator_id	=	$this->data[$this->name]["creator_id"];
			$User		=	ClassRegistry::Init("User");
			
			$check		=	$User->find("first",array(
								"conditions"	=>	array(
									"User.aro_id"	=>	"14",
									"User.id"		=>	$creator_id,
									"User.status"	=>	"1"
								)
							));
			return !empty($check);
		}
		return false;
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