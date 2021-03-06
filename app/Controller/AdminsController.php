<?php

App::uses('CakeNumber', 'Utility');
App::uses('Validation', 'Utility');

class AdminsController extends AppController
{
	var $ControllerName		=	"Admins";
	var $ModelName 			=	"User";
	var $helpers 			=	array("Text","General");
	var $aco_id;

	function beforeFilter()
	{
		parent::beforeFilter();
		$this->set("ControllerName", $this->ControllerName);
		$this->set("ModelName", $this->ModelName);

		//CHECK PRIVILEGES
		$this->loadModel("MyAco");
		$find         =		$this->MyAco->find("first", array(
								 "conditions" => array(
										 "LOWER(MyAco.controller)" => $this->ControllerName
								 )
							));

		$this->aco_id = $find["MyAco"]["id"];
		$this->set("aco_id", $this->aco_id);
	}

	function Index($page = 1, $viewpage = 50)
	{
		if ($this->access[$this->aco_id]["_read"] != "1"){
			$this->render("/Errors/no_access");
			return;
		}

		$this->Session->delete("Search." . $this->ControllerName);
		$this->Session->delete('Search.' . $this->ControllerName . 'Operand');
		$this->Session->delete('Search.' . $this->ControllerName . 'ViewPage');
		$this->Session->delete('Search.' . $this->ControllerName . 'Sort');
		$this->Session->delete('Search.' . $this->ControllerName . 'Page');
		$this->Session->delete('Search.' . $this->ControllerName . 'Conditions');


		$this->set(compact(
			"page",
			"viewpage"
		));
	}

	function CropImage($ID)
	{
		$this->autoRender	=	false;
		$this->autoLayout	=	false;

		if($_POST['cp_img_path']){

			$info	=	pathinfo($_POST['cp_img_path']);
			$path	=	$this->settings['path_content']."upload/".$info['basename'];
			$ext	=	strtolower(pathinfo($path,PATHINFO_EXTENSION));

			App::import('Vendor','imageResizing' ,array('file'=>'image_resizing.php'));
			$imgr = new imageResizing();
			$imgr->load($path);

			$path_content	=	$this->settings['path_content'];
				if(!is_dir($path_content)) mkdir($path_content,0777);

			$path_model		=	$path_content. $this->ModelName . "/";
				if(!is_dir($path_model)) mkdir($path_model,0777);

			$path_model_id	=	$path_model . $ID . "/";
				if(!is_dir($path_model_id)) mkdir($path_model_id,0777);

			$path_content	=	$path_model_id.$ID."_square.".$ext;

			$imgX = intval($_POST['ic_x']);
			$imgY = intval($_POST['ic_y']);
			$imgW = intval($_POST['ic_w']);
			$imgH = intval($_POST['ic_h']);

			$imgr->resize($imgW,$imgH,$imgX,$imgY);
			$imgr->save($path_content);

			$Content	=	ClassRegistry::Init("Content");
			$data		=	$Content->find("first",array(
								"conditions"	=>	array(
									"Content.model_id"		=>	$ID,
									"Content.model"			=>	$this->ModelName,
									"LOWER(Content.type)"	=>	strtolower("square"),
								)
							));

			$mime_type	=	"";
			if($ext == "jpg" || $ext == "jpeg")
			{
				$mime_type	=	"image/jpg";
			}
			else if($ext == "gif")
			{
				$mime_type	=	"image/gif";
			}
			else if($ext == "png")
			{
				$mime_type	=	"image/png";
			}

			if(!empty($data))
			$Contents["Content"]["id"]				=	$data["Content"]["id"];
			$Contents["Content"]["model"]			=	$this->ModelName;
			$Contents["Content"]["model_id"]		=	$ID;
			$Contents["Content"]["host"]			=	$this->settings["cms_url"];
			$Contents["Content"]["mime_type"]		=	$mime_type;
			$Contents["Content"]["type"]			=	"square";
			$Contents["Content"]["url"]				=	"contents/{$this->ModelName}/{$ID}/{$ID}_square.{$ext}";
			$Contents["Content"]["path"]			=	$path_content;

			$size									=	getimagesize($path_content);
			$Contents["Content"]["width"]			=	$size[0];
			$Contents["Content"]["height"]			=	$size[1];
			$Content->create();
			$Content->save($Contents,array("validate"=>false));


			list($width, $height)					=	getimagesize($path);
			$width									=	$width > 800 ? 800 : $width;
			$resize									=	$this->General->ResizeImageContent(
															$path,
															$this->settings["cms_url"],
															$ID,
															$this->ModelName,
															"maxwidth",
															$mime_type,
															$width,
															$width,
															"resizeMaxWidth"
														);
			@unlink($path);
			echo '<img src="'.$this->settings["cms_url"].$Contents["Content"]["url"].'?t='.time().'" class="img-thumbnail"/>';

			if($ID == $this->login_id)
			{
				echo '<script>$("#avatar-left-mini").attr("src","'.$this->settings["cms_url"].$Contents["Content"]["url"].'?t='.time().'");$("#avatar-left-big").attr("src","'.$this->settings["cms_url"].$Contents["Content"]["url"].'?t='.time().'");</script>';
			}
		}
	}

