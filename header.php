<header class="header">
	<a class="logo" href="index.php">
		<!-- <img src="image/logo.png" alt=""> -->
		<span class="name">
			<span class="th-name"><?php echo TITLE;?></span>
			<span class="en-name"><?php echo DESCRIPTION;?></span>
		</span>
	</a>
	
	<?php if ($user_online) {
		
	?>

	<a href="logout.php" class="menu btn-logout" target="_parent">ออกจากระบบ<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>

<?php

}
	?>

	</header>
