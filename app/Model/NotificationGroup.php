<?php
class NotificationGroup extends AppModel
{
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
				$this->data[$this->name]['message']	=	htmlspecialchars($this->data[$this->name]['message'],ENT_QUOTES|ENT_HTML401);
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
	
	public function ValidateData()
	{
		$this->validate 	= array(
			'recipient_id' => array(
				'ValidateRecipient' => array(
					'rule' => "ValidateRecipient",
					'message' => __d('validation',"Please select recipient list")
				)
			),
			'title' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please insert title message")
				)
			),
			'message' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please insert sort description message")
				)
			),
			'description' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please insert message detail")
				)
			)
		);
	}
	
	function ValidateRecipient()
	{
		$recipient_id	=	$this->data[$this->name]['recipient_id'];
		return (is_array($recipient_id) && count($recipient_id) > 0);
	}
}
?>