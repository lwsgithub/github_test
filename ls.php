<?php
	require_once('DB.php');
	
	class ls extends DB{
		public $conn_lw;
		public function ss(){
			$this->conn_lw = @DB::connect('mysql://root@"http://test.localhost"/01');
			if(!DB::isError($this->conn_lw)){
				echo '数据库连接成功！';
			}
		}
	}
	$ss = new ls;
	$ss->ss();
	
	
	print_r(get_class_methods($ss));
?>