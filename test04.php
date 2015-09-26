<?php
$arr = Array(1,2,3,4,5);
foreach($arr as $ss){
	$xx += $ss;
}
echo $xx;


$arrs = Array(
	'a1' => 'ss',
	'a2' => Array(
		'aa1' => 'xxx',
		'aa2' => 'fff'
	)
);
extract($arrs['a2']);

echo '<br />';
echo $aa1;

echo '<br /><br /><br /><br /><br />';

class dg {
	public $i = 0;
	public function ss($a){
		$this->i += $a;
		if($a > 0){
			self::ss(--$a);
		}
	}
}

$dg = new dg();
$dg->ss(10);
echo $dg->i;




?>
