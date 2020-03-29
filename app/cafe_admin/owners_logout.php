<?php 
session_start();
session_unset();
session_destroy();

header("location: owners_login.php");
exit();
?>