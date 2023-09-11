<?php
//Destroys Current User Session And Logs Them Out
require_once 'header.php';

if(isset($_SESSION['user'])){
    destroySession();
    header("Location:index.php");
}

     else echo "You cannot logout when you havent logged in";
?>
<br><br/>
</div>
</body>
</html>