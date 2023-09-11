<?php 
include('header.php');
	include 'rating.php';
	

	$rating = new rating();
	$user_details = $rating->get_user($_GET['user_token']);
	foreach($user_details as $user){
		$average = $rating->get_rating_average($user["user_token"]);
	?>	
	<div class="container" style="min-height:500px;">
	<div class=''>
	</div>
	<div class="row" style = "padding-top:100px;">
		<div class="col-sm-2" style="width:150px">
			<img class="product_image" src="<?php echo $user["user_token"].".jpg"; ?>">
		</div>
		<div class="col-sm-4">
		<h4 style="margin-top:10px;"><?php echo $user["user"]; ?></h4>
		<div><span class="average"><?php printf('%.1f', $average); ?> <small>/ 5</small></span> <span class="rating-reviews"><a href="show_rating.php?user_token=<?php echo $user["user_token"]; ?>">Rating & Reviews</a></span></div>
				
		</div>		
	</div>
	<?php } ?>	

	<?php	
	$user_rating = $rating->get_user_rating($_GET['user_token']);	
	$rating_number = 0;
	$count = 0;
	$five_star_rating = 0;
	$four_star_rating = 0;
	$three_star_rating = 0;
	$two_star_rating = 0;
	$one_star_rating = 0;	
	foreach($user_rating as $rate){
		$rating_number+= $rate['user_rating_number'];
		$count += 1;
		if($rate['user_rating_number'] == 5) {
			$five_star_rating +=1;
		} else if($rate['user_rating_number'] == 4) {
			$four_star_rating +=1;
		} else if($rate['user_rating_number'] == 3) {
			$three_star_rating +=1;
		} else if($rate['user_rating_number'] == 2) {
			$two_star_rating +=1;
		} else if($rate['user_rating_number'] == 1) {
			$one_star_rating +=1;
		}
	}
	$average = 0;
	if($rating_number && $count) {
		$average = $rating_number/$count;
	}	
	?>		
	<br>		
	<div id="ratingDetails"> 		
		<div class="row">			
			<div class="col-sm-3">				
				<h4>Rating and Reviews</h4>
				<h2 class="bold padding-bottom-7"><?php printf('%.1f', $average); ?> <small>/ 5</small></h2>				
				<?php
				$average_rating = round($average, 0);
				for ($i = 1; $i <= 5; $i++) {
					$rating_class = "btn-default btn-grey";
					if($i <= $average_rating) {
						$rating_class = "btn-warning";
					}
				?>
				<button  class="btn btn-sm <?php echo $rating_class; ?>" aria-label="Left Align">
				  <i class="fa fa-star" aria-hidden="true"></i>
				</button>	
				<?php } ?>				
			</div>
			<div class="col-sm-3">
				<?php
				$five_star_rating_percent = round(($five_star_rating/5)*100);
				$five_star_rating_percent = !empty($five_star_rating_percent)?$five_star_rating_percent.'%':'0%';	
				
				$four_star_rating_percent = round(($four_star_rating/5)*100);
				$four_star_rating_percent = !empty($four_star_rating_percent)?$four_star_rating_percent.'%':'0%';
				
				$three_star_rating_percent = round(($three_star_rating/5)*100);
				$three_star_rating_percent = !empty($three_star_rating_percent)?$three_star_rating_percent.'%':'0%';
				
				$two_star_rating_percent = round(($two_star_rating/5)*100);
				$two_star_rating_percent = !empty($two_star_rating_percent)?$two_star_rating_percent.'%':'0%';
				
				$one_star_rating_percent = round(($one_star_rating/5)*100);
				$one_star_rating_percent = !empty($one_star_rating_percent)?$one_star_rating_percent.'%':'0%';
				
				?>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">5 <i class="fa fa-star"></i></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $five_star_rating_percent; ?>">
							<span class="sr-only"><?php echo $five_star_rating_percent; ?></span>
						  </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $five_star_rating; ?></div>
				</div>
				
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">4 <i class="fa fa-star"></i></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $four_star_rating_percent; ?>">
							<span class="sr-only"><?php echo $four_star_rating_percent; ?></span>
						  </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $four_star_rating; ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">3 <i class="fa fa-star"></i></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $three_star_rating_percent; ?>">
							<span class="sr-only"><?php echo $three_star_rating_percent; ?></span>
						  </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $three_star_rating; ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">2 <i class="fa fa-star"></i></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $two_star_rating_percent; ?>">
							<span class="sr-only"><?php echo $two_star_rating_percent; ?></span>
						  </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $two_star_rating; ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">1 <i class="fa fa-star"></i></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $one_star_rating_percent; ?>">
							<span class="sr-only"><?php echo $one_star_rating_percent; ?></span>
						  </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $one_star_rating; ?></div>
				</div>
			</div>		
			<div class="col-sm-3">
				<button type="button" id="rateProduct" class="btn btn-info <?php if(!empty($_SESSION['user_token']) && $_SESSION['user_token']){ echo 'login';} ?>">Rate this user</button>
			</div>		
		</div>
		<div class="row">
			<div class="col-sm-7">
				<hr/>
				<div class="review-block">		
				<?php
				$user_rating = $rating->get_user_rating($_GET['user_token']);
				foreach($user_rating as $rating){				
					$date=date_create($rating['created']);
					$review_date = date_format($date,"M d, Y");						
				?>				
					<div class="row">
						<div class="col-sm-3">
							<img src="<?php echo $rating['user_token'].".jpg"; ?>" class="img-rounded user-pic">
							<div class="review-block-name">By <a href="#"><?php echo $rating['user']; ?></a></div>
							<div class="review-block-date"><?php echo $review_date; ?></div>
						</div>
						<div class="col-sm-9">
							<div class="review-block-rate">
								<?php
								for ($i = 1; $i <= 5; $i++) {
									$rating_class = "btn-default btn-grey";
									if($i <= $rating['user_rating_number']) {
										$rating_class = "btn-warning";
									}
								?>
								<button type="button" class="btn btn-xs <?php echo $rating_class; ?>" aria-label="Left Align">
								  <i class="fa fa-star" aria-hidden="true"></i>
								</button>								
								<?php } ?>
							</div>
							<div class="review-block-title"><?php echo $rating['title']; ?></div>
							<div class="review-block-description"><?php echo $rating['comments']; ?></div>
						</div>
					</div>
					<hr/>					
				<?php } ?>
				</div>
			</div>
		</div>	
	</div>

	<div id="ratingSection" style="display:none;">
		<div class="row">
			<div class="col-sm-12">
				<form id="ratingForm" method="POST">					
					<div class="form-group">
						<h4>Rate this user</h4>
						<button type="button" class="btn btn-warning btn-sm rateButton" aria-label="Left Align">
						  <i class="fa fa-star" aria-hidden="true"></i>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
						  <i class="fa fa-star" aria-hidden="true"></i>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
						  <i class="fa fa-star" aria-hidden="true"></i>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
						  <i class="fa fa-star" aria-hidden="true"></i>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
						  <i class="fa fa-star" aria-hidden="true"></i>
						</button>
						<input type="hidden" class="form-control" id="rating" name="rating" value="1">
						<input type="hidden" class="form-control" id="user_token" name="user_token" value="<?php echo $_GET['user_token']; ?>">
						<input type="hidden" name="action" value="save_rating">
					</div>		
					<div class="form-group">
						<label for="usr">Title*</label>
						<input type="text" class="form-control" id="title" name="title" required>
					</div>
					<div class="form-group">
						<label for="comment">Comment*</label>
						<textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-info" id="saveReview">Save Review</button> <button type="button" class="btn btn-info" id="cancelReview">Cancel</button>
					</div>			
				</form>
			</div>
		</div>		
	</div>


	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="loginmodal-container">
				<h1>Login to rate this product</h1><br>
				<div style="display:none;" id="loginError" class="alert alert-danger">Invalid username/Password</div>
				<form method="post" id="loginForm" name="loginForm">
					<input type="text" name="user" placeholder="Username" required>
					<input type="password" name="pass" placeholder="Password" required>
					<input type="hidden" name="action" value="userLogin">
					<input type="submit" name="login" class="login loginmodal-submit" value="Login">					 
				</form>
				<div class="login-help">					
					<p><b>User</b> : adam, rose, smith, merry <b>Password</b>: 123</p>
				</div>
			</div>
		</div>
	</div>



</div>

<?php require_once 'footer.php'?>
</body>
</html>





