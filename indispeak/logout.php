
<?php
session_start();
session_unset();
session_destroy();
header("Location: home.php"); // or login.php if that’s your login page
exit();
?>