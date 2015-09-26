<?php
	for($i = 0; $i < 10; $i++){
		if($i%2 == 0){
			echo $i."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			print_r(require 'arrayreturn1.php');
			echo "<br />";
		}else{
			echo $i."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			print_r(require 'arrayreturn.php');
			echo "<br />";
		}
	}
	
	echo "<br /><br /><br /><br /><br />";
	function ss(){
		print_r(require 'arrayreturn.php');
		echo "<br />";
		print_r(include 'arrayreturn.php');
	}
	ss();
	
	
?>