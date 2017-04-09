<?php 

include('global-ghum.inc');

try{

	$host = $_REQUEST['host'];
	$db = $_REQUEST['database'];
	$user =$_REQUEST['user'];
	$pass = $_REQUEST['pass'];

	$new = $host.":".$db.":".$user.":".$pass;

	$filename = "conn.vs";
	$fp = fopen("../$filename", "r+");
	ftruncate($fp, 0);
	/*fwrite();
	fclose($fp);

	*/


	fwrite($fp, $new);
	fclose($fp);

	echo "OK";
}
catch(Exception $ex)
{
	echo "ERROR";
}


 ?>