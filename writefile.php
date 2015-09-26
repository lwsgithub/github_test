<?php
if(file_put_contents('writefile.html','xx xx xx'))echo 'OK';
$aa = 'AAA';
$bb = 'BBB';
$cc = 'CCC';
$abcarr = compact('aa','bb','cc');
print_r($abcarr);
?>