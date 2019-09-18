<?php

App::uses('CakeNumber', 'Utility');
App::uses('Validation', 'Utility');
// App::uses('DecisionTree', 'Controller/Component');

class TreesController extends AppController
{
	var $ControllerName		=	"Trees";
	var $ModelName 			=	"Tree";
	var $helpers 			=	array("Text","General");
	var $aco_id;

	function beforeFilter()
	{
		parent::beforeFilter();
		$this->set("ControllerName", $this->ControllerName);
		$this->set("ModelName", $this->ModelName);
		$this->{$this->ModelName}->locale =  $this->Session->read('Config.language');

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

		$this->loadModel("Employee");
		$this->loadModel("WorkUnit");
		$this->loadModel("WorkShift");
		$joins			=	array(
								array(
									"table"			=>	"work_units",
									"alias"			=>	"WorkUnit",
									'type'			 => 'LEFT',
									"conditions"	=>	array(
										"Employee.work_unit_id = WorkUnit.id"
									)
								),
								array(
									"table"			=>	"work_shifts",
									"alias"			=>	"WorkShift",
									'type'			 => 'LEFT',
									"conditions"	=>	array(
										"Employee.work_unit_id = WorkShift.id"
									)
								)
							);
		$data	=	$this->Employee->find("all",array(
			"joins"			=>	$joins,
			"contain"		=>	array(
									"Employee",
									"WorkUnit",
									"WorkShift"
			),
			"fields"		=>	array(
									"Employee.id",
									"Employee.name",
									"Employee.age",
									"Employee.gender",
									"Employee.marital_status",
									"Employee.health_record",
									"Employee.house",
									"WorkUnit.name",
									"WorkShift.name"
			)
			
		));

		$atribut = array("name", "age", "gender", "marital_status", "health_record", "house", "work_unit", "work_shift");
		$i=0;

		foreach ($data as $key) {
			$arr[$i]['name'] 			= $key["Employee"]['name'];
			$arr[$i]['age'] 			= $key["Employee"]['age'];
			$arr[$i]['gender'] 			= $key["Employee"]['gender'] == "m" ? "Male": "Female";
			$arr[$i]['marital_status'] 	= $key["Employee"]['marital_status'] == "m" ? "Married" : "Single";
			$arr[$i]['health_record'] 	= $key["Employee"]['health_record'] == "b" ? "Not" : "Good";
			$arr[$i]['house'] 			= $key["Employee"]['house'];
			$arr[$i]['work_unit'] 		= $key["WorkUnit"]['name'];
			$arr[$i]['work_shift'] 		= $key["WorkShift"]['name'];
			$data_latih[$i][] 			= $arr[$i];
			$data_latih[$i][] 			= $key["WorkShift"]['name'];
			$i++;
		}

		// pr($data_latih);
		App::import('Component','DecisionTree');
		$this->DecisionTree = new DecisionTreeComponent();

		$this->DecisionTree->setAtribut($atribut);
		$this->DecisionTree->addDatalatih($data_latih);
		$this->DecisionTree->mulaiPelatihan();

		$tree 		= $this->DecisionTree->getTree();
		$entropy 	= $this->DecisionTree->hitungEntropy($data_latih);
		$gain 		= $this->DecisionTree->getGain($data_latih, $atribut);
		pr($gain);
		$this->set(compact(
			"page",
			"viewpage",
			"tree"
		));
	}
}

