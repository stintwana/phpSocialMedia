<?php 
 $user = $_SESSION['user']['username'];
?>
<div class="header">
	<div class="logo">
		<a href="<?php echo 'dashboard.php' ?>">
			<h1>Be.rries Blog - Admin</h1>
		</a>
	</div>
	<div class="user-info">
		<span><?php echo $user ?></span> &nbsp; &nbsp; <a href= "logout.php" class="logout-btn">logout</a>
	</div>
</div>