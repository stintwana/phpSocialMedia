<?php
session_start();
require_once 'functions.php'; 
$userstr = '(Guest)';

echo <<<_INIT
<!DOCTYPE html> 
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'> 
    <link rel='stylesheet' href='styles/jquery.mobile-1.4.5.min.css'>
    <link rel='stylesheet' href='styles/jquery-ui.theme.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='styles/styles.css' type='text/css'>
    <link rel='stylesheet' href='styles/bootstrap.min.css'>
    <script src='js/tsn.js'></script>
    <script src='js/jquery-2.2.4.min.js'></script>
    <script src='js/jquery.mobile-1.4.5.min.js'></script>
    <script src='js/jquery-ui.js'></script>
_INIT;
require_once 'functions.php'; 
$userstr = '(Guest)';

if(isset($_SESSION['user_token'])){
        $user_token = $_SESSION['user_token'];
        $loggedIn = TRUE;
        $userstr = "Konneck: $user_token";
    }
    else $loggedIn = FALSE;
    echo <<<_MAIN
<title>$userstr</title>
</head>
<body>
<div data-role='page'>
  <div data-role='content'>

_MAIN;
    
if($loggedIn) {
echo <<<_LOGGEDIN
    <div class='menu'> 
<h2 style = 'color:#f8f8ff;margin-left:20px'>KONNECK</h2> 
        <ul>
<li><a data-transition="slide" href='index.php?view=$user_token'>
<img src = 'images/header_ico/home_outline.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Home</a></li> 

<li><a href = '#openModal' data-transition="slidedown" data-toggle = 'modal'><img src = 'images/header_ico/login.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Profile</a></li>  

<li><a data-transition="slide" href='members.php'><img src = 'images/header_ico/konnecktions.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Konnektions</a></li> 

<li><a data-transition="slide" href='friends.php'><img src = 'images/header_ico/notification_outline.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Notifications</a></li>    

<li><a data-transition="slide" href='messages.php'><img src = 'images/header_ico/communicate_outline.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>kommunicate</a></li> 
            
<li><a data-transition="slide" href='logout.php'><img src = 'images/header_ico/logout_outline.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Logout</a></li> 

        </ul><div class = 'searchContainer'><form action='' method='post' class='search'>
<input type='text' placeholder = 'Search '  name='search_entered' value='' color:f8f8ff!important;' />
<button type='submit' name='submit' value='Search' style = 'box-shadow:none!important; padding:none!important;color:f8f8ff!important'> <i class='fa fa-search'></i></button>
</form></div>
    </div>
                
_LOGGEDIN;
}

else
{
echo <<<_GUEST
<div class='menu'>
<h2 style = 'color:#f8f8ff;margin-left:20px'>KONNECK</h2> 
    <ul>      
<li><a data-transition="slide" href='signup.php'><img src = 'images/header_ico/register.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Sign Up</a></li> 

       
<li><a data-transition="slide" href='login.php'><img src = 'images/header_ico/login.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Log In</a></li> 
    </ul>
</div>
_GUEST;
}

