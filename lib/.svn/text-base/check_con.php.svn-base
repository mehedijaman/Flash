<?php 
include('global-ghum.inc');
$filename = "../conn.vs";
$fp = fopen($filename,"r") or die("Unable to open the connection file");
$content = fread($fp,filesize($filename));
fclose($fp);
$data = array();
$data = explode(":", $content);


if(mysql_connect($data[0],$data[2],$data[3]))
{
	if(mysql_select_db($data[1]))
		echo "OK";
	else
		echo "ERROR";
}
else
	echo "ERROR";




?>