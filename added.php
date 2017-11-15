<?php  
require_once 'autoload.php';
$tel = isset($_REQUEST['tel']) ? $_REQUEST['tel'] : null;
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
$name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
$lastname = isset($_REQUEST['lastname']) ? $_REQUEST['lastname'] : null;
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


					if($tel == null || $password == null || $name == null || $lastname == null)
					{
						echo "invalid var!";
						header('Location:./Login.php');
						


					}else{
						$user_id = $user->register($tel,$password,$name,$lastname);

						echo "you can login with Username :".$user_id;


						


					}


					?>
	
	</div>
	</body>
	</html>