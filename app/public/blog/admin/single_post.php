<?php  include('../dbConfig.php'); ?>
	<?php include('./admin_functions.php'); ?>
	<?php include('./header_admin.php'); ?>



    <?php 
    
/* * * * * * * * * * * * * * *
* Returns a single post
* * * * * * * * * * * * * * */

/* * * * * * * * * * * * * * *
* Receives a post id and
* Returns topic of the post
* * * * * * * * * * * * * * */
function getPostTopic($post_id){
	global $db;
	$sql = "SELECT * FROM topic WHERE id=
			(SELECT topic_id FROM post_topic WHERE post_id=$post_id) LIMIT 1";
	$result = mysqli_query($db, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic;
}

function getPost($slug){
	global $db;
	// Get single post slug
	$post_slug = $_GET['post-slug'];
	$sql = "SELECT * FROM posts WHERE slug='$post_slug' AND published=true";
	$result = mysqli_query($db, $sql);

	// fetch query results as associative array.
	$post = mysqli_fetch_assoc($result);
	if ($post) {
		// get the topic to which this post belongs
		$post['topic'] = getPostTopic($post['id']);
	}
	return $post;
}
/* * * * * * * * * * * *
*  Returns all topics
* * * * * * * * * * * * */



	if (isset($_GET['post-slug'])) {
		$post = getPost($_GET['post-slug']);
	}
	$topics = getAllTopics();
?>
	<title>Admin | Dashboard</title>
</head>

<body>
    
<style>
    
/* * * * * * * * *
* SINGLE PAGE 	 *
* * * * * * * * */
.content .post-wrapper {
	width: 90%;
	float: left;
	min-height: 250px;
}
.full-post-div {
	min-height: 300px;
	padding: 20px;
	border: 1px solid #e4e1e1;
	border-radius: 2px;
}
.full-post-div h2.post-title {
	margin: 10px auto 20px;
	text-align: center;
}
.post-body-div {
	font-family: 'Noto Serif', serif;
	font-size: 1.2em;
}
.post-body-div p {
	margin:20px 0px;
}
.post-sidebar {
	width: 24%;
	float: left;
	margin-left: 5px;
	min-height: 400px;
}
.content .post-comments {
	margin-top: 25px;
	border-radius: 2px;
	border-top: 1px solid #e4e1e1;
	padding: 10px;
}
.post-sidebar .card {
	width: 95%;
	margin: 10px auto;
	border: 1px solid #e4e1e1;
	border-radius: 10px 10px 0px 0px;
}
.post-sidebar .card .card-header {
	padding: 10px;
	text-align: center;
	border-radius: 3px 3px 0px 0px;
	background: #3E606F;
}
.post-sidebar .card .card-header h2 {
	color: white;
}
.post-sidebar .card .card-content a {
	display: block;
	box-sizing: border-box;
	padding: 8px 10px;
	border-bottom: 1px solid #e4e1e1;
	color: #444;
}
.post-sidebar .card .card-content a:hover {
	padding-left: 20px;
	background: #F9F9F9;
	transition: 0.1s;
}

.message {
	width: 100%; 
	margin: 0px auto; 
	padding: 10px 0px; 
	color: #3c763d; 
	background: #dff0d8; 
	border: 1px solid #3c763d;
	border-radius: 5px; 
	text-align: center;
}
.error {
	color: #a94442; 
	background: #f2dede; 
	border: 1px solid #a94442; 
	margin-bottom: 20px;
}
.validation_errors p {
	text-align: left;
	margin-left: 10px;
}
.logged_in_info {
	text-align: right; 
	padding: 10px;
}

</style>
	<!-- admin navbar -->
	<?php // include('navbar.php') ?>

	<div class="container content">
		<!-- Left side menu -->
	
<div class="container">
	<div class="content" >
		<!-- Page wrapper -->
		<div class="post-wrapper">
			<!-- full post div -->
			<div class="full-post-div">
			<?php if ($post['published'] == false): ?>
				<h2 class="post-title">Sorry... This post has not been published</h2>
			<?php else: ?>
				<h2 class="post-title"><?php echo $post['title']; ?></h2>
				<div class="post-body-div">
					<?php echo html_entity_decode($post['body']); ?>
				</div>
			<?php endif ?>
			</div>
			<!-- // full post div -->
			
			<!-- comments section -->
			<!--  coming soon ...  -->
		</div>
		<!-- // Page wrapper -->

		<!-- post sidebar -->
		<div class="post-sidebar">
			<div class="card">
				<div class="card-header">
					<h2>Topics</h2>
				</div>
				<div class="card-content">
					<?php foreach ($topics as $topic): ?>
						<a 
							href="<?php echo 'filtered_posts.php?topic=' . $topic['id'] ?>">
							<?php echo $topic['name']; ?>
						</a> 
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<!-- // post sidebar -->
	</div>
</div>
<!-- // content -->

<?php // include( ROOT_PATH . '/includes/footer.php'); ?>