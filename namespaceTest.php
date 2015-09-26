<?php
	namespace test;
	class t11{
		public function tt(){
			echo 'tt()';
		}
	}
	namespace test1;
	use test\t11;
	class t1{
		public function tt(){
			echo 't1::tt()';
		}
	}
	$t1 = new t11();
	$t1->tt();
?>