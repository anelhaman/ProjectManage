<?php  
require_once 'autoload.php';

if($user_online) {
	header("Location: index.php");
	exit(); 


}
?>

<!DOCTYPE html>
<html lang="en">

<!-- Meta Tag -->
<meta charset="utf-8">

<!-- Viewport (Responsive) -->
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="user-scalable=no">
<meta name="viewport" content="initial-scale=1,maximum-scale=1">

<title><?php echo TITLE;?></title>

<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="plugin/font-awesome/css/font-awesome.min.css"/>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include_once'header.php';?>

	
	<div class="container">
		<form class="form-horizontal" action='checklogin.php' method="POST">
			<fieldset>

			<!-- Form Name -->
			<legend>Login</legend>

			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="username"></label>  
			  <div class="col-md-5">
			  <input id="username" name="username" type="number" placeholder="กรอกเบอร์โทรศัพท์" class="form-control input-md" required="" value="0957892522">
			    
			  </div>
			</div>

			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="password"></label>  
			  <div class="col-md-5">
			  <input id="password" name="password" type="password" placeholder="Password" class="form-control input-md" required="">
			    
			  </div>
			</div>

			<!-- Button (Double) -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="login"></label>
			  <div class="col-md-8">
			    <button id="login" name="" class="btn btn-success">Login</button>
			    <a href="register.php" id="register" name="register" class="btn btn-link">Register</a>
			  </div>
			</div>

			</fieldset>
			</form>

				</div>

</body>
</html>
