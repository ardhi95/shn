<?php
class UserExtid extends AppModel
{
	public function __construct( $id = false, $table = NULL, $ds = NULL )
    {
        $this->locale       =   Configure::read('Config.language');
        parent::__construct($id,$table,$ds);
    }
	
	public function beforeSave($options = array())
	{
		return true;
	}
	
	function ValidateData()
	{
		App::uses('CakeNumber', 'Utility');
		
		$this->validate 	= array(
			'app_id' => array(
				'notBlank'	=> array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation',"Aplikasi ID tidak ditemukan")
				)
			),
			'app_name' => array(
				'notBlank'	=> array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation',"Nama social media tidak ditemukan")
				),
				'SocialMediaAllowed'	=> array(
					'rule' 		=> "SocialMediaAllowed"
				)
			),
			'first_name' => array(
				'notBlank'	=> array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation',"Nama depan tidak boleh kosong")
				)
			),
			'email' => array(
				'notBlank'	=> array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation',"Maaf kami tidak dapat menemukan email Anda")
				),
				'email'	=> array(
					'rule' 		=> "email",
					'message' 	=> __d('validation',"Format email salah")
				)
			),
			'fb_access_token' => array(
				'notEmptyAccessToken'	=> array(
					'rule' 		=> "notEmptyAccessToken",
					'message' 	=> __d('validation',"Facebook access token tidak ditemukan!")
				)
			)
		);
	}
	
	
	public function notEmptyAccessToken()
	{
		if(isset($this->data[$this->name]['app_name']))
		{
			if(strtolower($this->data[$this->name]['app_name']) == "facebook")
			{
				return !empty($this->data[$this->name]['fb_access_token']);
			}
		}
		return true;
	}
	
	
	public function SocialMediaAllowed()
	{
		if(isset($this->data[$this->name]['app_name']))
		{
			if(!in_array(strtolower($this->data[$this->name]['app_name']),array('facebook','google')))
			{
				return __d('validation',"Maaf kami belum memiliki fitur untuk terkoneksi dengan social media %s",$this->data[$this->name]['app_name']);
			}
		}
		return true;
	}
	
}