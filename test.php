<?php

class test
{
    protected $test = 'test';

    public function tmethod()
    {
        $this->ttmethod();
    }

    public function ttmethod()
    {
        echo $this->test;
    }
}

$test = new test();
$test->tmethod();


function testf($ss)
{
    static $testss;
    $testss .= $ss;
    echo $testss . '<br />';
}

testf('a1');
testf('a2');

function testff($name = null, $value = null)
{
    static $arr = array();
    if (empty($name)) {
        return $arr;
    }
    if ($name) {
        $arr[$name] = $value;
    }
}

echo '<br />';

testff('ss','lw');
testff('sss',"lws");
testff('','lwss');
$arr = testff();
print_r($arr);

function clean($data){
	if(is_array($data)){
		foreach($data as $key=>$value){
			unset($data[$key]);
			$data[clean($key)] = clean($value);
		}
	}else{
		$data = htmlspecialchars($data, ENT_COMPAT);
	}
	return $data;
}

$arr['s'] = array(
	's1' => 'l1',
	's2' => 'l2'
);

echo '<br />';
print_r($arr);
echo '<br />';
ksort($arr);
print_r($arr);
echo '<br />';
$arr = clean($arr);
print_r($arr);
echo '<br />';


echo '<br />';
/*
$tests = 'tests';
echo $tests.'<br />';
unset($tests);
echo $tests.'<br />';
*/


function make_code( $length = 8 )
{
	// 密码字符集，可任意添加你需要的字符
	$chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
			'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',
			't', 'u', 'v', 'w', 'x', 'y','z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D',
			'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O',
			'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z');

	// 在 $chars 中随机取 $length 个数组元素键名
	$keys = array_rand($chars, $length);
	
	$code = '';
	for($i = 0; $i < $length; $i++)
	{
		// 将 $length 个数组元素连接成字符串
		$code .= $chars[$keys[$i]];
	}

	return $code;
}


echo make_code();

function create_warr ($length = 8) {
	$code_arr = Array();
	/*
	$code_arr[] = create_arr('number', 10, 48, 57);
	$code_arr[] = create_arr('upcode', 26, 65, 90);
	$code_arr[] = create_arr('docode', 26, 97, 122);
	*/
	$code_arr[0] = array_merge(create_arr('number', 10, 48, 57), create_arr('upcode', 26, 65, 90), create_arr('docode', 26, 97, 122));
	$code_arr = $code_arr[0];
	$code = Array();
	
	for($i = 0; $i < 62; $i++){
		$key = array_rand($code_arr);
		$code_chr = $code_arr[$key];
		array_splice($code_arr, $key, 1);
		$code[] = chr($code_chr);
	}
	return $code;
}

function create_arr ($key, $arr_length, $strat = 0, $end) {
	$arr = Array();
	$arr[$key] = Array();
	for($i = 0; $i < $arr_length; $i++){
		$ls = rand($strat, $end);
		while(in_array($ls,$arr[$key])){
			$ls = rand($strat, $end);
		}
		$arr[$key][] = $ls;
	}
	return $arr[$key];
}

function my_make_code ($arr, $length) {
	// 密码字符集，可任意添加你需要的字符
	$chars = $arr;
	
	// 在 $chars 中随机取 $length 个数组元素键名
	$keys = array_rand($chars, $length);
	
	$code = '';
	for($i = 0; $i < $length; $i++)
	{
	// 将 $length 个数组元素连接成字符串
	$code .= $chars[$keys[$i]];
	}
	
	return $code;
}

echo '<br />';
$arr = create_warr();
echo my_make_code($arr, 15);

//phpinfo();

?>