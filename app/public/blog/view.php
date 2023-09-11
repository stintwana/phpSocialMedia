<?php
session_start();
require_once 'header.php';

$heading = $_GET['heading'];
$article = $_GET['article'];

echo "<div class='article'>";
echo $heading."<br/>";
echo $article;
?>

</div>
</body
</html>