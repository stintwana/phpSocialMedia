<?php
require_once 'header.php';

if(!$loggedIn)die("</div></body></html>");

echo "<div class='main'>";
?>


<?php

//Lets You view details of the user that you are viewing
if(isset($_GET['view'])){
    $view = sanitizeString($_GET['view']);
    if($view == $user) $name = "Your";
    else $name = "$view's";

    //View Current Users Messages
    //echo "<h2>$name Profile</h2>";
    checkUserFollow($user);
  showFriendProfile($view);
    die("</div></body></html>");
}

//Adding New Links/Following Other users
if(isset($_GET['add'])){
    $add = sanitizeString($_GET['add']); 
    $friend_token = $_SESSION['user_token'];
    $add_friend = sanitizeString($_SESSION['user']);   
    $result = queryMysql("SELECT * FROM friend_list WHERE user_token='$add' AND friend = '$user'");
    if(!$result->num_rows)
    queryMysql("INSERT INTO friend_list VALUES(NULL,'$add','$add_friend' , '$friend_token','$user')");
}

//Remove Any User From Your Friend List
elseif(isset($_GET['remove'])){
    $remove = sanitizeString($_GET['remove']);
    queryMysql("DELETE FROM friend_list WHERE user_token ='$remove' AND friend='$user'");
}
if(isset($_GET['view'])) $view = sanitizeString($_GET['view']);
 else $view = $user;
//Checks The Current And Displays The Users' Followers/Links
 if($view == $user){
     $name1 = $name2 = "Your";
     $name3 = "You are";
 }
 else{
     $name1 = "<a href ='members.php?view=$view'>$view</a>'s";
     $name2 = "$view's";
     $name3 = "$view is";
 }

 //Uncomment if you want the user's profile show below
 //showProfile($view);

 //Assign Followers And People Who Follow  Variables To An Array And Check Data From The Database
 $followers = array();
 $following = array();

 $result = queryMysql("SELECT * FROM friend_list WHERE user_token = '$view'");
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
     $following[$j] = $row['user'];
 }

 //Initiating Code In Order To View Mutual Friends Of Current User
 $mutual = array_intersect($followers, $following);
 $followers = array_diff($followers, $mutual);
 $follownig = array_diff($following, $mutual);
 $friends = FALSE;
 

 //If Mutual Friends Exists Show The Text To Display And The Mutual Friends List
 if(sizeof($mutual)){
     echo "<h4>$name2 follow backs </h4><br/>";
     foreach($mutual as $friend)
     echo "<ul>"."<li>".showPictureFollowers($friend)."<a href='members.php?view=$friend'>$friend</a>"."</li>"."</ul><hr/>";
     $friends =TRUE;
 }

  //If Followers  Exists Show The Text To Display And The Followers List
 if(sizeof($followers)){
    echo "<h4>$name2 followers</h4><br/>";
    foreach($followers as $friend)
    echo "<ul>"."<li>".showPictureFollowers($friend)."<a href='members.php?view=$friend'>$friend</a>"."</li>"."</ul><hr/>";
    $friends =TRUE;
}

  //If People You Following Exists Show The Text To Display And The People Following List
if(sizeof($following)){
    echo "<h4>$name3 following</h4><br/>";
    foreach($following as $friend)
    echo "<ul>"."<li>".showPictureFollowers($friend)."<a href='members.php?view=$friend'>$friend</a>"."</li>"."</ul><hr/>";
    $friends =TRUE;
}

if(!$friends) echo "<br/>No friends yet.<br/><br/>";

$result = queryMysql("SELECT * FROM members ORDER BY user");
$num = $result->num_rows;


//View Other/Suggested People/Users Using he Web App
echo "<h4>All Members</h4><ul>";
for($j = 0; $j < $num; ++$j){
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if($row['user'] == $user) continue;

    echo "<li><a data-transition='slide' href = 'members.php?view=".$row['user']."'>".$row['user']."</a>";
    $follow = "follow";

    $result1 = queryMysql("SELECT * FROM friend_list WHERE user_token='".$row['user_token']."' AND friend='$user'");
    $t1 = $result1->num_rows;
    $result1 = queryMysql("SELECT * FROM friend_list WHERE user_token='$user' AND friend='".$row['user_token']."'");
    $t2 =$result1->num_rows;


    //View People/Users In Common With Viewed User
    if(($t1 + $t2)>1) echo "&harr; following each other";
    elseif($t1) echo "&larr; you are following";
    elseif($t2){
        echo "&rarr; is following you";
        $follow = "follow back";
    }

    if(!$t1)  
    echo showPicture($row['user_token'])."<a class = 'btnFollow' href = 'members.php?add=".$row['user_token']."'>$follow</a>";
    else  
    echo showPicture($row['user_token'])."<a class = 'btnFollow' href = 'members.php?remove=".$row['user_token']."'>unfollow</a><br/><hr/>";
}

echo "</ul>";
?>
<?php


 ?>
</div>
</body>
</html>