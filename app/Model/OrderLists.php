<?php
class OrderLists extends AppModel
{
	
	public function beforeSave($options = array())
	{
		return $this->beforeValidate($options);
	}
}
?>