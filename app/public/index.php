<?php
//code by: Thato Monchusi - www.distaxs.000webhostapp.com
//The Home Page. location Depends If User Is Logged in Our Logged Out
require_once 'header.php';
include('rating.php');
echo "<div class ='main'>";
if(!$loggedIn)die("Sign up or login. Login: user:Thato || Password: password123");

    if(isset($_GET['view'])){
        $view = sanitizeString($_GET['view']);
    
        if($view == $user_token) $name = "Your";
        else $name = "$view's";
    }    
showProfile($view);
echo "</div>";
require_once 'loadPosts.php';
//Adding New Links/Following Other users

 //Uncomment if you want the user's profile show below
 //showProfile($view);

 //Assign Followers And People Who Follow  Variables To An Array And Check Data From The Database
 $followers = array();
 $following = array();

 $result = queryMysql("SELECT * FROM friend_list   WHERE user_token = '$view'");
 $num = $result->num_rows;

 //An Loop That Displays 'Your Followers' Array
 for($j=0; $j < $num; ++$j){
     $row = $result->fetch_array(MYSQLI_ASSOC);
     $followers[$j] = $row['friend'];
 }
 
 $result = queryMysql("SELECT * FROM friend_list WHERE friend = '$view'");
 $num = $result->num_rows;

  //An Loop That Displays 'People Following' Array
 for($j=0; $j < $num; ++$j){
     $row = $result->fetch_array(MYSQLI_ASSOC);
     $following[$j] = $row['user_token'];
 }

 //Initiating Code In Order To View Mutual Friends Of Current User
 $mutual = array_intersect($followers, $following);
 $followers = array_diff($followers, $mutual);
 $follownig = array_diff($following, $mutual);
 $friends = FALSE;
?></span>

<!-----Articles and news feed srction----->
<?php 
function getPublishedPosts() {
	// use global $connection object in function
	global $connection;
	$sql = "SELECT * FROM blog_posts WHERE published=true";
	$result = mysqli_query($connection, $sql);

	// fetch all posts as an associative array called $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']); 
		array_push($final_posts, $post);
	}

	return $posts;
}


