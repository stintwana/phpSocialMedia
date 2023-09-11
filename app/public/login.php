<?php
//Filters The String and checks if the user exist in the database before logging in
require_once "header.php";
echo "<div class=main>";
$error = $user = $pass = "";

if (isset($_POST['user'])){
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    $salt1 = "pl$@";
    $salt2 = "@*^g";
    $token = hash('ripemd128',"$salt1$pass$salt2");
    $user_token = hash('ripemd128',"$salt1$user$salt2");

    if($user == "" || $pass == ""){
        $error = "Not all fields where entered<br>";
    }
    else{
        $result = queryMysql("SELECT user_token,pass FROM members Where user_token='$user_token' AND pass = '$token'");

        if($result->num_rows ==0){
            $error = "<span class='error'>Username/Pass is false</span><br/>";
        }
        else{
            $_SESSION['user_token']=$user_token;
            $_SESSION['user']=$user;
         echo "<script>window.location.href='index.php?view=$user_token'</script>";
        }
    }
}
//The Login Form
echo <<<_END
<form method = "post" action = "login.php">$error
<h1 align = 'center '>KONNECK</h1>
<h2>Please enter login details</h2>
<div class = "form-group">
<input class = "form-control" type = "text" name = 'user' value = '$user' maxlength ='16' placeholder='username or email'><br/>
</div>
<div class = "form-group">
<input class = "form-control" type = "password" name = 'pass' value = '$pass' maxlength = '16' placeholder='password'>
</div><br>
_END;
?>
<div data-role='fieldcontain'>
<label><b>Submit</b></label>
<input data-transition='slide' type = "submit" value = "login">
</div>

</form></div>
</body>
</html>