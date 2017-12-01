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
				<legend>ลงทะเบียน</legend>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="tel">เบอร์โทร</label>
				  <div class="col-md-5">
				  <input id="tel" name="tel" type="number" maxlength="10" placeholder="กรอกเบอร์โทร" class="form-control input-md" required="" autofocus>

				  </div>
				</div>

				<!-- Password input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="password">รหัสผ่าน</label>
				  <div class="col-md-5">
				    <input id="password" name="password" type="password" placeholder="ตัวเลข 4 ตัว" class="form-control input-md" required="" maxlength="4">

				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="name">ชื่อจริง</label>
				  <div class="col-md-5">
				  <input id="name" name="name" type="text" placeholder="กรอกชื่อจริง" class="form-control input-md" required="">

				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="lastname">นามสกุล</label>
				  <div class="col-md-5">
				  <input id="lastname" name="lastname" type="text" placeholder="กรอกนามสกุล" class="form-control input-md" required="">

				  </div>
				</div>

				<!-- Button -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="submit"></label>
				  <div class="col-md-4">
				    <button id="submit" class="btn btn-info">ยืนยัน</button>
				  </div>
				</div>

				</fieldset>
				</form>

	</div>



</body>
</html>
