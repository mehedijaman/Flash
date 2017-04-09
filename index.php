<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>.:: [Flash]::.</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/mango.css">
</head>
<body>
	<!-- <div id="loading" class="col-md-2 col-md-offset-5 loading"></div> -->
	<div id="loading"></div>

	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<div class="col-md-5 col-md-offset-4">
					<img src="img/logo_2.png" alt="" width="300px" height="60px">
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-md-offset-2"><h4>Step 1: Database Settings</h4></div>
				<div class="col-md-3 col-md-offset-2"><h4>Step 2: Select Table</h4></div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<?php include("lib/initiate.inc"); ?>
					
					<form class="form-horizontal" id="conn-info-form">
					  <div class="form-group">
					  
					    <label for="inputEmail3" class="col-sm-2 control-label">Host:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="host" name="host" placeholder="Host" value="<?php echo (isset($data[0])?$data[0]:''); ?>" disabled>
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">Database:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="database" name="database" placeholder="Database" value="<?php echo (isset($data[1])?$data[1]:''); ?>" disabled>
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">User:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="user" name="user" placeholder="User" value="<?php echo (isset($data[2])?$data[2]:''); ?>" disabled>
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
					    <div class="col-sm-10">
					      <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" value="<?php echo (isset($data[3])?$data[3]:''); ?>" disabled>
					    </div>
					  </div>
					  <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					      <input type="submit" class="btn btn-primary" disabled value="Save">
					      <button type="button" class="btn btn-info" id="change">Unlock</button>
					      <button type="button" class="btn btn-success" id="check">Check connection</button>
					      <button type="button" class="btn btn-danger" id="get-table-list">Get Table List>></button>
					    </div </div>
					</form>
					
				</div>
				
			</div>

			<div class="col-md-4 col-md-offset-1">
					<div class="row">
						<div class="col-sm-12">
							
						</div>
						
					</div>
					<div class="row">
						<div class="col-sm-12" >
							<form class="form-horizontal" id="table-list-form">
							</form>
						</div>
					</div>
				</div>

		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col- md-10 col-md-offset-1">
				<h3>Output</h3>
				<a href="#" target="_blank" id="preview-ui"></a><hr>
				<textarea class="form-control" id="outputval" cols="150" rows="10" readonly>
					
				</textarea>			
			</div>
		</div>
	</div>

		
		
		
	
	<script src="js/jq.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/danka.js"></script>
</body>
</html>