<?php  
require_once 'autoload.php';
if (!$user_online) {
	# code...
	header("Location:./login.php");
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


<link rel="stylesheet" type="text/css" href="css/reset.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/test.css"/>

<link rel="stylesheet" type="text/css" href="plugin/font-awesome/css/font-awesome.min.css"/>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include_once'header.php';?>

							

	<div class="container" id="viewcontent">
	<a class='btn btn-link' href='./'>กลับสู่หน้าหลัก</a><br>
  	<H2>รายการ</H2>
		  <table class="table table-hover ">

		    <thead>
		      <tr>
		        <th id="num">ลำดับ</th>
		        <th>ชื่อโครงการ</th>
		      </tr>
		    </thead>
		    <tbody>
		    
		    	<?php
		    	$i=0;
		    	$r = $project->getall();
		    	foreach ($r as $key => $value) {
		    		$i++;
		    		?>

		    		<tr>
		    			<td><?php echo $i; ?></td>
		    			<td><?php echo $value['name']; ?></td>
		    		</tr>
		    		<?php
		    	}

		    		


		    	?>
		    </tbody>

		  </table>
		  </div>
	</div>

	

	</body>

	</html>