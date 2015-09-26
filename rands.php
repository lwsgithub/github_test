<?php
	for( $i = 0 ; $i < 16 ; $i++ ){
		$randnum = rand(0,2);
		switch($randnum){
			case 0 :
				printf("%c" , rand(48,57));
				break;
			case 1 :
				printf("%c" , rand(65,90));
				break;
			case 2 :
				printf("%c" , rand(97,122));
				break;
		}
	}
?>