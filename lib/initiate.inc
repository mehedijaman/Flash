<?php 

$filename = "conn.vs";
$fp = fopen($filename,"r") or die("Unable to open the connection file");
$content = fread($fp,filesize($filename));
fclose($fp);
$data = array();
$data = explode(":", $content);

if(sizeof($data)<1)
{
	$data[0]="localhost";
	$data[1]="Database";
	$data[2]="root";
	$data[3]="";

}

//print_r($data);




?>