echo "<div class = 'main'>";
  echo "<h2>Edit Your Profile</h2>";

  $result = queryMysql("SELECT * FROM profiles WHERE user_token='$user_token'");
    
  if (isset($_POST['description']))
  { 
    $description = sanitizeString($_POST['description']);
    $description = preg_replace('/\s\s+/', ' ', $description);

    if ($result->num_rows){
     $sql = "UPDATE profiles SET description='$description' where user_token='$user_token'";
     if($connection->query($sql)===TRUE){
      echo "successful<br/>";
    }else{
      echo "error:".$connection->error;
    }
    }

    else{
    $sql =  "INSERT INTO profiles (profile_id, user_token, description) VALUES(NULL, '$user_token', '$description')";
      if($connection->query($sql)=== TRUE){
       echo "successful<br/>";
     }else{
       echo "error:".$connection->error;
     }
    
  } 
 }
  else
  {
    if ($result->num_rows)
    {
      $row  = $result->fetch_array(MYSQLI_ASSOC);
      $description = stripslashes($row['description']);
    }
    else $description = "";
  }

  $description = stripslashes(preg_replace('/\s\s+/', ' ', $description));

  if (isset($_FILES['image']['name']))
  {
    $saveto = "$user_token.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;

    switch($_FILES['image']['type'])
    {
      case "image/gif":   $src = imagecreatefromgif($saveto); break;
      case "image/jpeg":  // Both regular and progressive jpegs
      case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
      case "image/png":   $src = imagecreatefrompng($saveto); break;
      default:            $typeok = FALSE; break;
    }

    if ($typeok)
    {
      list($w, $h) = getimagesize($saveto);

      $max = 100;
      $tw  = $w;
      $th  = $h;

      if ($w > $h && $max < $w)
      {
        $th = $max / $w * $h;
        $tw = $max;
      }
      elseif ($h > $w && $max < $h)
      {
        $tw = $max / $h * $w;
        $th = $max;
      }
      elseif ($max < $w)
      {
        $tw = $th = $max;
      }

      $tmp = imagecreatetruecolor($tw, $th);
      imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
      imageconvolution($tmp, array(array(-1, -1, -1),
      array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
      imagejpeg($tmp, $saveto);
      imagedestroy($tmp);
      imagedestroy($src);
    }
  }

if(isset($_POST['full_names'])){
  $full_names = sanitizeString($_POST['full_names']);
  $contact_number = sanitizeString($_POST['contact_number']);
  $email_address = sanitizeString($_POST['email_address']);
  $area_location = sanitizeString($_POST['area_location']);
  
$sql = "UPDATE members SET user='$user', full_names='$full_names', contact_number='$contact_number', email_address='$email_address', area_location='$area_location' WHERE user_token='$user_token'";
 if($connection->query($sql)=== TRUE){
   echo "successful<br/>";
 }else{
   echo "error:".$connection->error;
 }
}

  echo "<form method='post'  action='editProfile.php' enctype='multipart/form-data'>";
  $result = queryMysql("SELECT * FROM members  WHERE user_token = '$user_token'");
  if ($result->num_rows){
      $row = $result->fetch_array(MYSQLI_ASSOC);
      echo "<b>".stripslashes($row['full_names']). "<br style = 'clear:left;'></b>";
      echo "@".stripslashes($row['user']). "<br style = 'clear:left;'>";        
}

  if(file_exists("$user_token.jpg")){
  echo "<img src ='$user_token.jpg' style = 'float:left;'><br/>Change Picture <br/><br/>";
}
  else{
  echo "<img src ='no_image.png' style = 'float:left; margin-top:10px;margin-bottom:10px;' class = 'imgThumb'><br/><br/><br/><br/><br/>";
}
  echo "<b>Change/Upload Image</b>";

//This is the UPDATE PROFILE FORM

  //echo "<input type = 'file' name = 'image' size='14'>";
?>
<style>
.profile-pic{
  color : transparent;
  transition: all .3s ease;
}
input{
  display: none;
}
img{
  position : absolute;
  object-fit: cover;
  width:165px ;
  height: 165px;
  box-shadow :rgb(0,0,0,.35) ;
  border-radius: 100px;
  z-index: 1;
}
.-label{
  cursor:pointer;
  height: 165px;
  width: 165px;
}


</style>

<div class = profile-pic>
  <label class = "-label" for = "file"> 
    <span class = "fa fa-camera"></span>
    <span>Change Image</span>
  </label>
  <input id = "file" type  = "file" onchange = "loadFile(event)"/>
  <img src = "no_image.png" id = "output" width = "200"/>
</div>
<?php

  $result = queryMysql("SELECT * FROM profiles  WHERE user_token = '$user_token'");

  if ($result->num_rows){
      $row = $result->fetch_array(MYSQLI_ASSOC);
      echo "<br>Bio:</b> "."<textarea rows = '5' name='description' >".stripslashes($row['description'])."</textarea>";
  
}
else{
  echo "<b>Bio:</b> "."<textarea rows = '5' name='description' placeholder='You havent written anything yet, please insert text here to add to your bio.'></textarea>";
}
  echo "<input type = 'submit' value='Update Profile'>";
  echo "</form><br/><br/>";
  echo "<hr/>";



//This is the EDIT DETAILS form
  echo "<form method='post' action='editProfile.php' enctype='multipart/form-data'>";
$result1 = queryMysql("SELECT * FROM members WHERE user_token ='$user_token'");
if($result1->num_rows){
  $row1 = $result1->fetch_array(MYSQLI_ASSOC);
  echo "<h2>Edit User Details</h2>";
  echo "<b>Full Names:</b> "."<textarea name='full_names' cols='5'>".stripslashes($row1['full_names'])."</textarea><br/>";
  echo "<b>Email:</b> "."<input type='email' name='email_address' value=".stripslashes($row1['email_address'])."><br/>";
  echo "<b>Contact Number:</b> "."<input type='text' name='contact_number' value=".stripslashes($row1['contact_number'])."><br/>";
  echo "<b>Location:</b> "."<textarea name='area_location' cols='5'>".stripslashes($row1['area_location'])."</textarea><br/>";
 // echo "Profession: Frelancer <br/>";

}
echo "<input type='submit' value='Save Profile'/>";
echo "</form>";
echo  "<br>";
?>


<?php


$msg = "";

if(isset($_POST['upload'])){
  $filename = $_FILES["uploadfile"]["name"];
  $tempname = $_FILES["uploadfile"]["tmp_name"];
  $folder = "user_images/".$filename;
  
  //Get all submitted data from the form
  $query = "INSERT INTO user_images VALUES  (NULL, '$user_token','$filename')";
  if($connection->query($query)===TRUE){
    echo "Image Uploaded Sucessfully";
  }
  else{
    echo "error: 
    ".$connection->error;
  }
  //Move uploaded image to folder: images
  if(move_uploaded_file($tempname, $folder)){
    $msg = "Image Uploaded Succesfully";
  }
  else{
    $msg = "Failed to upload image";
  }
}
$gallery_result = mysqli_query($connection, "SELECT * FROM user_images WHERE user_token = '".$_SESSION['user_token']."'");


?>
<?php
while($data = mysqli_fetch_array($gallery_result)){
  echo "<img src ='images/user_images/".$data['filename']."/>";
}
?>
<div id = "content">
  <form method = "POST" action = "" enctype = "multipart/form-data"> 
    <input type="file" name="uploadfile" value=""/>
    <div>
      <button type = "submit" name = "upload">
        Upload image
      </button>
    </div>
  </form>
</div>

</div>
</div>
</div>
</body>
</html>