	function UploadProfileImage($ID)
	{
		$this->autoRender	=	false;
		$this->autoLayout	=	false;

		$this->loadModel("User");

		if(!empty($this->request->data))
		{
			$this->User->set($this->request->data);
			$this->User->ValidateUploadImage();
			$error	=	$this->User->invalidFields();
			if(empty($error))
			{
				$file			=	$this->request->data[$this->ModelName]['images'];
				$tempFile 		=	$file['tmp_name'];

				$path_content	=	$this->settings['path_content'];
					if(!is_dir($path_content))mkdir($path_content,0777);

				$path_tmp							=	$path_content.'/upload/';
					if(!is_dir($path_tmp)) mkdir($path_tmp,0777);

				$fileName 		=	time().'_'.$file['name'];
				$targetFile		=	$path_tmp	. $fileName;

				if(move_uploaded_file($tempFile,$targetFile))
				{
            		echo '<div class="cropping-image-wrap"><img src="'.$this->settings['cms_url']."contents/upload/".$fileName.'" class="img-thumbnail" id="crop_image"/></div>';
        		}

			}
			else
			{
				foreach($error as $k => $v)
				{
					echo '<div class="alert alert-danger">'.$v[0].'</div>';
					break;
				}
			}
		}
	}

	function ListItem($excel = "false")
	{
		$this->layout		=	"ajax";
		$fullScreenMode		=	$this->params['named']['fullScreenMode'];

		if ($this->access[$this->aco_id]["_read"] != "1") {
			   $data = array();
			   $this->set(compact("data"));
			   return;
		}

		$this->loadModel($this->ModelName);
		$this->{$this->ModelName}->BindDefault(false);
		$this->{$this->ModelName}->BindImageContent(false);
		$this->{$this->ModelName}->VirtualFieldActivated();

		//DEFINE LAYOUT, LIMIT AND OPERAND
		$operand  	=	"AND";
		if($excel == "true")
		{
			$order		=	$this->Session->read("Search.".$this->ControllerName."Sort");
			$viewpage	=	$this->Session->read("Search.".$this->ControllerName."Viewpage");
		}
		else
		{
			$viewpage	=	empty($this->params['named']['limit']) ? 50 : $this->params['named']['limit'];
			$order    	= 	array(
							   "{$this->ModelName}.id" => "DESC"
							);
			$this->Session->write('Search.' . $this->ControllerName . 'Viewpage', $viewpage);
			$this->Session->write('Search.' . $this->ControllerName . 'Sort', (empty($this->params['named']['sort']) or !isset($this->params['named']['sort'])) ? $order : $this->params['named']['sort'] . " " . $this->params['named']['direction']);
		}

		//DEFINE SEARCH DATA
		if (!empty($this->request->data)) {
			$cond_search = array();
			$operand     = $this->request->data[$this->ModelName]['operator'];
			$this->Session->delete('Search.' . $this->ControllerName);

			if (!empty($this->request->data['Search']['firstname'])) {
				   $cond_search["{$this->ModelName}.firstname LIKE "] = "%".$this->data['Search']['firstname']."%";
			}

			if (!empty($this->request->data['Search']['lastname'])) {
				   $cond_search["{$this->ModelName}.lastname LIKE "] = "%".$this->data['Search']['lastname']."%";
			}

			if (!empty($this->request->data['Search']['email'])) {
				   $cond_search["{$this->ModelName}.email LIKE "] = "%".$this->data['Search']['email']."%";
			}

			if (!empty($this->data['Search']['start_date']) && empty($this->data['Search']['end_date'])) {
				   $cond_search["{$this->ModelName}.created >= "] = $this->data['Search']['start_date'] . " 00:00:00";
			}

			if (empty($this->data['Search']['start_date']) && !empty($this->data['Search']['end_date'])) {
				   $cond_search["{$this->ModelName}.created <= "] = $this->data['Search']['end_date'] . " 23:59:59";
			}

			if (!empty($this->data['Search']['start_date']) && !empty($this->data['Search']['end_date'])) {
				   $tmp                                                            = $this->data['Search']['start_date'];
				   $START                                                          = (strtotime($this->data['Search']['end_date']) < strtotime($this->data['Search']['start_date'])) ? $this->data['Search']['end_date'] : $this->data['Search']['start_date'];
				   $END                                                            = ($this->data['Search']['end_date'] < $tmp) ? $tmp : $this->data['Search']['end_date'];
				   $cond_search["{$this->ModelName}.created BETWEEN ? AND ? "] = array(
						   $START . " 00:00:00",
						   $END . " 23:59:59"
				   );
			}

			if ($this->request->data["Search"]['reset'] == "0") {
				   $this->Session->write("Search." . $this->ControllerName, $cond_search);
				   $this->Session->write('Search.' . $this->ControllerName . 'Operand', $operand);
			}
		}

		$cond_search     	=	array();
		$filter_paginate 	=	array(
			"NOT"	=>	array(
				"{$this->ModelName}.aro_id"	=>	"4"
			)
		);

		//DEFINE ARO LIST
		$this->loadModel("MyAro");
		$superAdminAro				=	$this->MyAro->find("first",array(
											"conditions"	=>	array(
												"MyAro.parent_id"	=>	NULL
											)
										));

		$premiumAdminAro			=	$this->MyAro->find("first",array(
											"conditions"	=>	array(
												"MyAro.parent_id"	=>	$superAdminAro["MyAro"]["id"]
											)
										));

		if($this->profile["MyAro"]["id"] == $superAdminAro["MyAro"]["id"])
		{
			//var_dump("A");
			$filter_paginate	=	array(
										"{$this->ModelName}.is_admin"	=>	"1",
										"NOT"	=>	array(
											"{$this->ModelName}.aro_id"	=>	"4"
										)
									);
		}
		else if($this->profile["MyAro"]["id"] == $premiumAdminAro["MyAro"]["id"])
		{
			//var_dump("B");
			$filter_paginate	=	array(
										"{$this->ModelName}.is_admin"	=>	"1",
										"OR"	=>	array(
											"{$this->ModelName}.aro_id"	=>	NULL,
											"NOT"	=>	array(
												"{$this->ModelName}.aro_id"	=> array(
													$superAdminAro["MyAro"]["id"],
													"4"
												)
											)
										),
									);

		}
		else
		{
			//var_dump("C");
			$filter_paginate	=	array(
										"NOT"	=>	array(
											"{$this->ModelName}.aro_id"	=> array(
												$superAdminAro["MyAro"]["id"],
												$premiumAdminAro["MyAro"]["id"],
												"4"
											)
										),
										"{$this->ModelName}.is_admin"	=>	"1"
									);
		}


		//DEFINE CURRENT PAGE
		if (
			isset($this->params['named']['page']) &&
			$this->params['named']['page'] >
			$this->params['paging'][$this->ModelName]['pageCount']
		)
		{
			   $this->params['named']['page'] = $this->params['paging'][$this->ModelName]['pageCount'];
		}

		if($excel == "true")
		{
			$page			=	$this->Session->read("Search.".$this->ControllerName."Page");
		}
		else
		{
			$page 	= empty($this->params['named']['page']) ? 1 : $this->params['named']['page'];
			$this->Session->write('Search.' . $this->ControllerName . 'Page', $page);
		}

		$this->paginate  	=	array(
									"{$this->ModelName}" => array(
										   "order" 			=>	$order,
										   'limit' 			=>	$viewpage,
										   "recursive"		=>	2,
										   "page"			=>	$page,
                                           "maxLimit"       =>  1000
									)
								);

		$ses_cond    		=	$this->Session->read("Search." . $this->ControllerName);
		$cond_search 		=	isset($ses_cond) ? $ses_cond : array();
		$ses_operand 		=	$this->Session->read("Search." . $this->ControllerName . "Operand");
		$operand     		=	isset($ses_operand) ? $ses_operand : "AND";
		$merge_cond  		=	empty($cond_search) ? $filter_paginate : array_merge($filter_paginate, array(
			   $operand => $cond_search
		));

		$data				=	array();

		try {
			$data        		= $this->paginate("{$this->ModelName}", $merge_cond);
		}
		catch (NotFoundException $e) {
			$count 				= $this->{$this->ModelName}->find('count',array("conditions"=>$merge_cond));
			$pageCount 			= intval(ceil($count / $viewpage));
			$this->request->params['named']['page'] = $pageCount;
			$this->Session->write('Search.' . $this->ControllerName . 'Page', $pageCount);
			$this->{$this->ModelName}->BindDefault(false);
			$data        		= $this->paginate("{$this->ModelName}", $merge_cond);
    	}
		$this->Session->write('Search.' . $this->ControllerName . 'Conditions', $merge_cond);
		
		$this->set(compact(
			'data',
			'page',
			'viewpage',
			'fullScreenMode'
		));

		$filename		=	$this->ControllerName."-".date("dMY").".xlsx";
		if($excel == "true") {
			$this->set('filename',$filename);
			$this->render('excel');
		} else {
			$this->render('list_item');
		}
	}

