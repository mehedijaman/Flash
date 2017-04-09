<?php
error_reporting(0);
include('global-ghum.inc');
$filename = "../conn.vs";
$fp = fopen($filename,"r") or die("Unable to open the connection file");
$content = fread($fp,filesize($filename));
fclose($fp);
$data = array();
$data = explode(":", $content);


$c= mysql_connect($data[0],$data[2],$data[3]);
if(!$c)
{
	echo "Something went wrong. Check database settings and test again!";
	return;	
}
mysql_select_db($data[1]);


$sql = "show tables";
$r = mysql_query($sql);
$output = '
				<div class="form-group">
					<select name="tables" id="tables" class="form-control">';
while($row = mysql_fetch_array($r))
{
	$output.= "<option value='$row[0]'>$row[0]</option>";
}

$output .= '
					</select>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Generate Library</button>
					<button type="button" class="btn btn-primary" id="btn-generate-ui">Generate UI</button>
				</div>	
			';

echo $output;



?>

<script>

	$('#btn-generate-ui').click(function(){
				//alert('sone');
					$("#loading").addClass("loading").removeAttr("style");
					$('#outputval').html('');

					var field = $('#tables');
					var data = "tables=" + field.val(); 
					$.ajax({
						type:'POST',
						url: 'lib/generate_ui.php',
						data: data,
						cache: false
					})
					.done(function(r){
						var outputwindow = $('textarea#outputval');
						outputwindow.html(r);
					});
					//$("#loading").html("Done!").fadeOut(600,function(){});
					$("#loading").fadeOut(600,function(){});
					$('#outputval').focus();
					$('#preview-ui').html('[ Preview UI >>]').attr('href','output/preview_ui.php?tables='+ field.val());


			});
</script>
							   
							    
							  