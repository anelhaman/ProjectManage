<?php
require_once 'autoload.php';

if (!$user_online) {
	# code...
	header("Location:./login.php");
	exit();
}

$alloroject = $project->countProjectFormOwnerID($user_id);

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
<link rel="stylesheet" type="text/css" href="css/test.css"/>

<link rel="stylesheet" type="text/css" href="plugin/font-awesome/css/font-awesome.min.css"/>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include_once 'header.php';?>

	<div class="container" >
	<div id="indexcontent">
	<h2>โครงการทั้งหมด</h2>

	<?php
		// echo "user code ".$user_id;
	?>

		<form class="form-horizontal" action="addproject.php" method="POST">




				  <label>เพิ่มโครงการ</label>

				  <input id="project_name" name="project_name" type="text" placeholder="กรอกชื่อโครงการ" class="form-control input-md" required="" autofocus>



				    <button id="submit" type=submit name="submit" class="btn btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มโครงการใหม่</button>

				    <!--  <a class="btn btn-info" href="view.php">แสดงโครงการทั้งหมด</a>

				   -->

				 <input type="hidden" name="user_id" value="<?php echo $user_id;?>">


			</form>

			</div>

			<div id="viewcontent">

				<h4>จำนวนโครงการในขณะนี้ <?php echo $alloroject['n'];?> โครงการ</h4>

		  <table class="table table-hover ">

		    <thead>
		      <tr >
		        <th id="num">ลำดับ</th>
		        <th class='center'>ชื่อโครงการ</th>
						<th class='center'>จำนวนกิจกรรม</th>
		      </tr>
		    </thead>
		    <tbody>

		    	<?php

		    	$i=0;
		    	$r = $project->getProjectFromIdUser($user_id);
		    	foreach ($r as $key => $value) {
		    		$i++;
						$allact = $activity->countActivitiesFromProjectID($value['id']);

		    		echo "<tr> ";
		    		echo	"<td>".$i."</td>";
						echo "<td> ";
						echo "<a href='activities.php?project=".$value["id"]."&owner=".$value["owner"]."'>";
		    		echo $value['name'];
						echo " </td>";
						echo "</a>";
		    		echo "<td class='center'> 0 / ".$allact['n']." </td>";

		    	}


		    	?>


						 </tr>
		    </tbody>

		  </table>
		  </div>
		  </div>


<script type="text/javascript" src="js/lib/jquery-3.2.1.min.js"></script>
</body>
</html>