	function Excel()
	{
		if($this->access[$this->aco_id]["_read"] != "1")
		{
			$this->render("/Errors/no_access");
			return;
		}

		$this->layout		=	"ajax";
		$this->{$this->ModelName}->BindDefault(false);
		 $this->{$this->ModelName}->VirtualFieldActivated();

		$order			=	$this->Session->read("Search.".$this->ControllerName."Sort");
		$viewpage		=	$this->Session->read("Search.".$this->ControllerName."Viewpage");
		$page			=	$this->Session->read("Search.".$this->ControllerName."Page");
		$conditions		=	$this->Session->read("Search.".$this->ControllerName."Conditions");

		$this->paginate		=	array(
									"{$this->ModelName}"	=>	array(
										"order"				=>	$order,
										"limit"				=>	$viewpage,
										"conditions"		=>	$conditions,
										"page"				=>	$page
									)
								);

		$data			=	$this->paginate("{$this->ModelName}",$conditions);
		$title			=	$this->ModelName;
		$filename		=	$this->ControllerName."-".date("dMY").".xlsx";
		$this->set(compact("data","title","page","viewpage","filename"));
	}

	function Add()
	{
		if($this->access[$this->aco_id]["_create"] != "1")
		{
			$this->render("/Errors/no_access");
			return;
		}

		if(!empty($this->request->data))
		{
			$this->{$this->ModelName}->set($this->request->data);

			$this->request->data[$this->ModelName]['is_admin']	=	"1";
			$this->{$this->ModelName}->ValidateData();
			if($this->{$this->ModelName}->validates())
			{
				$save	=	$this->{$this->ModelName}->save($this->request->data,array("validate"=>false));
				$ID		=	$this->{$this->ModelName}->getLastInsertId();

				$this->Session->setFlash(
					'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><p>Congratulation data successfully saved!</p>',
					'default',
					array(
						'class' => 'alert alert-success',
					)
				);

				if($this->request->data[$this->ModelName]['save_flag'] == "1")
					$this->redirect(array("action"=>"Index"));
				else
					$this->redirect(array("action"=>"Add"));
			}//END IF VALIDATE
		}//END IF NOT EMPTY

		//DEFINE ARO LIST
		$this->loadModel("MyAro");
		$superAdminAro				=	$this->MyAro->find("first",array(
											"conditions"	=>	array(
												"MyAro.parent_id"	=>	NULL
											)
										));

		$premiumAdminAro			=	$this->MyAro->find("first",array(
											"conditions"	=>	array(
												"MyAro.parent_id"	=>	$superAdminAro["MyAro"]["id"]
											)
										));

		$disabledParent				=	array($superAdminAro["MyAro"]["id"]);


		$checkUser					=	"";
		if(!empty($premiumAdminAro))
		{
			$checkUser				=	$this->{$this->ModelName}->find("first",array(
											"conditions"	=>	array(
												"{$this->ModelName}.aro_id"	=>	$premiumAdminAro["MyAro"]["id"]
											)
										));
			if(!empty($checkUser))
			{
				$disabledParent[]	=	$premiumAdminAro["MyAro"]["id"];
			}
		}

		$condTree					=	array();

		if($this->profile["MyAro"]["id"] == $premiumAdminAro["MyAro"]["id"])
		{
			$condTree				=	array(
											"MyAro.lft > "	=>	$premiumAdminAro["MyAro"]["lft"],
											"MyAro.rght < "	=>	$premiumAdminAro["MyAro"]["rght"]
										);
		}

		$aro_id_list				=	$this->MyAro->generateTreeList($condTree,"{n}.MyAro.id","{n}.MyAro.alias","");
	  	$this->set(compact(
			"aro_id_list",
			"disabledParent"
		));
	}

