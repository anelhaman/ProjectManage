<?php  
require_once 'autoload.php';
$project_name = isset($_POST['project_name']) ? $_POST['project_name'] : null;

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

				<!-- Form Name -->
				<legend>รายการ</legend>

					<?php
					if($project_name != null)
					{
							echo "กรอก ".$project_name." ลง database";
					}
					?>
	
	</div>
	</body>
	</html>