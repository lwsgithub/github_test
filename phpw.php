<?php 
$fp = fopen("test.txt", "w");//文件被清空后再写入 
if($fp) 
{ 
$count=0; 
for($i=1;$i<=5;$i++) 
{ 
$flag=fwrite($fp,"行".$i." : "."Hello World!\r\n"); 
if(!$flag) 
{ 
echo "写入文件失败<br>"; 
break; 
} 
$count+=$flag; 
} 
echo "共写入".$count."个字符"; 
} 
else 
{ 
echo "打开文件失败"; 
} 
fclose($fp); 
?> 