	function EditProfile($ID = NULL, $page = 1, $viewpage = 50)
	{
		if ($this->access[$this->aco_id]["_read"] != "1"){
			$this->render("/Errors/no_access");
			return;
		}

		$this->{$this->ModelName}->BindDefault(false);
		$this->{$this->ModelName}->BindImageContent(false);
		$detail		=	$this->{$this->ModelName}->find('first', array(
							'conditions' => array(
								"{$this->ModelName}.id" 		=> $ID,
								"{$this->ModelName}.is_admin" 	=> "1"
							),
							"recursive"	=>	3
						));


		if (empty($detail))
		{
		   $this->render("/Errors/error404");
		   return;
		}

		if (empty($this->data))
		{
			$detail[$this->ModelName]["password"]	=	$this->General->my_decrypt($detail[$this->ModelName]["password"]);
			$this->data = $detail;
		}
		else
		{
			$this->{$this->ModelName}->set($this->data);
			$this->{$this->ModelName}->ValidateData();
			if($this->{$this->ModelName}->validates())
			{
				if($this->request->data[$this->ModelName]["status"] == "0")
				{
					$this->request->data[$this->ModelName]["aro_id"]	=	NULL;
				}

				$save	=	$this->{$this->ModelName}->save($this->request->data,array("validate"=>false));
				$this->Session->setFlash(
					'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><p>Congratulation data successfully updated!</p>',
					'default',
					array(
						'class' => 'alert alert-success',
					)
				);

				if($this->request->data[$this->ModelName]['save_flag'] == "1")
					$this->redirect(array("action"=>"Index"));
				else
					$this->redirect(array("action"=>"EditProfile",$ID,$page,$viewpage));

			}//END IF VALIDATE
		}


		//DEFINE ARO LIST
		$this->loadModel("MyAro");
		$superAdminAro				=	$this->MyAro->find("first",array(
											"conditions"	=>	array(
												"MyAro.parent_id"	=>	NULL
											)
										));

		$premiumAdminAro			=	$this->MyAro->find("first",array(
											"conditions"	=>	array(
												"MyAro.parent_id"	=>	$superAdminAro["MyAro"]["id"]
											)
										));

		$disabledParent				=	array($superAdminAro["MyAro"]["id"]);


		$checkUser					=	"";
		if(!empty($premiumAdminAro))
		{
			$checkUser				=	$this->{$this->ModelName}->find("first",array(
											"conditions"	=>	array(
												"{$this->ModelName}.aro_id"	=>	$premiumAdminAro["MyAro"]["id"]
											)
										));
			if(!empty($checkUser))
			{
				$disabledParent[]	=	$premiumAdminAro["MyAro"]["id"];
			}
		}

		$condTree					=	array();

		if($this->profile["MyAro"]["id"] == $premiumAdminAro["MyAro"]["id"])
		{
			$condTree				=	array(
											"MyAro.lft > "	=>	$premiumAdminAro["MyAro"]["lft"],
											"MyAro.rght < "	=>	$premiumAdminAro["MyAro"]["rght"]
										);
		}

		$aro_id_list				=	$this->MyAro->generateTreeList($condTree,"{n}.MyAro.id","{n}.MyAro.alias","");

		$this->set(compact(
			"aro_id_list",
			"ID",
			"page",
			"viewpage",
			"disabledParent",
			"superAdminAro",
			"detail",
			"premiumAdminAro"
		));
	}

