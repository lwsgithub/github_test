<?php
	if(is_uploaded_file($_FILES['upfile']['tmp_name'])){
		echo $_FILES['upfile']['name'];
	};
?>