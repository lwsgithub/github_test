<?php
function create_unique(){
	$data = $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] . time() . rand();
	return sha1($data);
}
$newhash = create_unique();
echo "<pre>{$newhash}</pre>";
echo "<br />";
echo sha1(6);
?>