	function Edit($ID = NULL, $page = 1, $viewpage = 50)
	{
		if ($this->access[$this->aco_id]["_read"] != "1"){
			$this->render("/Errors/no_access");
			return;
		}

		$this->{$this->ModelName}->BindDefault(false);
		$this->{$this->ModelName}->BindImageContent(false);
		$detail		=	$this->{$this->ModelName}->find('first', array(
							'conditions' => array(
									 "{$this->ModelName}.id" 		=> $ID,
									 "{$this->ModelName}.is_admin" 	=> "1"
							),
							"recursive"	=>	3
						));


		if (empty($detail))
		{
		   $this->render("/Errors/error404");
		   return;
		}

		if (empty($this->data))
		{
			$detail[$this->ModelName]["password"]	=	$this->General->my_decrypt($detail[$this->ModelName]["password"]);
			$this->data = $detail;
		}
		else
		{
			$this->{$this->ModelName}->set($this->data);
			$this->{$this->ModelName}->ValidateData();
			if($this->{$this->ModelName}->validates())
			{
				if($this->request->data[$this->ModelName]["status"] == "0")
				{
					$this->request->data[$this->ModelName]["aro_id"]	=	NULL;
				}

				$save	=	$this->{$this->ModelName}->save($this->request->data,array("validate"=>false));
				$this->Session->setFlash(
					'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><p>Congratulation data successfully updated!</p>',
					'default',
					array(
						'class' => 'alert alert-success',
					)
				);

				if($this->request->data[$this->ModelName]['save_flag'] == "1")
					$this->redirect(array("action"=>"Index"));
				else
					$this->redirect(array("action"=>"Edit",$ID,$page,$viewpage));

			}//END IF VALIDATE
		}


		//DEFINE ARO LIST
		$this->loadModel("MyAro");
		$superAdminAro				=	$this->MyAro->find("first",array(
											"conditions"	=>	array(
												"MyAro.parent_id"	=>	NULL
											)
										));

		$premiumAdminAro			=	$this->MyAro->find("first",array(
											"conditions"	=>	array(
												"MyAro.parent_id"	=>	$superAdminAro["MyAro"]["id"]
											)
										));

		$disabledParent				=	array($superAdminAro["MyAro"]["id"]);


		$checkUser					=	"";
		if(!empty($premiumAdminAro))
		{
			$checkUser				=	$this->{$this->ModelName}->find("first",array(
											"conditions"	=>	array(
												"{$this->ModelName}.aro_id"	=>	$premiumAdminAro["MyAro"]["id"]
											)
										));
			if(!empty($checkUser))
			{
				$disabledParent[]	=	$premiumAdminAro["MyAro"]["id"];
			}
		}

		$condTree					=	array();

		if($this->profile["MyAro"]["id"] == $premiumAdminAro["MyAro"]["id"])
		{
			$condTree				=	array(
											"MyAro.lft > "	=>	$premiumAdminAro["MyAro"]["lft"],
											"MyAro.rght < "	=>	$premiumAdminAro["MyAro"]["rght"]
										);
		}

		$aro_id_list				=	$this->MyAro->generateTreeList($condTree,"{n}.MyAro.id","{n}.MyAro.alias","");

		$this->set(compact(
			"aro_id_list",
			"ID",
			"page",
			"viewpage",
			"disabledParent",
			"superAdminAro",
			"detail",
			"premiumAdminAro"
		));
		$this->render("edit_profile");
	}

