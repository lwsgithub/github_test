<?php
	class parent_lw{
		protected $pname = 'lw';
		protected function pmethod(){
			echo '名字：'.$this->pname;
		}
		protected function &ss(){
			$ss = 'xsx';
			return $ss;
		}
	}
?>