<?php 
error_reporting(0);
//include('global-ghum.inc');
//show columns from category
$tableAr = array();
$columnAr = array();
$tableName = $_POST['tables'];
//break;
$private ="";
connect();
$sql = "show columns from $tableName";
$r=mysql_query($sql);
$counter = 0;
while($row=mysql_fetch_array($r))
{
	$columnAr['Field'] = $row[0]; 
	$columnAr['Type'] = $row[1];
	$columnAr['Null'] = $row[2];
	$columnAr['Key'] = $row[3];
	$columnAr['Default'] = $row[4];
	$columnAr['Extra'] = $row[5];

	$tableAr[$counter] = $columnAr;
	$private.= PrivateVarGen($columnAr['Field']);
	$counter++;
}

//print_r($tableAr);


$t.=classNameGen($tableName);
$t.=br(1);
$t.= $private;
$t.=br(2);
$t.=GenerateGetSet();
$t.= GenCreate($tableAr,$tableName);
$t.= GenGetByPk($tableAr,$tableName);
$t.= GenDelete($tableAr,$tableName);
$t.= GenUpdate($tableAr,$tableName);
$t.=closingBrace();
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

function br($n) // Create n times Break
{
	for($i=0;$i<$n;$i++)
		$br.="\n";
	
	return $br;
};
function classNameGen($className) 
{
	return "class $className{\r\n";
};
function closingBrace()
{
	return "}\r\n";
};
function privateVarGen($varName)
{
	return "\tprivate \$_$varName;\r\n";
};

function GenerateGetSet()
{
	$o = "\tpublic function __get(\$property_name){\r\n\n";
	$o.= "\t\t\$private_property_name = '_'.\$property_name;\r\n";
	$o.= "\t\tif(property_exists(\$this, \$private_property_name)){\r\n";
	$o.= "\t\t\treturn \$this->\$private_property_name;\r\n";
	$o.= "\t\t}";
	$o.= "\t\ttrigger_error('Undefined property named through __get(), field name='.\$property_name);\r\n";
	$o.= "\t\treturn null;\r\n\n";
	$o.= "\t}\r\n\n\n";


	$o.= "\tpublic function __set(\$property_name, \$value){\r\n\n";
	$o.= "\t\t\$private_property_name = '_'.\$property_name;\r\n";
	$o.= "\t\tif(property_exists(\$this, \$private_property_name)){\r\n";
	$o.= "\t\t\t\$this->\$private_property_name = \$value;\r\n";
	$o.= "\t\t}\r\n";
	$o.= "\t}\r\n";


		
	return $o;
};
function GenCreate($tableAr, $table_name)
{
	$o = "\tpublic function create(\$data){\r\n";
	$o.= "\t\t\$objDB = new db;\r\n\n";
	
	// assign to local fields
	$fieldNames = "";
	$fieldbyTypes = "";
	$pk="";
	foreach($tableAr as $column)
	{

		if($column['Key'] == "PRI")
		{
			
			if(strtolower($column['Extra']) == "auto_increment")
			{
				$pk = "\$this->_".$column['Field']." = mysql_insert_id();";
			}
			else
			{
				$o.= "\t\t\$this->_".$column['Field']." = mysql_real_escape_string(\$data['".$column['Field']."']);\r\n";
				$pk = "\$this->_".$column['Field']." = \$data['".$column['Field']."'];";
				$fieldNames .= $column['Field'] . ",";
			}
		}
		else
			{
				$o.= "\t\t\$this->_".$column['Field']." = \$data['".$column['Field']."'];\r\n";
				$fieldNames .= $column['Field'] . ",\n\t\t\t";
			}

		//$fieldNames .= $column['Field'] . ",";

		$dataType = explode("(",$column['Type']);
		if($column['Key'] == "PRI" && strtolower($column['Extra']) == "auto_increment")
			continue;
		//CHAR,VARCHAR,TINYTEXT,TEXT,MEDIUMTEXT,LONGTEXT
		//if($column['Key']=="")
		if(strtoupper($dataType[0]) == "CHAR" || strtoupper($dataType[0]) == "VARCHAR" || strtoupper($dataType[0]) == "TEXT" || strtoupper($dataType[0]) == "DATETIME")
			$fieldbyTypes .="'\$this->_".$column['Field']."',\n\t\t\t";
		else
			$fieldbyTypes .="\$this->_".$column['Field'].",";
	}

	$fieldNames = substr($fieldNames, 0 , strlen($fieldNames)-1);
	$fieldbyTypes = substr($fieldbyTypes, 0 , strlen($fieldbyTypes)-1);

	$o.= "\t\t\$sql = \"INSERT INTO $table_name(\r\n";
	$o.= "\t\t\t$fieldNames)\";\r\n";
	$o.= "\t\t\$sql.= \" VALUES($fieldbyTypes)\";\r\n";

	$o.= "\t\t\$objDB->execute(\$sql);\r\n";
	$o.= "\t\t".$pk."\r\n\n";
	$o.= "\t\t\$objDB->close();\r\n";
	$o.= "\t}\r\n";

	return $o;
};

