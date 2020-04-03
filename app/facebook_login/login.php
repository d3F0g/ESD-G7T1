<?php
require_once('config.php');

if(isset($_SESSION['access_token'])){
	header("Location: index.php");
	exit();
}


$redirectTo = "http://localhost/GitHub/ESD-G7T1/app/facebook_login/callback.php";
$data = ['email'];
$fullURL = $handler->getLoginUrl($redirectTo, $data);
?>

<!DOCTYPE html>
<html>
<body>
  <link rel="stylesheet" type="text/css" href="../../css/welcome.css">
    <div class="sign">
      <span class="fast-flicker">WELCOME&nbsp</span>B<span class="flicker">A</span>CK
    </div>
  <link rel="stylesheet" type="text/css" href="../../css/quote.css">
  <div class="container">
    <div class="typewriter">
     <h1>Let's find a Cafe!</h1>
    </div>
</div>
  </body>
  <link rel="stylesheet" type="text/css" href="../../css/landing.css">

        <form id="msform" method="post" action="login_logic.php">
        <fieldset>

            <input type="email" class="form-control" name="loginEmail" aria-describedby="emailHelp" placeholder="Enter email">

            <br>

            <input type="password" class="form-control" name="loginPassword" placeholder="Password">
          
          
          <input type="submit" value="Login" class="btn btn-primary action-button">
          <input type="button" onclick="window.location = '<?php echo $fullURL ?>'" value="Login with Facebook" class="btn btn-primary action-button">
          <input type="button" onclick="window.location = '../cafe_admin/owners_login.php'" value="Login as Admin" class="btn btn-primary action-button">
          <span style="color:red"><strong>
            <?php if (isset($_GET["error"])){
                  echo $_GET['error'];
                  } ?></strong></span> 
        </fieldset>
        </form>
      
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
        <script src="login_animation.js"></script>

        
        <button id="redirection" onclick="window.location='../login.html';" class="btncls">Sign Me Up!</button>
        
</html>]

