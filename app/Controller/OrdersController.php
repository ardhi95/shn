<?php
App::uses('CakeNumber', 'Utility');
App::uses('Validation', 'Utility');

class OrdersController extends AppController
{
	var $ControllerName		=	"Orders";
	var $ModelName 			=	"Order";
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


		//DEFINE SALES
		$this->loadModel("User");
		$this->User->VirtualFieldActivated();
		
		$sales_id_list	=	$this->User->find("list",array(
								"conditions"	=>	array(
									"User.status"	=>	"1",
									"User.aro_id"	=>	"4"
								),
								"fields"		=>	array(
									"id",
									"fullname"
								),
								"order"			=>	"User.fullname asc"
							));
							
		//DEFINE STORES
		$this->loadModel("Store");
		$store_id_list	=	$this->Store->find("list",array(
								"conditions"	=>	array(
									"Store.status"	=>	"1"
								),
								"fields"		=>	array(
									"id",
									"name"
								),
								"order"			=>	"Store.name asc"
							));
							
		$this->set(compact(
			"page",
			"viewpage",
			"sales_id_list",
			"store_id_list"
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
		$this->{$this->ModelName}->bindModel(array(
			"belongsTo"	=>	array(
				"OrderStatus",
				"Schedule"
			)
		),false);
		
		$this->{$this->ModelName}->Schedule->bindModel(array(
			"belongsTo"	=>	array(
				"Store",
				"Sales"	=>	array(
					"foreignKey"	=>	"sales_id",
					"className"		=>	"User"
				)
			)
		),false);
		
		$this->{$this->ModelName}->Schedule->Sales->virtualFields = array(
			"fullname"		=> "CONCAT(Sales.firstname,' ',Sales.lastname)",
		);

		//DEFINE LAYOUT, LIMIT AND OPERAND
		$operand  	=	"AND";
		if($excel == "true")
		{
			$order		=	$this->Session->read("Search.".$this->ControllerName."Sort");
			$viewpage	=	$this->Session->read("Search.".$this->ControllerName."Viewpage");
		}
		else
		{
			$viewpage	=	empty($this->params['named']['limit']) ? 10 : $this->params['named']['limit'];
			$order    	= 	array(
							   "{$this->ModelName}.modified" => "desc"
							);
			$this->Session->write('Search.' . $this->ControllerName . 'Viewpage', $viewpage);
			$this->Session->write('Search.' . $this->ControllerName . 'Sort', (empty($this->params['named']['sort']) or !isset($this->params['named']['sort'])) ? $order : $this->params['named']['sort'] . " " . $this->params['named']['direction']);
		}

		//DEFINE SEARCH DATA
		if (!empty($this->request->data)) {
			$cond_search = array();
			$operand     = $this->request->data[$this->ModelName]['operator'];
			$this->Session->delete('Search.' . $this->ControllerName);

			if (!empty($this->request->data['Search']['order_id'])) {
				   $cond_search["Order.id"] = $this->data['Search']['order_id'];
			}
			
			if (!empty($this->request->data['Search']['sales_id'])) {
				   $cond_search["Schedule.sales_id"] = $this->data['Search']['sales_id'];
			}

			if (!empty($this->request->data['Search']['store_id'])) {
				   $cond_search["Schedule.store_id"] = $this->data['Search']['store_id'];
			}
			

			if (!empty($this->data['Search']['start_date']) && empty($this->data['Search']['end_date'])) {
				   $cond_search["{$this->ModelName}.modified >= "] = date("Y-m-d H:i:s",strtotime($this->data['Search']['start_date'] . " 00:00:00"));
			}

			if (empty($this->data['Search']['start_date']) && !empty($this->data['Search']['end_date'])) {
				   $cond_search["{$this->ModelName}.modified <= "] = date("Y-m-d H:i:s",strtotime($this->data['Search']['end_date'] . " 23:59:59"));
			}

			if (!empty($this->data['Search']['start_date']) && !empty($this->data['Search']['end_date'])) {
				   $tmp		= $this->data['Search']['start_date'];
				   $START 	= (strtotime($this->data['Search']['start_date']) < strtotime($this->data['Search']['start_date'])) ? $this->data['Search']['end_date'] : $this->data['Search']['start_date'];
				   
				   $END		= ($this->data['Search']['end_date'] < $tmp) ? $tmp : $this->data['Search']['end_date'];
				   $cond_search["{$this->ModelName}.modified BETWEEN ? AND ? "] = array(
						   date("Y-m-d H:i:s",strtotime($START . " 00:00:00")),
						   date("Y-m-d H:i:s",strtotime($END . " 23:59:59"))
				   );
			}

			if ($this->request->data["Search"]['reset'] == "0") {
				   $this->Session->write("Search." . $this->ControllerName, $cond_search);
				   $this->Session->write('Search.' . $this->ControllerName . 'Operand', $operand);
			}
		}

		$cond_search     	=	array();
		$filter_paginate 	=	array();

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
										   "recursive"		=>	3,
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
		
		//var_dump($merge_cond);
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
	
	function Detail($ID = NULL, $page = 1, $viewpage = 50)
	{
		if ($this->access[$this->aco_id]["_update"] != "1")
		{
			$this->render("/Errors/no_access");
			return;
		}

		$this->loadModel($this->ModelName);
		$this->{$this->ModelName}->bindModel(array(
			"hasMany"	=>	array(
				"OrderList"
			),
			"belongsTo"	=>	array(
				"Schedule",
				"OrderStatus"
			)
		));
		
		$this->{$this->ModelName}->Schedule->bindModel(array(
			"belongsTo"	=>	array(
				"Store",
				"Sales"	=>	array(
					"foreignKey"	=>	"sales_id",
					"className"		=>	"User"
				)
			)
		),false);
		
		$this->{$this->ModelName}->Schedule->Sales->virtualFields = array(
			"fullname"		=> "CONCAT(Sales.firstname,' ',Sales.lastname)",
		);
		
		$this->{$this->ModelName}->OrderList->bindModel(array(
			"belongsTo"	=>	array(
				"Product"
			)
		));
		
		$detail		=	$this->{$this->ModelName}->find('first', array(
							'conditions' => array(
								"{$this->ModelName}.id" => $ID
							),
							"recursive"	=>	2
						));
		
		pr($detail);
		if(empty($detail))
		{
		   $this->render("/Errors/error404");
		   return;
		}
		
		$errMessage	=	array();
		if(!empty($this->request->data))
		{
			
			$this->{$this->ModelName}->set($this->request->data);
			$this->{$this->ModelName}->ValidateUpdateStatus();
			$error	=	$this->{$this->ModelName}->invalidFields();
			
			if(empty($error))
			{
				$this->loadModel("OrderLog");
				$this->loadModel("OrderLogList");
				
				$beforeStatus	=	$detail["Order"]["order_status_id"];
				$updateStatus	=	$this->request->data[$this->ModelName]["update_status_id"];
				$orderId		=	$ID;
				$creatorId		=	$this->login_id;
				
				//UPDATE ORDER
				$arrayUpdate	=	array("order_status_id"	=>	$updateStatus);
				if(!empty($this->request->data[$this->ModelName]["notes"]))
				{
					$arrayUpdate["notes"]	=	"'".$this->request->data[$this->ModelName]["notes"]."'";
				}
				
				if($updateStatus == "4")
				{
					if(!empty($this->request->data[$this->ModelName]["delivery_date"]))
					{
						$arrayUpdate["delivery_date"]	=	"'".date("Y-m-d H:i:s",strtotime($this->request->data[$this->ModelName]["delivery_date"]))."'";
					}
				}
				
				$this->Order->updateAll(
					$arrayUpdate,
					array(
						"Order.id"			=>	$orderId
					)
				);
				
				//SAVE ORDER LOG
				$arrayUpdateLog	=	array(
										"order_id"				=>	$orderId,
										"creator_id"			=>	$creatorId,
										"aro_id"				=>	$this->profile["User"]["aro_id"],
										"order_log_type_id"		=>	$updateStatus
									);
				if(!empty($this->request->data[$this->ModelName]["notes"]))
				{
					$arrayUpdateLog["notes"]	=	"'".$this->request->data[$this->ModelName]["notes"]."'";
				}
				
				$this->OrderLog->create();
				$this->OrderLog->saveAll(
					$arrayUpdateLog,
					array(
						"validate"				=>	false
					)
				);
				$orderLogId		=	$this->OrderLog->getLastInsertId();
				
				//SAVE ORDER LIST
				foreach($detail["OrderList"] as $OrderList)
				{
					$this->OrderLogList->create();
					$this->OrderLogList->saveAll(
						array(
							"order_log_id"				=>	$orderLogId,
							"product_id"				=>	$OrderList["Product"]["id"],
							"qty"						=>	$OrderList["qty"]
						),
						array(
							"validate"	=>	false
						)
					);
				}
				
				$this->Session->setFlash(
					'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><p>Congratulation data successfully updated!</p>',
					'default',
					array(
						'class' => 'alert alert-success',
					)
				);
				
				$this->redirect(array("action"=>"Detail",$ID,$page,$viewpage));
				
			}
			//END IF VALIDATE
			else
			{
				foreach($error as $k => $message)
				{
					$errMessage[]	= reset($message)."<br/>";
					$this->Session->setFlash(
						'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><p>'.reset($message).'</p>',
						'default',
						array(
							'class' => 'alert alert-danger',
						)
					);
					break;
				}
			}
		}
		
		//HISTORY ORDER
		$this->loadModel("OrderLog");
		$this->OrderLog->bindModel(array(
			"hasMany"	=>	array(
				"OrderLogList"
			),
			"belongsTo"	=>	array(
				"OrderLogType",
				"MyAro"	=>	array(
					"foreignKey"	=>	"aro_id"
				)
			)
		),false);
		
		
		
		$this->OrderLog->OrderLogList->bindModel(array(
			"belongsTo"	=>	array(
				"Product"
			)
		));
		$orderLog			=	$this->OrderLog->find("all",array(
									"conditions"	=>	array(
										"OrderLog.order_id"	=>	$ID
									),
									"order"			=>	"OrderLog.order_id asc",
									"recursive"		=>	3
								));
		//pr($orderLog);
		//DEFINE ORDER LIST
		$this->loadModel("OrderStatus");
		$order_status_id_list	=	$this->OrderStatus->find("list",array(
										"order"			=>	"OrderStatus.name asc",
										"conditions"	=>	array(
											"NOT" =>	array(
												"OrderStatus.id"	=>	array("1")
											)
										)
									));
		
		
		$this->set(compact(
			"detail",
			"ID",
			"page",
			"viewpage",
			"orderLog",
			"order_status_id_list",
			"errMessage"
		));
	}
}
