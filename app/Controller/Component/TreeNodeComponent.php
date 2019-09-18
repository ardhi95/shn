<?php
class TreeNodeComponent extends Component
{
	var $values;

	public function __construct($val) { 
		$this->values = $val;
	}

	public function __get($val) { 
		if(isset($this->values[$val]) == false){ 
			throw new \Exception('Node yang dicari tidak ada.');
		}
		return $this->values[$val];
	}

	public function __isset($val){ 
		return isset($this->values[$val]);
	}
}
