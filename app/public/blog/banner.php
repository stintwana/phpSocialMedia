<?php if (isset($_SESSION['user']['username'])) { ?>

	<div class="banner">

	
		<div class="welcome_msg">			
			<p style = "padding : 0;"> 
			<b>KonneK</b> 
			   A new wa to connect
			</p>			
			<div class="logged_in_info">
		<span>welcome <?php echo $_SESSION['user']['username'] ?> | <a href="./admin/logout.php">logout</a></span><br/>
	</div>
		</div>

		<div class="login_div">
			<img src="../../images/header/beauty.png" alt="Beauty" style = "width:100%;">
		</div>
	</div>
	
<?php }else{ ?>
	<div class="banner">
		<div class="welcome_msg">			
			<p style = "padding : 0;"> 
			<b style = "font-family: beauty;">KONNEK</b> <br/>
			<b>KonneK</b> 
			   A new wa to connect
			</p>		
			<a href="register.php" class="btn">Become an author</a>
			<a href="register.php" class="btn">Subcribe</a>
		</div>

		<div class="login_div">
			<img src="../../images/header/beauty.png" alt="Beauty" style = "width:100%;">
		</div>
		<a class="log" href="login.php"><i class="fa fa-user"></i></a>
	</div>
<?php } ?>

