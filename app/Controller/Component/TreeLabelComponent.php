<?php
class TreeLabelComponent extends Component
{
	var $label;

	public function __construct($lab) { 
		$this->label = $lab;
	}

	public function __toString() { 
		pr((string) $this->label);
		return (string) $this->label;
	}

	public function getLabel() {
		return $this->label;
	}
}
