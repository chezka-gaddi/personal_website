<?php
session_start();
$_SESSION["name"] = "trial";
echo $_SESSION;
?>

<html>
  <a href="test2.php">Next</a>
</html>
