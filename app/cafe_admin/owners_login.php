<!DOCTYPE html>
<html>
<body>
  <link rel="stylesheet" type="text/css" href="../../css/welcome.css">
    <div class="sign">
      <span class="fast-flicker">WELCOME&nbsp</span><span class="flicker">A</span>DMIN
    </div>
  <link rel="stylesheet" type="text/css" href="../../css/quote.css">
  <div class="container">
    <div class="typewriter">
     <h1>View my bookings</h1>
    </div>
</div>
  </body>
  <link rel="stylesheet" type="text/css" href="../../css/landing.css">

        <form id="msform" method="post" action="owners_login_logic.php">
        <fieldset>

            <input type="email" class="form-control" name="loginEmail" aria-describedby="emailHelp" placeholder="Enter email">

            <br>

            <input type="password" class="form-control" name="loginPassword" placeholder="Password">
          
          
          <input type="submit" value="Login" class="btn btn-primary action-button">
          <span style="color:red"><strong>
            <?php if (isset($_GET["error"])){
                  echo $_GET['error'];
                  } ?></strong></span> 
        </fieldset>
        </form>
      
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
        <script src="login_animation.js"></script>

        
        <button id="redirection" onclick="window.location='owners_login.html';" class="btncls">Create an Account!</button>
        
</html>]

