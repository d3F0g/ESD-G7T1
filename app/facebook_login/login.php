<?php
require_once('config.php');

if(isset($_SESSION['access_token'])){
	header("Location: index.php");
	exit();
}


$redirectTo = "http://localhost/ESD-G7T1/app/facebook_login/callback.php";
$data = ['email'];
$fullURL = $handler->getLoginUrl($redirectTo, $data);
?>

<!DOCTYPE html>
<html>
  <link rel="stylesheet" type="text/css" href="../../css/style.css">

        <form id="msform" method="post" action="login_logic.php">
        <fieldset>
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" name="loginEmail" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            <br><br>
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" name="loginPassword" placeholder="Password">
          
          
          <input type="submit" value="Login" class="btn btn-primary">
          <input type="button" onclick="window.location = '<?php echo $fullURL ?>'" value="Login with Facebook" class="btn btn-primary">
          <?php if (isset($_GET["error"])){
                echo $_GET['error'];
                } ?>  
        </fieldset>
        </form>
      
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
        <script src="login_animation.js"></script>
</html>

