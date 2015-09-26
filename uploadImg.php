<?php
//phpinfo();
/*
	$imgb = imagecreatetruecolor(100, 100);
	$imgc = imagecolorallocate($imgb, 255, 0, 0);
	$imgcb = imagecolorallocate($imgb, 0, 128, 128);
	imagefill($imgb, 0, 0, $imgcb);
	imageline($imgb, 0, 0, 50, 50, $imgc);
	imageline($imgb, 0, 100, 50, 50, $imgc);
	imageline($imgb, 100, 0, 50, 50, $imgc);
	imageline($imgb, 100, 100, 50, 50, $imgc);
	imagestring($imgb, 4, 60, 10, "PHP", $imgc);
	header("Content-type: image/png");
	imagepng($imgb);
	imagedestroy($imgb);
	*/
	
	//
	$image = imagecreatefromjpeg("skin/images/4.jpg");
	$width = imagesx($image);
	$height = imagesy($image);
	$thumb_width = $width * 0.5;
	$thumb_height = $height * 0.5;
	//$img = imagecreatetruecolor($width, $height);
	$thumb = imagecreatetruecolor($thumb_width, $thumb_height);
	imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
	imagejpeg($thumb, "skin/images/4_thumb.jpg", 100);
	imagedestroy($thumb);
	
	echo "<img src='skin/images/4_thumb.jpg' />";
	echo '<br />';
	echo urlencode('http://food.mvsun.com/');



?>