<?php
require_once 'header.php';
//AJAX call to That checks if the user exits in the database, If Exists Or Not The the User IS notified

echo <<<_END
<script>
function checkUser(user){
if(user.value==''){
    $('#used').html('&nbsp;')
    return
}
$.post
(
'checkUser.php',
{user : user.value },
function(data)
{
    $('#used').html(data)
}
)
}
</script>
_END;

$error = $user = $full_names = $date_of_birth = $gender = $contact_number = $email_address = $area_location = $pass = "";
if(isset($_SESSION['user'])) destroySession();

if (isset($_POST['user'])){
    $user = sanitizeString($_POST['user']);
    $full_names = sanitizeString($_POST['full_names']);
    $date_of_birth = sanitizeString($_POST['date_of_birth']);
    $gender = sanitizeString($_POST['radio-choice-h-2']);
    $contact_number = sanitizeString($_POST['contact_number']);
    $email_address = sanitizeString($_POST['email_address']);
    $area_location = sanitizeString($_POST['area_location']);
    $pass = sanitizeString($_POST['pass']);
    $salt1 = "pl$@";
    $salt2 = "@*^g";
    $token = hash('ripemd128',"$salt1$pass$salt2");
    $user_token = hash('ripemd128',"$salt1$user$salt2");

    if($user == "" || $full_names == "" || $date_of_birth == "" || $gender == "" || $contact_number == ""|| $email_address ==""|| $area_location == "" || $pass == "" ){
        $error = "Not all fields where entered";
    }
    else{
        $result = queryMysql("SELECT * FROM members WHERE user='$user'");

        if($result->num_rows ){
            $error = "This user already exists<br><br>";
        }
        else{
            queryMysql("INSERT INTO members ( `user_token`, `user`, `full_names`, `pass`, `gender`, `date_of_birth`, `contact_number`, `email_address`, `area_location`, `created`)
            VALUES('$user_token','$user', '$full_names', '$token', '$gender', '$date_of_birth', '$contact_number', '$email_address', '$area_location', CURRENT_DATE())");
            echo "<script>window.location.href='index.php?view=$view'</script>";
        }
    }
}
echo <<<_END
<div class='main'>
<h1 align = 'center '>KONNECK</h1>
<h2>Please Provide Information</h2>
<form method = "post" action = "signUp.php"> $error

<div class = "form-group">
<label>Username</label>
<input class = "form-control"  type = "text" maxlegth='16' name = 'user' value = '$user' placeholder='choose username' onBlur ='checkUser(this)'>
<label></label><div id='used'>&nbsp;</div>
</div>

<div class = "form-group">
<label>Full Names</label>
<input class = "form-control" type = "text"  name = 'full_names' value = '$full_names' placeholder='Full Names'>
</div>

<div class = "form-group">
<label>Birth Date</label>
<input class = "form-control" type = "date" maxlegth='16' name = 'date_of_birth' value = '$date_of_birth' placeholder='yyyy/mm/dd'>
</div>

<div class = "form-group" >
<label>Gender</label>
<fieldset data-role = 'controlgroup' data-type = 'horizontal'>
<input type = 'radio' name = 'radio-choice-h-2' id='radio-choice-h-2a' value = 'male' checked = 'checked' />
<label for = 'radio-choice-h-2a'>male</label>
<input type = 'radio' name = 'radio-choice-h-2' id='radio-choice-h-2b' value = 'female'  />
<label for = 'radio-choice-h-2b'>female</label>
<input type = 'radio' name = 'radio-choice-h-2' id='radio-choice-h-2c' value = 'they'  />
<label for = 'radio-choice-h-2c'>they</label>
</fieldset>
</div>

<div class = "form-group">
<label>Contact Number</label>
<input class = "form-control" type = "tel" maxlegth='16' name = 'contact_number' value = '$contact_number' placeholder='Contact Number'>
</div>

<div class = "form-group">
<label>E-mail</label>
<input class = "form-control" type = "email" maxlegth='16' name = 'email_address' value = '$email_address' placeholder='Email Address'>
</div>

<div class = "form-group">
<label>Location</label>
<input class = "form-control" type = "text"  name = 'area_location' value = '$area_location' placeholder='Your Location'>
</div>

<div class = "form-group">
<label>password</label>
<input class = "form-control" type = 'password' name = 'pass' value = '$pass' maxlength = '16' placeholder='choose password'><br>
</div>

<div class = "form-group">
<label>register</label>
<input class = "form-control" data-transition='slide' type = "submit" value = "submit">
</div>
</form></div>
</body>
</html>
_END;
?>