/* * * * * * * * * * * * * * *
* Receives a post id and
* Returns topic of the post
* * * * * * * * * * * * * * */
function getPostTopic($post_id){
	global $connection;
	$sql = "SELECT * FROM blog_topic WHERE id=
			(SELECT topic_id FROM blog_post_topic WHERE post_id=$post_id) LIMIT 1";
	$result = mysqli_query($connection, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic;
}
/* * * * * * * * * * * * * * * *
* Returns all posts under a topic
* * * * * * * * * * * * * * * * */
function getPublishedPostsByTopic($topic_id) {
	global $connection;
	$sql = "SELECT * FROM blog_posts ps 
			WHERE ps.id IN 
			(SELECT pt.post_id FROM blog_post_topic pt 
				WHERE pt.topic_id=$topic_id GROUP BY pt.post_id 
				HAVING COUNT(1) = 1)";
	$result = mysqli_query($connection, $sql);
	// fetch all posts as an associative array called $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']); 
		array_push($final_posts, $post);
	}
	return $final_posts;
}
/* * * * * * * * * * * * * * * *
* Returns topic name by topic id
* * * * * * * * * * * * * * * * */
function getTopicNameById($id)
{
	global $connection;
	$sql = "SELECT name FROM blog_topic WHERE id=$id";
	$result = mysqli_query($connection, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic['name'];
}

/* * * * * * * * * * * * * * *
* Returns a single post
* * * * * * * * * * * * * * */
function getPost($slug){
	global $connection;
	// Get single post slug
	$post_slug = $_GET['post-slug'];
	$sql = "SELECT * FROM blog_posts WHERE slug='$post_slug' AND published=true";
	$result = mysqli_query($connection, $sql);

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
function getAllTopics()
{
	global $connection;
	$sql = "SELECT * FROM blog_topic";
	$result = mysqli_query($connection, $sql);
	$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $topics;
}


// Post variables
$post_id = 0;
$isEditingPost = false;
$published = 0;
$title = "";
$post_slug = "";
$body = "";
$featured_image = "";
$post_topic = "";

//Retrieve all posts from database  
 //$posts = getPublishedPosts(); ?>
<div class="articleSection">
    <h4 align ="center">Article/News Feed</h4>
    <hr width="60% color = '#f8f8ff"/>
    <div class="articleContainer">
        <img src = "articles/ar1.jpg">
        <h3>Main Article Heading </h3>
        <hr width="60% color = '#f8f8ff"/>
        <p>This will be the preview text which will be accompanied by a image if its available...read more</p>
</div>

<div class="articleContainer">
	<div class="content"> <?php foreach ($posts as $post): ?>
	<div class="post" style="margin-left: 0px;">
		<img src="<?php echo 'blog/images/' . $post['image']; ?>" class="post_image" alt="image" style = "width:100%;">
        <!-- Added this if statement... -->
		<?php if (isset($post['topic']['name'])): ?>
			<a 
				href="<?php echo './filtered_posts.php?topic=' . $post['topic']['id'] ?>"
				class="btn category">
				<?php echo $post['topic']['name'] ?>
			</a>
		<?php endif ?>

			<div class="post_info">
				<h3><?php echo $post['title'] ?></h3>		
        <hr width="60% color = '#f8f8ff"/>
		<?php echo html_entity_decode($post['body']); ?>
				<div class="information">
					<span><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span>
		<a href="single_post.php?post-slug=<?php echo $post['slug']; ?> "style = 'font-size: 18px;'>
					<span class="read_more">Read more...</span>
				</div>
			</div>
		</a>
	</div>

<?php endforeach ?>   
</div>
</div>

<div class="marketingTools">
<h4 align ="center">Statistics</h4>
    <hr width="60%" color="#bad8e7"/>
<ul>
<li><a data-transition="slide" href="profile.php"><i class = "fa fa-eye" ></i> Profile visits</a> </li> <div class = 'counter'>0</div><br/><br/>
<li><a data-transition="slide" href="members.php"><i class = "fa fa-bar-chart" ></i> unique users reached</a></li> <div class = 'counter'>0</div><br/><br/>
<li ><a data-transition="slide" href="members.php"><i class = "fa fa-arrow-left" ></i> followers</a> 
<?php  
//If Followers  Exists Show The Text To Display And The Followers List
 if(sizeof($followers)){
    foreach($followers as $friend)
    echo "<div class = 'counter'>".count(array($friend))."</div>";
    $friends =TRUE;
}
else{
    echo "<div class = 'counter'>0</div>";
}
 ?></li> <br/><br/>
<li><a data-transition="slide" href='members.php'><i class = 'fa fa-arrow-right' ></i> following</a> 
<?php
if(sizeof($following)){
    foreach($following as $friend)
    echo "<div class = 'counter'>".count(array($friend))."</div>";
    $friends =TRUE;
}
else{
    echo "<div class = 'counter'>0</div>";
}
?>
</li> <br><br>
<li><a data-transition="slide" href='members.php'><i class = 'fa fa-arrows-h' ></i> follow backs</a>    
<?php 
if(sizeof($mutual)){
    foreach($mutual as $friend)
    echo "<div class = 'counter'>".count(array($friend))."</div>";
    $friends =TRUE;
}
else{
    echo "<div class = 'counter'>0</div>";
}
?>
</li> 
</ul>
 <h4 align ="center">Portfolio</h4>
    <hr width="60%" color='#bad8e7'/>
    <div class="imageGallery">
        <h6>Image Porfolio</h6>
<img src = "image_gallery_thumb/1.jpg" width = "100%"/> 
<img src = "image_gallery_thumb/2.jpg" width = "100%"/> 
<img src = "image_gallery_thumb/3.jpg" width = "100%"/> 
<img src = "image_gallery_thumb/4.jpg" width = "100%"/> 
<img src = "image_gallery_thumb/5.jpg" width = "100%"/> 
<img src = "image_gallery_thumb/6.jpg" width = "100%"/> 
<p>view more images</p>
    </div>
 <?php
echo '<div class = "ratings">';
	$rating = new Rating();
	$user_list = $rating->get_user($user_token);
	foreach($user_list as $user){
		$average = $rating->get_rating_average($user["user_token"]);
	?>		
		<div><span class="average"><?php printf('%.1f', $average); ?> <small>/ 5</small></span> <span class="rating-reviews"><a href="show_rating.php?user_token=<?php echo $user["user_token"]; ?>">Rating & Reviews</a></span></div>	

    <?php } ?>
    <br/>
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
</div><br/>
</div>	
</div>

<?php
echo "<div class = 'modal fade' role='dialog' aria-labelledby='center' tabindex='-1' id = 'openModal' aria-hidden='true'>";
echo "<div class = 'modal-dialog' role='document'>";
echo "<div class = 'modal-content'>";
echo "<div class = 'modal-header'>";
echo "<h2 class = 'modal-title' id='center'>Profile Overview</h2> ";
//echo "<a href = 'editProfile.php' data-transition='slidedown' class = 'button' style = 'margin-left:20px!important;'><img src = 'images/header_ico/edit.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
//box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/></a>";
echo "<button type ='button' class='close' data-dismiss='modal' aria-label='close'>";
echo "<span class = 'close' data-dismiss='modal'>&times;</span>";
echo "</button>";
echo "</div>";
echo "<div class = 'modal-body'>";
modalProfile($view);
echo "<h4 style = 'color:#0f597e;'><i>Your Posts</i></h4>";
echo "<hr/>";
$result = queryMysql("SELECT * FROM posts WHERE user_token = '$user_token'");
if($result->num_rows){
    $row=$result->fetch_array(MYSQLI_ASSOC);
    foreach($result as $row){
        echo $row['post_body'];
    }
}
echo "</div>";
echo "</div><br/>";
echo "</div>";
echo "</div>";
?>

<?php require_once 'footer.php'?>
</div>
</div>
</body>
</html>