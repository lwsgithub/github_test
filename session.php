<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-8-28
 * Time: 上午10:01
 */


session_start();
$_SESSION['test'] = 'test_new';
echo session_id();
echo '<br />';
echo $_COOKIE["PHPSESSID"];
echo '<br />';
echo strlen(session_id());
//unset($_SESSION['test']);
//session_destroy();
?>