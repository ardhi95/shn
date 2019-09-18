<?php
class TemplateController extends AppController
{
	public $components	=	array("Paginator");
	var $helpers		=	array("Tree");
	var $access;
	var $settings;

	public function beforeFilter()
	{
		//parent::beforeFilter();
		$this->layout	=	"ajax";
	}

	public function CustomerMenu()
	{
		$data	=	$this->params['param'];
		//Configure::write('debug',2);
		//pr($data);
		
		/*//GET DEVICE LIST
		$this->loadModel("UserDevice");
		
		$joins			=	array(
								array(
									"table"			=>	"devices",
									"type"			=>	"LEFT",
									"alias"			=>	"Device",
									"conditions"	=>	array(
										"
											UserDevice.device_id	=	Device.id
										"
									)
								)
							);
		$customerDevice	=	$this->UserDevice->find("all",array(
								"conditions"	=>	array(
									"UserDevice.user_id"	=>	$data['admin_id']
								)
							));*/
		
		$this->set(compact(
			"data",
			"customerDevice"
		));
	}
	
	public function CmsMenu()
	{
		$this->loadModel("CmsMenu");
        $this->CmsMenu->locale =  $this->Session->read('Config.language');

		$this->CmsMenu->BindDefault(false);
		$this->access	=	$this->__GetAccess();

		//DEFINE CMS MENU
		$conditions			=	array(
									"CmsMenu.status"		=>	1,
									"CmsMenu.parent_id IS NOT NULL"
								);

		//FILTER CMS MENU BY ACOS
		$listAcoId			=	array();
		foreach($this->access as $aco_id=>$access)
		{
			if($access["_read"]=="1")
				$listAcoId[]	=	$aco_id;
		}

		
		$conditions["OR"]	=	array(
									"CmsMenu.aco_id"				=>	$listAcoId,
									"CmsMenu.is_group_separator"	=>	1
								);


		$menu				=	$this->CmsMenu->find("all",array(
									'conditions'	=>	$conditions,
									'order' 		=> 'CmsMenu.lft ASC'
								 ));
		

		$idFinalResult		=	array();
		foreach($menu as $k	=>	$menuData)
		{
			$add	=	true;
			/*if($menuData["CmsMenu"]["is_group_separator"] == "1")
			{
				if(!isset($menu[$k+1]["CmsMenu"]) or $menu[$k+1]["CmsMenu"]["is_group_separator"]=="1")
				{
					$add	=	false;
				}
			}
			*/
			if($add)
			{
				$idFinalResult[]	=	$menuData["CmsMenu"]["id"];
			}
		}
		$menu	=	$this->CmsMenu->find("all",array(
						'conditions'	=>	array(
							"CmsMenu.id"	=>	$idFinalResult
						),
						'order' 		=> 'CmsMenu.lft ASC'
					 ));
		$this->set(compact("menu"));
		$this->set("param",$this->params['param']);
	}

	public function MainHeader()
	{
		$this->set("settings",$this->__GetSettings());
		$this->set("param",$this->params['param']);
	}
	
	public function GoogleCallBack()
	{
		$this->autoLayout	=	false;
		$this->autoRender	=	false;
		$results			=	array();
		
		include_once APP . 'Vendor'.DS.'Google'.DS.'examples'.DS.'templates' .DS. 'base.php';
		require APP . 'Vendor'.DS.'Google'.DS. 'src' .DS.'Google'.DS.'autoload.php';
		
		$client_id		=	$this->settings['google_client_id'];
		$client_secret 	=	$this->settings['google_client_secret'];
		$redirect_uri 	=	$this->settings['cms_url']."Template/GoogleCallBack";
		
		$client = new Google_Client();
		$client->setApplicationName($this->settings['cms_app_name']);
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		$client->setScopes(array('https://www.googleapis.com/auth/plus.login','https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.me', 'https://www.googleapis.com/auth/userinfo.profile'));
		
		if(isset($_GET['code']))
		{
			$client->authenticate($_GET['code']);
			$access_token = $client->getAccessToken();
			//$this->Session->write('google_access_token', $access_token);
			
			$client->setAccessToken($access_token);
			$plus 							=	new Google_Service_Oauth2($client);
			$user_profile					=	$plus->userinfo->get();
			
			$results['app_id']				=	$user_profile->id;
			$results['app_name']			=	"google";
			$results['email']				=	$user_profile->email;
			$results['gender']				=	$user_profile->gender;
			$results['fullname']			=	$user_profile->name;
			
			$splitName						=	explode(" ",$results['fullname']);
			$results['first_name']			=	$splitName[0];
			array_shift($splitName);
			$results['last_name']			=	implode(" ",$splitName);
			$results['avatar']				=	$user_profile->picture;
		
			$params	=	"";
			foreach($results as $k => $v)
			{
				$params	.=	"&" . $k . "=". urlencode($v);
			}
			
			var_dump($params);
			//$this->redirect(array('action' => 'GoogleSuccess',"?"=>"debug=1".$params));
		}
		
		if(isset($_GET['error']))
		{
			$this->redirect(array('action' => 'GoogleDenied'));
		}
	}
	
	public function GoogleDenied()
	{
		$this->autoLayout	=	false;
		$this->autoRender	=	false;
	}
	
	public function GoogleSuccess()
	{
		$this->autoLayout	=	false;
		$this->autoRender	=	false;
	}
}