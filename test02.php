<?php
	require_once 'test03.php';
	
	class children_lw extends parent_lw{
		protected $cname = 'lws';
		public function cmethod(){
			echo parent::pmethod();
			echo '<br />';
			echo '名字：'.$this->cname;
			echo '<br />';
			echo parent_lw::ss();
		}
	}
	
	$test = new children_lw;
	$test->cmethod();
?>