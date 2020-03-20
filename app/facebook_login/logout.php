<?php 
session_start();
session_unset();
session_destroy();

header("location:../simple_UI.php");
exit();
?>