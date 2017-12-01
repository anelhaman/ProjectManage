<?php  
require_once 'autoload.php';
if (!$user_online) {
	# code...
	header("Location:./login.php");
	exit(); 
}

$project_name = $_POST['project_name'];
$user_id = $_POST['user_id'];

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
<link rel="stylesheet" href="css/test.css">
<link rel="stylesheet" type="text/css" href="plugin/font-awesome/css/font-awesome.min.css"/>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<?php include_once'header.php';?>

	<div class="container">

					<?php
						

						$status = $project->addproject($project_name,$user_id);
						if($status ==1)
							 {
							 	echo "<a class='btn btn-warning btnback' href='./'>กลับสู่หน้าหลัก</a><br>";
							 	echo "<pre id='precontent'>เพิ่มโครงการ ".$project_name." สำเร็จแล้ว</pre>"; 
							 }
						//echo $project_name;

					?>
	
	</div>
	</body>
	</html>