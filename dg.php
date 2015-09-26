<?php
function bbnqs(){
	$arr    = array();
	$arr[0] = 0;
	$arr[1] = 1;
	for($i = 2; $i <= 8; $i++){
		$arr[$i] = $arr[$i-1] + $arr[$i-2];
	}
	return $arr;
}


$arr = array();
$arr[0] = 0;
$arr[1] = 1;
function bbnq($num,$i = 2){
	global $arr;
	if($i < $num){
		$arr[$i] = $arr[$i-1]+$arr[$i-2];
		bbnq($num,++$i);
	}
	return $arr;
}

$arrs = array();
$arrs = bbnq(15);

print_r(bbnqs());
echo '<br />';
print_r($arrs);

echo '<br /><br /><br /><br /><br />';

class bbnq {
	protected $arr = array();
	protected $i   = 2;
	protected $num = 0;
	function __construct($num){
		$this->arr[0] = 0;
		$this->arr[1] = 1;
		$this->num = $num;
	}
	public function creatarr(){
		if($this->i < $this->num){
			$this->arr[$this->i] = $this->arr[$this->i-1] + $this->arr[$this->i-2];
			$this->creatarr(++$this->i);
		}
	}
	
	public function get(){
		return $this->arr;
	}
	
}

$bbnq = new bbnq(10);
$bbnq->creatarr();
print_r($bbnq->get());

echo '<br /><br /><br /><br /><br />';

class jcdg{
	protected $num = 0;
	protected $i   = 1;
	/*function __construct($num){
		$this->num = $num;
	}*/
	function creatarr(){
		if($this->i <= 1){
			$this->num = 1;
			$this->i++;
			$this->creatarr();
		}else{
			if($this->i <= 4){
				$this->num = $this->num*($this->i);
				$this->i++;
				$this->creatarr();
			}
		}
	}
	function get(){
		return $this->num;
	}
}

$jcdg = new jcdg();
$jcdg->creatarr();
echo $jcdg->get();

echo '<br /><br /><br /><br /><br />';

function jcdgh($num){
	if($num == 1){
		return 1;
	}else{
		return $num * jcdgh($num-1);
	}
	
}

echo jcdgh(4);

echo '<br /><br /><br /><br /><br />';

class jcdgx{
	protected $num = 1;
	protected $i = 4;
	/*function __construct($num){
		$this->num = $num;
	}*/
	function creatarr(){
		if($this->i == 1){
		}else{
			$this->num = $this->num*(--$this->i);
			$this->creatarr();
		}
	}
	function get(){
		return $this->num;
	}
}

$jcdgx = new jcdgx();
$jcdgx->creatarr();
echo $jcdgx->get();






?>