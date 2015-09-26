<?php

	$arr = array("name","bname");
	//print_r($arr);
	$vals = array("lw","ss");
	$valss = array("lws","sss");
	/*$name  = "lw";
	$bname = "ss";
	$key = "name";
	echo $$key.'<br />';*/
	
	foreach($arr as $key=>$val){
		$$val = $vals[$key];
		//echo $$val.'<br />';
	}
	foreach($vals as $key=>$val){
		$$val = $valss[$key];
	}
	foreach($arr as $val){
		echo $$$val."<br />";
	}
	
	$extract_ss = array(
		'lw' =>'ss',
		'lws'=>'sss'
	);

	extract($extract_ss);//从数组中将变量导入到当前的符号表
	echo $lw . '<br />', $lws . '<br />';
	
	$forarr = array('a', 'b', 'c', 'd', 'e');
	foreach($forarr as $key=>$value) {
		echo $key . ':' . $value . '<br />';
	}
	
	
	
	
	define('XX','SS');
	if(defined('XX') or die){//如果为真就执行，否则退出
		echo 't';
	}else{
		echo 'f';
	}
	
	
	echo '<br />'.__FILE__;//文件的完整路径和文件名
	echo '<br />'.dirname(__FILE__);//文件所在的目录(__DIR__)
	
	echo '<br />';
	$array_key       = array('id' , 'name' , 'age');
	$array_value     = array('001' , 'lw' , '35');
	$key_based_array = array_combine($array_key, $array_value);//从两个不同的数组创建基于关键字的数组
	print_r($key_based_array);
	
	$arr1 = array('a' , 'b' , 'c' , 'd' , 'e');
	print_r(array_slice($arr1, 1, 3));//从数组提取子数组
	echo '<br />';
	arsort($arr1);//数组降序排序（asort升序）
	print_r($arr1);
	echo '<br />';
	echo '数组中元素出现的次数';
	$arr_count = array_count_values($arr1);
	print_r($arr_count);
	echo '<br />';
	echo '返回数组包含的值';
	$value_array = array_values($arr1);
	print_r($value_array);
	echo '<br />';
	
	$arr_replace = array(1 , 2 , 3);
	print_r(array_splice($arr1, 1, 3, $arr_replace));//用另一个数组替换数组的一部分
	print_r($arr1);
	
	echo '<br />';
	$str = 'abcdefghijk';
	echo substr($str, -1);
	
	echo '<br />';
	$name = 'lws';
	function ss(){
		global $name;
		$name = 'lw';
	}
	ss();
	echo $name;
	
	
	
	echo '<br />';
	function cut_str($str, $length, $start=0)
{
	//global $charset;
	/*if(function_exists("mb_substr")) {
	    if(mb_strlen($str, $charset) <= $length) return $str;
	    $slice = mb_substr($str, $start, $length, $charset);
	} else {*/
		$re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re['utf-8'], $str, $match);
		if(count($match[0]) <= $length) return $str;
		$slice = join("",array_slice($match[0], $start, $length));
	//}
	return $slice;
}

function str_len($str)
{
    $length = strlen(preg_replace('/[\x00-\x7F]/', '', $str));
    if($length) {
        return strlen($str) - $length + intval($length / 3) * 2;
    } else {
        return strlen($str);
    }
}

$str = 'abcdefg我的中国心∵∴';
echo cut_str($str, 5, 1);
echo '<br />';
echo str_len($str);

echo '<br />';
echo strlen($str);	
	

echo '<br />';
$str2 = 'ab"cd"efg';
echo addslashes($str2);
echo '<br />';

$str3 = '<p class="pp"><a href="#">xx</a></p>';
$sss =  htmlspecialchars($str3, ENT_QUOTES);
echo $sss;

echo '<br />';
echo mysql_get_server_info();
echo '<br />';
echo time();

echo '<br />';
function cache_page($refresh = 0){
	$hash = sha1($_SERVER['PHP_SELF'].'|G|'.serialize($_GET).'|P|'.serialize($_POST));
	$file = dirname(__FILE__).'/cache/'.$hash;
	if((time() - @filemtime($file)) < $refresh){
		readfile($file);
		exit();
	}else{
		ignore_user_abort();
		register_shutdown_function('_cache_page_exit', $file);
		ob_start();
	}
}
function _cache_page_exit($file){
	$output = ob_get_flush();
	flush();
	file_put_contents($file, $output, LOCK_EX);
}

cache_page();

echo 'lwssd';

?>