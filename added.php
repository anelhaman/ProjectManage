<?php  
require_once 'autoload.php';
$tel = isset($_POST['tel']) ? $_POST['tel'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$name = isset($_POST['name']) ? $_POST['name'] : null;
$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : null;
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
						if ($tel.length == 10) {
							echo "ใส่ user ไม่ถูกต้อง";
						}
						echo "invalid var!";
						header('Location:./Login.php');
						


					}else{
						try {
							$user_id = $user->register($tel,$password,$name,$lastname);
							echo "<a class='btn btn-info' href='./'>กลับสู่หน้าหลัก</a><br>";
							echo "<pre> ";
							echo "ชื่อ-สกุล :".$name." '".$lastname."<br>" ;
							echo "ลงทะเบียนผู้ใช้ ".$user_id." เรียบร้อยแล้ว</pre>";

							
						} catch (Exception $e) {
							
							echo "<a class='btn btn-warning' href='./'>กลับสู่หน้าหลัก</a><br>";
							echo "<pre> ไม่สามารถเพิ่มผู้ใช้ใหม่ได้ กรุณาติดต่อผู้ดูแลระบบ </pre>";
							
						}
						
						

						


					}


					?>
	
	</div>
	</body>
	</html>