	function ChangeStatus($ID = NULL, $status)
	{
		if ($this->access[$this->aco_id]["_update"] != "1") {
			echo json_encode(array(
				"data" => array(
					"status" => "0",
					"message" => __("No privileges")
				)
			));
			$this->autoRender = false;
			$this->autoLayout = false;
			return;
		}

		$detail = $this->{$this->ModelName}->find('first', array(
			'conditions' => array(
				"{$this->ModelName}.id" => $ID
			)
		));

		$resultStatus = "0";
		if (empty($detail)){
			$message = __("Item not found.");
		} else {
			$data[$this->ModelName]["id"]     	=	$ID;
			$data[$this->ModelName]["status"] 	=	$status;

			if($status == "0")
				$data[$this->ModelName]["aro_id"] 	=	NULL;

			$this->{$this->ModelName}->save($data);
			$message      						=	__("Data has updated.");
			$resultStatus 						=	"1";
		}

		echo json_encode(array(
			"data" => array(
				"status"	=>	$resultStatus,
				"message"	=>	$message
			)
		));
		$this->autoRender = false;
	}

	function ChangeStatusMultiple()
	{
		if ($this->access[$this->aco_id]["_update"] != "1") {
			echo json_encode(array(
				"data" => array(
					"status" => "0",
					"message" => __("No privileges")
				)
			));
			$this->autoRender = false;
			$this->autoLayout = false;
			return;
		}

		$ID     		=	explode(",", $_REQUEST["id"]);
		$status 		=	$_REQUEST["status"];
		$arrUpdate		=	array(
								"status" => "'" . $status . "'"
							);
		if( $status == "0")
		{
			$arrUpdate["aro_id"]	=	NULL;
		}

		$this->{$this->ModelName}->updateAll($arrUpdate, array(
			"{$this->ModelName}.id" => $ID
		));

		$message = __("Data has updated.");
		echo json_encode(array(
			"data" => array(
				"status" => "1",
				"message" => $message
			)
		));
		$this->autoRender = false;
	}

