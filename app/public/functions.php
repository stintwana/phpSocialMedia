<?php

$dbHost = 'konneck_mysql_1';
$dbName = 'konnec';
$dbUserName='root';
$dbPassword = 'Stintw@n@66002919';
$appName = 'konnec';

 $connection = new mysqli($dbHost,$dbUserName,$dbPassword,$dbName);
if($connection->connect_error) die("Connection error :".$connection->connect_error);

$userstr = '(Guest)';

if(isset($_SESSION['user_token'])){
        $user_token = $_SESSION['user_token'];
        $user = $_SESSION['user'];
        $loggedIn = TRUE;
        $userstr = "Konneck: $user_token";
    }
    else {
        $loggedIn = FALSE;
    }
date_default_timezone_set("Asia/kolkata");

function fetch_user_last_activity($user_token, $connection){
$query =  queryMysql("SELECT * FROM online_status WHERE user_token = '$user_token' ORDER BY last_activity DESC LIMIT 1 ");
if($query->num_rows){
  $row = $query->fetch_array(MYSQLI_ASSOC);
    foreach($query as $row){
        return $row['last_activity'];
    }
}
}

function fetch_user_chat_history($from_user_token, $to_user_token, $connection){
$query =queryMysql( " SELECT * FROM chat_message
WHERE (from_user_token = '".$from_user_token."' AND to_user_token= '".$to_user_token."')
OR (from_user_token = '".$to_user_token."'
AND to_user_token = '".$from_user_token."')
ORDER BY timestamp DESC
");

if($query->num_rows){
    $row = $query->fetch_array(MYSQLI_ASSOC);
    $output = '<ul class="list-unstyled">';
      foreach($query as $row){
        $user_name = '';
        if($row['from_user_token']==$from_user_token){
            $user_name = '<b style ="right:0;">You</b>';
        }
        else{
            $user_name = '<b style = "color:#0f597e;">'.get_user_name($row['from_user_token'],$connection).'</b>';
        }
        $output .='
        <li style="border-bottom:1px dotted #CCC">
        <p>'.$user_name.'-'.$row["chat_message"].'
        <div align="right">
        -<small><em>'.$row['timestamp'].'</em></small>
        </div>
        </p>
        </li>
        ';
      }
      $output .="</ul>";
      $query = "UPDATE chat_message SET status = '0' WHERE from_user_token = '".$to_user_token."' AND to_user_token = '".$from_user_token."'
      AND status = '1' ";

      $statement = $connection->prepare($query);
      $statement->execute();
      return $output;
  }
}

function get_user_name($user_token, $connection){
    $query = queryMysql("SELECT user FROM members WHERE user_token = '$user_token'");
    if($query->num_rows){
        $row = $query->fetch_array(MYSQLI_ASSOC);
          foreach($query as $row){
              return $row['user'];
          }
      }
}

function count_unseen_messages($from_user_token, $to_user_token, $connection){

    $query = queryMysql("SELECT * FROM chat_message WHERE from_user_token='$from_user_token' AND to_user_token='$to_user_token' AND status='1'");
    $count = mysqli_num_rows($query);
    $output = '';
    if($count > 0){
        $output  = '<span class = "label label-success">'.$count."</span>";
    }
    else{
        $output =  "<span class = 'label label-success'>0</span>";
    }
    return $output;

}




    

//Function That Allows You To Seamlessley Create A New Table To The Database
Function createTable($name, $query){
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists";
}

//Called To Send Queries To Any Table
Function queryMysql($query){
    global $connection;
    $result = $connection -> query($query);
    if(!$result) die($connection->connect_error);
    return $result;
}

//Logout Function To Logout Users
Function destroySession(){
    $_SESSION = array();
    if (session_id() !="" || isset($_COOKIE[session_name()]))
    setcookie(session_name(),'',time()-2592000, '/');
}

//Sanitize String Variables, We Always Have To Be Safe!
Function sanitizeString($var){
global $connection;
$var = strip_tags($var);
$var = htmlentities($var);
$var = stripslashes($var);
return $connection->real_escape_string($var);
}


Function modalProfile($user_token){
    $result = queryMysql("SELECT * FROM members  WHERE user_token = '$user_token'");
    if ($result->num_rows){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<b>".stripslashes($row['full_names']). "<br style = 'clear:left;'>"."</b>";
        echo "@".stripslashes($row['user']). "<br style = 'clear:left;'><br>";
   
    }


    
    if(file_exists("$user_token.jpg"))
    echo "<img src ='$user_token.jpg' style = 'float:left; '> <br/><br/>";
    else
    echo "<img src ='no_image.png' style = 'float:left;' class = 'imgThumb'> <br/><br/>";


    $result = queryMysql("SELECT * FROM profiles  WHERE user_token = '$user_token'");
    if ($result->num_rows){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo stripslashes($row['description']). "<br style = 'clear:left;'><br>";
    }else{
        echo "Nothing on your bio."."<br style = 'clear:left'><br>";
    }
    $result1 = queryMysql("SELECT * FROM members WHERE user_token ='$user_token'");
    if($result1->num_rows){
        $row1 = $result1->fetch_array(MYSQLI_ASSOC);
        echo "<b><i class='fa fa-envelope'></i> Email:</b> ".stripslashes($row1['email_address'])."<br/>";
        echo "<b><i class='fa fa-phone'></i> Contact Number:</b> ".stripslashes($row1['contact_number'])."<br/>";
        echo "<b><i class='fa fa-home'></i> Location:</b> ".stripslashes($row1['area_location'])."<hr/>";
       // echo "Profession: Frelancer <br/>";
    }
//Lets You view details of the user that you are viewing
if(isset($_GET['view'])){
    $view = sanitizeString($_GET['view']);

    if($view == $user_token) $name = "Your";
    else $name = "$view's";
}
        echo "<h4 style = 'color:#0f597e'><i>Interests</i></h4>";
        echo "<hr/>";
        $result2 = queryMysql("SELECT DISTINCT * FROM users_interests where user_token = '$user_token'");
        $row_count = mysqli_num_rows($result2);
        if(isset($result2) && count(array($result2)) && $row_count > 0 ) : $i = 0;
        
        
            foreach($result2 as $key => $interests){
            echo "<div class = 'interestField'>";
            echo $interests['interest_name']." <i class='fa fa-times-circle' aria-hidden='true' style='font-size:12pt' ></i>";
        echo "</div>";}
        endif; "</div>";
        echo "<hr/>";

}

//Called To Display Current User Anywhere
Function showProfile($user_token){
    $result = queryMysql("SELECT * FROM members  WHERE user_token = '$user_token'");
    if ($result->num_rows){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<b>".stripslashes($row['full_names']). "<br style = 'clear:left;'>"."</b>";
        echo "@".stripslashes($row['user']). "<br style = 'clear:left;'><br>";
   
    }

    if(file_exists("$user_token.jpg"))
    echo "<img src ='$user_token.jpg' style = 'float:left; '> <br/><br/>";
    else
    echo "<img src ='no_image.png' style = 'float:left;' class = 'imgThumb'> <br/><br/>";


    $result = queryMysql("SELECT * FROM profiles  WHERE user_token = '$user_token'");
    if ($result->num_rows){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo stripslashes("<div class = 'bio_bubble'>"."<p>".$row['description'])."</p>"."</div>". "<br style = 'clear:left;'><br>";  
    }
    else{

        echo "<div class='no_bio_bubble'><p>Nothing on bio...</p></div><br/>";
    }         
//Lets You view details of the user that you are viewing
if(isset($_GET['view'])){
    $view = sanitizeString($_GET['view']);

    if($view == $user_token) $name = "Your";
    else $name = "$view's";
}
        echo "
        <a  href= 'editProfile.php' class='button'  style = 'padding-left:20px!important;'><img src = 'images/header_ico/edit.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
        box-shadow: none!important;-moz-box-shadow: none!i  mportant;-webkit-box-shadow:none!important;padding:0!important'></a> 
        <a class='button' href='members.php?view=$view'  style = 'padding-left:20px!important;'><img src = 'images/header_ico/konnecktions.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
        box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'></a>
        <a class='button' href='posts.php?view=$view'  style = 'padding-left:20px!important;'><img src = 'images/header_ico/post.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
        box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'></a>"."<br/><br/>";
        
        echo "<h4>Interests</h4><br>";
        $result2 = queryMysql("SELECT DISTINCT * FROM users_interests where user_token = '$user_token'");
        $row_count = mysqli_num_rows($result2);
        if(isset($result2) && count(array($result2)) && $row_count > 0 ) : $i = 0;
        
        
            foreach($result2 as $key => $interests){
            echo "<div class = 'interestField'>";
            echo" <a href = '' style = 'color:#f1f1ff;'>".$interests['interest_name']." <i class='fa fa-times-circle' aria-hidden='true' style='font-size:12pt' ></i>"."</a>";
        echo "</div>";}
        endif; "</div>";

 
}


Function showFriendProfile($view){    
    if(isset($_GET['view'])){
        $view = sanitizeString($_GET['view']);
    
        if($view == $view) $name = "Your";
        else $name = "$view's";

    $result = queryMysql("SELECT * FROM members  WHERE user = '$view'");
    if ($result->num_rows){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<b>".stripslashes($row['full_names']). "<br style = 'clear:left;'></b>";
        echo "@".stripslashes($row['user']). "<br style = 'clear:left;'><br>";
   
    
    if(file_exists($row['user_token'].".jpg"))
    echo "<img src ='".$row['user_token'].".jpg' style = 'float:left; '> <br/><br/>";
    else
    echo "<img src ='no_image.png' style = 'float:left;' class = 'imgThumb'> <br/><br/>";
}
    $result = queryMysql("SELECT * FROM profiles  WHERE user_token = '".$row['user_token']."'");

    if ($result->num_rows){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo stripslashes("<div class = 'bio_bubble'>"."<p>".$row['description'])."</p>"."</div>". "<br style = 'clear:left;'><br/>";
}
else{
    echo "<div class = 'no_bio_bubble'><p>Nothing on bio</p></div><br/>";
}
  $result1 = queryMysql("SELECT * FROM members WHERE user ='$view'");
  if($result1->num_rows){
      $row1 = $result1->fetch_array(MYSQLI_ASSOC); 
      echo "<b><i class='fa fa-envelope'></i> Email:</b> ".stripslashes($row1['email_address'])."<br/>";
      echo "<b><i class='fa fa-phone'></i> Contact Number:</b> ".stripslashes($row1['contact_number'])."<br/>";
      echo "<b><i class='fa fa-home'></i> Location:</b> ".stripslashes($row1['area_location'])."<br/>";
      //echo "Profession: Frelancer <br/>";
  }
echo "</div>";
echo "<div class='post-card'>";
  $result2 = queryMysql("SELECT * FROM posts WHERE user='$view'");
  if($result2->num_rows){
      $row3 = $result2->fetch_array(MYSQLI_ASSOC);
      echo $row3['post_body'];
      
echo '<div class="activityButtons">
     <a class="upvote" ><i class="fa fa-thumbs-up"></i></a>
     <a class="comment"><i class="fa fa-comments-o"></i></a>
     <a class="share"><i class="fa fa-share-alt"></i></a>
     </div>';
  }
}    
}
Function editProfile($user_token){}

Function showPicture($user_token){
    if(file_exists("$user_token.jpg"))
    echo "<img src ='$user_token.jpg' style = 'float:left; width:50px;height:50px;' class = 'imgThumb'><br/> <br/>";
else
echo "<img src ='no_image.png' style = 'float:left; width:50px;height:50px;' class = 'imgThumb'><br/><br/>";
}

Function showPictureFollowers($user_token){
    if(file_exists("$user_token.jpg"))
    echo "<img src ='$user_token.jpg' style = 'float:left; width:50px;height:50px;' class = 'imgThumb'>";
else
echo "<img src ='no_image.png' style = 'float:left; width:50px;height:50px;' class = 'imgThumb'>";
}

Function url_clean($String)
{
    return str_replace('_',' ',$String); 
}

Function checkUserFollow($user){

}

function showFollowerArray($user){
    $followersArray = queryMysql("SELECT * FROM ");
}


?>