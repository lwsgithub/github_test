<?php

class parentclass {
	public $test;
	public function __construct(){
		$this->test = 'test';
		echo 'I am parent.';
	}
}

class childrenclass extends parentclass {
	public function __construct(){
		//echo $this->test;
		//echo '<br />';
		echo 'I am children.';
	}
	public function getpp(){
		echo $this->test;
	}
}

$pc = new childrenclass();
$pc->getpp();

?>