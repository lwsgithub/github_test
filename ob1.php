<?php
phpinfo();
//ob_start();
	 echo 'test';
	 //ob_end_clean();
	 // ob_end_clean();
	 @header("Expires: -1");
	 @header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
	 @header("Pragma: no-cache");
	 @header("Content-type: text/html; charset=utf-8");
	 echo "<script type=\"text/javascript\" reload=\"1\">alert('test');</script>";


?>