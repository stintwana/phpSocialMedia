<?php
require_once 'dbConfig.php';
require_once( ROOT_PATH . '/registration_login.php');
require_once 'header.php';
require_once 'functions.php';
include('banner.php');

//Retrieve all posts from database  
 $posts = getPublishedPosts();
  ?>


 <h1 class="heading">Recent Articles</h1>

<div class="container">
	<div class="content"> <?php foreach ($posts as $post): ?>
	<div class="post" style="margin-left: 0px;">
		<img src="<?php echo 'images/' . $post['image']; ?>" class="post_image" alt="image" style = "width:100%;">
        <!-- Added this if statement... -->
		<?php if (isset($post['topic']['name'])): ?>
			<a 
				href="<?php echo './filtered_posts.php?topic=' . $post['topic']['id'] ?>"
				class="btn category">
				<?php echo $post['topic']['name'] ?>
			</a>
		<?php endif ?>

		<a href="single_post.php?post-slug=<?php echo $post['slug']; ?> "style = 'font-size: 18px;'>
			<div class="post_info">
				<h3><?php echo $post['title'] ?></h3>
				<div class="info">
					<span><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span>
					<span class="read_more">Read more...</span>
				</div>
			</div>
		</a>
	</div>

<?php endforeach ?>   
</div>
</div>
</body>
</html>