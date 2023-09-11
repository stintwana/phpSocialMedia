<?php
require_once 'header.php';

if(!$loggedIn)die("</div></body></html>");

if(isset($_GET['view'])) $view= sanitizeString($_GET['view']);
else $view = $user;
    echo "<div class = 'main'>";
$error = $post_body= $associated_field ='';

if (isset($_POST['upload'])){
$user_token = sanitizeString($_SESSION['user_token']);
$user = sanitizeString($_POST['user']);
$associated_field = sanitizeString($_POST['associated_field']);
$post_body = sanitizeString($_POST['post_body']);
$user = $_SESSION['user'];
$user_token = $view;

if($post_body == "" || $associated_field ==""){
    $error = "<p style = 'color:#0f597e;'><b>Please insert associated field and fill the post area</b></p>";
}
else{

    $sql= "INSERT INTO `posts` (`post_id`, `user_token`, `user`, `associated_field`, `post_body`, `created`, `modified`)
     VALUES(NULL, '".$_SESSION['user_token']."', '$user', '$associated_field', '$post_body' , current_timestamp(), current_timestamp())";  
if($connection->query($sql)===TRUE){
    echo "Successful<br/>";
}
else{
    echo "error:".$connection->error;
}   
}

}

 echo   "
$error
    <h6>Choose post field</h6>";
echo "<form method ='post' action= 'posts.php'>
    <br/>";
    
echo "<div class = 'ui-field-contain'>";
echo "<input type = 'hidden' value = '$user_token' name = 'user_token'>";
echo "<input type = 'hidden' value = '$user' name = 'user'>";
echo "<label for= 'associated_field'>Select field</label>";
echo "<select name ='associated_field' value = '$associated_field' id='associated_field' data-mini='true'>";
        $interests_result = queryMysql("SELECT * FROM associated_fields ORDER BY associated_field ASC");
        $row_count = mysqli_num_rows($interests_result);
        if(isset($interests_result) && count(array($interests_result)) && $row_count > 0 ) : $i = 0;
            foreach($interests_result as $key => $interests){
            echo "<option value=$interests[associated_field]>".$interests['associated_field']."</option>";
            echo $interests['associated_field'];
        }
        endif;
echo "</select>";
echo "</div>";
echo "<h6>Type Post Body</h6>";
echo "<textarea name='post_body' value = '$post_body' class ='inputText' rows = '5'></textarea><br/><br/>";
echo  "<input type='submit' value='Upload Post' name='upload'>";
echo  "</form><br>";
?>
</div><br>
</body>
</html>