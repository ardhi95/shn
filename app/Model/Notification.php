<?php
class Notification extends AppModel
{
	public $belongsTo = array(
        'NotificationGroup' => array(
            'counterCache' => array(
				'total_recipient'		=>	array(),
				'total_arrival_message'	=>	array(
					'Notification.is_arrival'	=>	'1'
				),
				'total_read_message'	=>	array(
					'Notification.is_readed'	=>	'1'
				),
			)
        )
    );
	
	public function beforeSave($options = array())
	{
		return $this->beforeValidate($options);
	}
	
	public function beforeValidate($options = array())
	{
		/*if(isset($this->data[$this->name]['message']))
		{
			if(!empty($this->data[$this->name]['message']))
			{
				$this->data[$this->name]['message']		=	htmlspecialchars($this->data[$this->name]['message'],ENT_QUOTES | ENT_HTML401);
			}
		}*/
		
		if(isset($this->data[$this->name]['title']))
		{
			if(!empty($this->data[$this->name]['title']))
			{
				$this->data[$this->name]['title']	=	strip_tags($this->data[$this->name]['title']);
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
	
	function ValidateData()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'name' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please insert store name")
				)
			)
		);
	}
}
?>