function GenGetByPk($table_array,$tableName)
{
	$o = "\tpublic function get_by_pk(\$id){\r\n";
	

	$pk = array();
	$restFields="";
	foreach($table_array as $col)
	{
		
		if($col['Key'] == "PRI")
		{
			$dataType = explode("(",$col['Type']);
			$pk['Name'] = $col['Field'];
			$comma = "n";
			if(strtoupper($dataType[0]) == "CHAR" || strtoupper($dataType[0]) == "VARCHAR" || strtoupper($dataType[0]) == "TEXT" || strtoupper($dataType[0]) == "DATETIME")
			{
				//$pk['property'] = "'\$this->_".$col['Field']."'";
				$comma = "y";
			}
			else
				$comma = "n";//$pk['property'] = "\$this->_".$col['Field']."";	
		}
		else
		{
			$restFields.= "\t\t\$this->_".$col['Field']." = \$data[0]['".$col['Field']."'];\r\n";
		}
	}

	//print_r($dataType);
	//echo $comma;

	$o.= "\t\t\$sql = \"SELECT * FROM ".$tableName." WHERE ".$pk['Name']." = ".($comma=="y"?"'\$id'":"\$id")."\";\r\n";
	$o.= "\t\t\$objDB = new db;\r\n\n";
	$o.= "\t\t\$data = \$objDB->fetch_result(\$sql);\r\n";
	$o.= "\t\t\$this->_".$pk['Name']." = \$id;\r\n";	
	$o.= $restFields;
	$o.= "\t\t\$objDB->close();\r\n";
	$o.= "\t\treturn \$data;\r\n";
	$o.= "\t}\r\n";

	return $o;
};


function GenDelete($table_array,$tableName)
{

	$o = "\tpublic function delete(\$id){\r\n";
	$pk = array();
	foreach($table_array as $col)
	{
		if($col['Key'] == "PRI")
		{
			$dataType = explode("(",$col['Type']);
			$pk['Name'] = $col['Field'];
			if(strtoupper($dataType[0]) == "CHAR" || strtoupper($dataType[0]) == "VARCHAR" || strtoupper($dataType[0]) == "TEXT" || strtoupper($dataType[0]) == "DATETIME")
			{
				$pk['property'] = "'\$this->_".$col['Field']."'";
			}
			else
				$pk['property'] = "\$this->_".$col['Field']."";	
			break;
		}
		
	}
	$o.= "\t\t".$pk['property']." =\$id;\n";
	$o.= "\t\t\$sql = \"DELETE FROM ".$tableName." WHERE ".$pk['Name']." = ".$pk['property']."\";\r\n";
	$o.= "\t\t\$objDB = new db;\r\n";
	$o.= "\t\t\$objDB->execute(\$sql);\r\n";
	$o.= "\t\t\$objDB->close();\r\n";
	$o.= "\t}\r\n";

	return $o;

};
//Generate Update operation
function GenUpdate($table_array,$tableName){

	$o = "\tpublic function update(){\r\n";

	$pk = array();
	$restFields="";
	foreach($table_array as $col)
	{
		$dataType = explode("(",$col['Type']);
		if($col['Key'] == "PRI")
		{
			
			$pk['Name'] = $col['Field'];
			if(strtoupper($dataType[0]) == "CHAR" || strtoupper($dataType[0]) == "VARCHAR" || strtoupper($dataType[0]) == "TEXT" || strtoupper($dataType[0]) == "DATETIME")
			{
				$pk['property'] = "'\$this->_".$col['Field']."'";
			}
			else
				$pk['property'] = "\$this->_".$col['Field']."";	
		}
		else
		{
			if(strtoupper($dataType[0]) == "CHAR" || strtoupper($dataType[0]) == "VARCHAR" || strtoupper($dataType[0]) == "TEXT" || strtoupper($dataType[0]) == "DATETIME")
			{
				$restFields.= "\t\t".$col['Field']." = '\$this->_".$col['Field']."',";
			}
			else
				$restFields.= "\t\t".$col['Field']." = \$this->_".$col['Field'].",";
			
		}
	} //end foreach

	$restFields = substr($restFields, 0 , strlen($restFields)-1);
	$o.= "\t\t\$sql = \"UPDATE ".$tableName." SET \r\n";
	$o.= $restFields;
	$o.= " WHERE ".$pk['Name']." = ".$pk['property']."\";\r\n";

	$o.= "\t\t\$objDB = new db;\r\n";
	$o.= "\t\t\$objDB->execute(\$sql);\r\n";
	$o.= "\t\t\$objDB->close();\r\n";
	$o.= "\t}\r\n";

	return $o;
};
 
echo $t;



 ?>

 