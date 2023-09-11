<?php
require_once 'functions.php';
$result = queryMysql("SELECT * FROM posts");
if($result->num_rows>0){
while($post = $result->fetch_assoc()){
?>
<div class="post-card">
<div class="post-body">
<h5 class="username" style = 'display:flex;'>
<?php echo "<a href = members.php?view=$post[user]>"?>
<?php echo showPicture($post['user_token'])?>
</a>
<p style = 'margin-top:10px;color:#0f597e;font-weight:bolder;'> 
<?php echo "<a href = members.php?view=$post[user]>"?>
<?php echo $post['user']  ?>
</a>
</p>
</h5>
<p style = "color:#555;font-size:10pt;";><?php echo $post['associated_field'] ?> &middot; <?php echo $post['created'] ?> </p>
<p class="postBody"><?php echo $post['post_body'] ?></p>
<hr/>
<div class="activityButtons">
<a class="upvote" ><i class="fa fa-thumbs-up"></i> 0</a>
<a class="comment"><i class="fa fa-comments-o"></i> 0</a>
<a class="share"><i class="fa fa-share-alt"></i> 0</a>
</div>
</div>
</div>
 <?php } }else{ ?>
 <div class="post-card">
<div class="post-body">
no Posts yet
</div>
</div>
</div>
<p>No Posts Yet</p>
<?php } ?>