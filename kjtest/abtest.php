<?php
abstract class atest {
	abstract public function aa();
	abstract public function bb();
}
abstract class btest extends atest {
	public function aa(){
		echo 'aa';
	}
	public function bb(){
		echo 'bb';
	}
	public function cc(){
		echo 'cc';
	}
	abstract public function dd();
}

class ctest extends btest {
	public function cc(){
		echo 'cc';
	}
	public function dd(){
		echo 'dd';
	}
}

$ctest = new ctest();
$ctest->cc();

/**
 * 
 * */



interface Itest {
	function aa();
	function bb();
}
interface Itests {
	function cc();
}


class sitest implements Itest {
	function aa(){
		echo 'aa';
	}
	function bb(){
		echo 'bb';
	}
}

class ssitest extends sitest implements Itests {
	function cc(){
		echo 'cc';
	}
	function dd(){
		echo 'dd';
	}
}

$sitest = new sitest();
$sitest->aa();

$ssitest = new ssitest();
$ssitest->cc();
$ssitest->dd();

















