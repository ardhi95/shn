<?php
class City extends AppModel
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
	
	public function BindImage($reset	=	true)
	{
		$this->bindModel(array(
			"hasOne"	=>	array(
				"Image"	=>	array(
					"className"		=>	"Content",
					"foreignKey"	=>	"model_id",
					"conditions"	=>	array(
						"Image.model"		=>	$this->name,
						"Image.type"		=>	"maxwidth"
					)
				)
			)
		),$reset);
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


	function ValidateLoginAdmin()
	{
		$this->validate 	= array(
			'email' => array(
				'notBlank' => array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation','Please insert your email.')
				),
				'email' => array(
					'rule' 		=> "email",
					'message' 	=> __d('validation','Your email is not valid.')
				),
				'IsEmailExists' => array(
					'rule' 		=> "IsEmailExists",
					'message' 	=> __d('validation','Your email is not registered as Admin.')
				)
			),
			'password' => array(
				'notBlank' => array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation','Please insert your password.')
				),
				'CheckPassword' => array(
					'rule' 		=> "CheckPassword",
					'message' 	=> __d('validation','Your password is wrong!')
				)
			)
		);
	}

	function ValidateData()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'firstname' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please enter first name")
				),
				'minLength' => array(
					'rule' 		=> array("minLength","3"),
					'message'	=> __d('validation',"First name too sort")
				),
				'maxLength' => array(
					'rule' 		=> array("maxLength","20"),
					'message'	=> __d('validation',"First name too long")
				)
			),
			'lastname' => array(
				'maxLength' => array(
					'rule' 			=> array("maxLength","20"),
					'message'		=> __d('validation',"First name too long"),
            		'allowEmpty' 	=> true
				)
			),
			'email' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please insert email.")
				),
				'email' => array(
					'rule' => "email",
					'message' => __d('validation',"Email format is wrong")
				),
				'isUnique' => array(
					'rule' 		=>	"isUnique",
					'message' 	=>	__d('validation',"This email already exists"),
					"on"		=>	"create"
				),
				'UniqueEmailEdit' => array(
					'rule' 		=>	"UniqueEmailEdit",
					'message' 	=>	__d('validation',"This email already exists"),
					"on"		=>	"update"
				)
			),
			'password' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please enter password")
				),
				'minLength' => array(
					'rule' 		=> array("minLength","4"),
					'message'	=> __d('validation',"Please insert less than 4 characters")
				),
				'maxLength' => array(
					'rule' 		=> array("maxLength","20"),
					'message'	=> __d('validation',"Please insert greater or equal than 20 characters")
				),
				"NoSpcaeAndOtherCharacter"	=> array(
					'rule'		=> "NoSpcaeAndOtherCharacter",
					'message'	=> __d('validation',"Not allowed character, please insert A-Z,a-z,0-9,_ and no space")
				),
			),
			'aro_id' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Please select admin group")
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
			)
		);
	}
	
	function ValidateRegisterCustomer()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'firstname' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Mohon masukkan nama Anda")
				),
				'minLength' => array(
					'rule' 		=> array("minLength","3"),
					'message'	=> __d('validation',"Nama Anda terlalu pendek, minimal 3 huruf")
				),
				'maxLength' => array(
					'rule' 		=> array("maxLength","30"),
					'message'	=> __d('validation',"Nama Anda terlalu panjang, maksimal 30 huruf")
				)
			),
			'email' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Mohon masukkan alamat email Anda")
				),
				'email' => array(
					'rule' => "email",
					'message' => __d('validation',"Format penulisan alamat email Anda salah")
				),
				'isUnique' => array(
					'rule' 		=>	"isUnique",
					'message' 	=>	__d('validation',"Email sudah digunakan, apakah Anda lupa dengan password Anda ?, klik menu lupa password untuk mengetahui password Anda"),
					"required"	=>	"create"
				)
			),
			'password' => array(
				'notEmpty' => array(
					'rule' => "notEmpty",
					'message' => __d('validation',"Masukkan password Anda")
				),
				'minLength' => array(
					'rule' 		=> array("minLength","8"),
					'message'	=> __d('validation',"Format password salah, password minimal terdiri dari 8 karakter, harus mengandung minimal 1 huruf kecil, 1 huruf besar, 1 angka dan tidak boleh terdapat spasi")
				),
				'mustContainLowerCase' => array(
					'rule' 		=> "mustContainLowerCase",
					'message'	=> __d('validation',"Format password salah, password minimal terdiri dari 8 karakter, harus mengandung minimal 1 huruf kecil, 1 huruf besar, 1 angka dan tidak boleh terdapat spasi")
				),
				'mustContainUpperCase' => array(
					'rule' 		=> "mustContainUpperCase",
					'message'	=> __d('validation',"Format password salah, password minimal terdiri dari 8 karakter, harus mengandung minimal 1 huruf kecil, 1 huruf besar, 1 angka dan tidak boleh terdapat spasi")
				),
				'mustContainNumber' => array(
					'rule' 		=> "mustContainNumber",
					'message'	=> __d('validation',"Format password salah, password minimal terdiri dari 8 karakter, harus mengandung minimal 1 huruf kecil, 1 huruf besar, 1 angka dan tidak boleh terdapat spasi")
				),
				'noSpace' => array(
					'rule' 		=> "noSpace",
					'message'	=> __d('validation',"Format password salah, password minimal terdiri dari 8 karakter, harus mengandung minimal 1 huruf kecil, 1 huruf besar, 1 angka dan tidak boleh terdapat spasi")
				)
			)
		);
	}
	
	function ValidateEditProfile()
	{
		App::uses('CakeNumber', 'Utility');
		$this->validate 	= array(
			'id' => array(
				'notBlank' => array(
					'rule' => "IsExists",
					'message' => __d('validation',"Maaf ID Anda tidak ditemukan")
				)
			),
			'firstname' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Mohon masukkan nama Anda")
				),
				'minLength' => array(
					'rule' 		=> array("minLength","3"),
					'message'	=> __d('validation',"Nama Anda terlalu pendek, minimal 3 huruf")
				),
				'maxLength' => array(
					'rule' 		=> array("maxLength","30"),
					'message'	=> __d('validation',"Nama Anda terlalu panjang, maksimal 30 huruf")
				)
			),
			'email' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Mohon masukkan alamat email Anda")
				),
				'email' => array(
					'rule' => "email",
					'message' => __d('validation',"Format penulisan alamat email Anda salah")
				),
				'UniqueEmailEdit' => array(
					'rule' 		=>	"UniqueEmailEdit",
					'message' 	=>	__d('validation',"Email sudah digunakan, mohon gunakan email lain"),
					"required"	=>	"create"
				)
			),
			'phone' => array(
				'maxLength' => array(
					'rule' 			=>	array("maxLength",30),
					'message' 		=>	__d('validation',"No Telp terlalu panjang"),
					"allowEmpty"	=>	true
				),
				'minLength' => array(
					'rule' 			=> array("minLength",5),
					'message' 		=> __d('validation',"No Telp terlalu pendek"),
					"allowEmpty"	=>	true
				)
			)
		);
	}

    function ValidateLoginApp()
	{
		$this->validate 	= array(
			'email' => array(
				'notBlank' => array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation','Please insert your email.')
				),
				'email' => array(
					'rule' 		=> "email",
					'message' 	=> __d('validation','Your email is wrong')
				),
				'IsEmailExists' => array(
					'rule' 		=> "IsEmailExists",
					'message' 	=> __d('validation','Email is not exists')
				)
			),
			'password' => array(
				'notBlank' => array(
					'rule' 		=> "notBlank",
					'message' 	=> __d('validation','Please insert your password')
				),
				'CheckPassword' => array(
					'rule' 		=> "CheckPassword",
					'message' 	=> __d('validation','Your password is wrong')
				)
			)
		);
	}
	
	function ValidateForgotPassword()
	{
		$this->validate 	= array(
			'email' => array(
				'notBlank' => array(
					'rule' => "notBlank",
					'message' => __d('validation',"Mohon masukkan alamat email Anda")
				),
				'email' => array(
					'rule' => "email",
					'message' => __d('validation',"Format penulisan alamat email Anda salah")
				),
				'IsEmailExists' => array(
					'rule' 		=>	"IsEmailExists",
					'message' 	=>	__d('validation',"Maaf Anda belum terdaftar sebagai member kami"),
					"required"	=>	"create"
				)
			)
		);
	}
	
	function NoSpcaeAndOtherCharacter($fields = array())
	{
		foreach($fields as $key=>$value)
		{
			$regex	=	"/^[a-zA-Z0-9_]{1,}$/";
			$out	=	preg_match($regex,$value);
			return $out;
		}
		return false;
	}
	
	function mustContainLowerCase($fields = array())
	{
		foreach($fields as $key=>$value)
		{
			$regex	=	"@[a-z]@";
			$out	=	preg_match($regex,$value);
			return $out;
		}
		return false;
	}
	
	function mustContainUpperCase($fields = array())
	{
		foreach($fields as $key=>$value)
		{
			$regex	=	"@[A-Z]@";
			$out	=	preg_match($regex,$value);
			return $out;
		}
		return false;
	}
	
	function mustContainNumber($fields = array())
	{
		foreach($fields as $key=>$value)
		{
			$regex	=	"@[0-9]@";
			$out	=	preg_match($regex,$value);
			return $out;
		}
		return false;
	}
	
	function noSpace($fields = array())
	{
		foreach($fields as $key=>$value)
		{
			$regex	=	"/^\S{8,}\z/";
			$out	=	preg_match($regex,$value);
			return $out;
		}
		return false;
	}
	

	function IsNameExists()
	{
		$email		=	$this->data[$this->name]['name'];
		if(!empty($name))
		{

			$data		=	$this->find('first',array(
								'conditions'	=>	array(
									"LOWER(name)"		=>	strtolower($name),
									"status"			=>	"1"
								),
								"order"	=>	array("{$this->name}.id ASC")
							));
			return !empty($data);
		}
		return false;
	}
	
	function rand_string( $length ) {
		$chars	=	"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrs0123456789";
		$str	=	"";

		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}
	
	function GetRandomPassword() {
		$chars	=	"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrs0123456789";
		$size 	=	strlen( $chars );
		$str	=	"";
		
		for( $i = 0; $i < 5; $i++ ) {
			$str .= $chars[ rand(0,$size-1) ];
		}

		$upper	=	$this->rand_upper(1);
		$lower	=	$this->rand_lower(1);
		$number	=	$this->rand_number(1);
		
		return $str.$upper.$lower.$number;
	}
	
	function rand_upper( $length ) {
		$chars	=	"ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$str	=	"";

		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}
	
	function rand_lower( $length ) {
		$chars	=	"abcdefghijklmnopqrstuvwxyz";
		$str	=	"";

		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}
	
	function rand_number( $length ) {
		$chars	=	"0123456789";
		$str	=	"";

		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}
}
?>