	function Delete($ID = NULL)
	{
		if ($this->access[$this->aco_id]["_delete"] != "1") {
			   echo json_encode(array(
					   "data" => array(
							   "status" => "0",
							   "message" => __("No privileges")
					   )
			   ));
			   $this->autoRender = false;
			   $this->autoLayout = false;
			   return;
		}

		$detail       = $this->{$this->ModelName}->find('first', array(
			   'conditions' => array(
					   "{$this->ModelName}.id" => $ID
			   )
		));
		$resultStatus = "0";

		if (empty($detail)) {
			   $message      = __("Item not found.");
			   $resultStatus = "0";
		} else {
			   $this->{$this->ModelName}->delete($ID, false);
			   $message      = __("Data has deleted.");
			   $resultStatus = "1";
		}

		echo json_encode(array(
			   "data" => array(
					   "status" => $resultStatus,
					   "message" => $message
			   )
		));
		$this->autoRender = false;
	}

	function DeleteMultiple()
	{
		if ($this->access[$this->aco_id]["_delete"] != "1") {
			echo json_encode(array(
				   "data" => array(
						   "status" => "0",
						   "message" => __("No privileges")
				   )
			));
			$this->autoRender	=	false;
			$this->autoLayout	=	false;
			return;
		}

		$id = explode(",", $_REQUEST["id"]);
		$this->{$this->ModelName}->deleteAll(array(
			   "id" => $id
		), false, true);
		$message = __("Data has deleted.");

		echo json_encode(array(
			   "data" => array(
					   "status" => "1",
					   "message" => $message
			   )
		));
		$this->autoRender = false;
	}
}
