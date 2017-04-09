<?php

error_reporting(0);
//include('global-ghum.inc');
//show columns from category
//$tableAr = array();
//$columnAr = array();
$tableName = $_REQUEST['tables'];
//break;
//$private ="";
$o = "<form class=\"form-horizontal\">\r\n";
$o.= "\t<h3 align='center'>".ucwords($tableName)."</h3>\r\n";
connect();
$sql = "show columns from $tableName";
$r=mysql_query($sql);
$counter = 0;
while($row=mysql_fetch_array($r))
{
	$o.="\t\t<div class=\"form-group\">\r\n";
	$o.= "\t\t\t<label for=\"".$row['Field']."\" class=\"col-sm-2 control-label\">".ucwords($row['Field'])." :</label>\r\n";
	$o.= "\t\t\t<div class=\"col-sm-10\">\r\n";
	$o.= "\t\t\t\t<input type=\"text\" class=\"form-control\" id=\"".$row['Field']."\" placeholder=\"".ucwords($row['Field'])."\">\r\n";
	$o.= "\t\t\t</div>\r\n";
	$o.= "\t\t</div>\r\n";
}


$o.= "\t\t<div class=\"form-group\">\r\n";
$o.= "\t\t\t<div class=\"col-sm-offset-2 col-sm-10\">\r\n";
$o.= "\t\t\t\t<button type=\"submit\" class=\"btn btn-primary\">Save</button>\r\n";
$o.= "\t\t\t\t<button type=\"button\" class=\"btn btn-danger\">Cancel</button>\r\n";
$o.= "\t\t\t</div>\r\n";
$o.= "\t\t</div>\r\n";
$o.="</form>";

function connect()
{
	$filename = "../conn.vs";
	$fp = fopen($filename,"r") or die("Unable to open the connection file");
	$content = fread($fp,filesize($filename));
	fclose($fp);
	$data = array();
	$data = explode(":", $content);

	$c = mysql_connect($data[0],$data[2],$data[3]);
	if(!$c)
	{
		echo "Something went wrong. Check database settings and test again!";
		return;	
	}
	mysql_select_db($data[1]);

};


echo $o;


?>

    
    
      
  
