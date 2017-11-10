<?php  
require_once 'autoload.php';

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
		<form class="form-horizontal" action="added.php" method="POST">
				<fieldset>

				<!-- Form Name -->
				<legend>รายการ</legend>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="project_name">ชื่อโครงการ</label>  
				  <div class="col-md-6">
				  <input id="project_name" name="project_name" type="text" placeholder="กรอกชื่อโครงการ" class="form-control input-md" required="">
				    
				  </div>
				</div>

				<!-- Button -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="submit"></label>
				  <div class="col-md-4">
				    <button id="submit" name="submit" class="btn btn-success">เพิ่มโครงการ</button>
				    <a class="btn btn-info" href="view.php">แสดงโครงการทั้งหมด</a>
				  </div>
				</div>

				<!-- Button -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="submit"></label>
				  <div class="col-md-4">
				    
				  </div>
				</div>

				</fieldset>
			</form>


	</div>

<script type="text/javascript" src="js/lib/jquery-3.2.1.min.js"></script>
</body>
</html>