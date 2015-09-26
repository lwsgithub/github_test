<?php
	$data = Array();
	for($i = 0; $i < 25; $i++){
		$data[] = '/skin/images/i'.$i.'.jpg';
	}
	echo json_encode($data);
?>