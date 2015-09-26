<?php
ob_start();
//echo realpath(dirname(__FILE__));
//echo '<br />';
echo __FILE__;
$content = __FILE__;
ob_end_flush();
//ob_end_clean();


//phpinfo();
?>