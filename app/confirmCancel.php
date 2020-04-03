<?php
session_start();
if(isset($_GET['bookingID'])) {
    $bookingID = $_GET['bookingID'];
}
$bookingID = json_encode($bookingID);

if(isset($_GET["fname"])) {
    $firstName = $_GET["fname"];
} 
if(isset($_SESSION['userData']['first_name'])) {
$firstName = $_SESSION['userData']['first_name'];
}
?>
<!DOCTYPE html>
<html>
 
<head>
    <style>
        #responsive-image {
            width: 100%;
            height: auto; 
        } 
        ul {
          list-style-type: none;
          margin: 0;
          padding: 0;
          overflow: hidden;
          background-color: #333;
        }
        
        li {
          float: left;
        }
        
        li a {
          display: block;
          color: white;
          text-align: center;
          padding: 14px 16px;
          text-decoration: none;
        }
        
        li a:hover {
          background-color: #111;
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    
    <title>Cancel Current Booking</title>
 
    <link rel="stylesheet" href="">
    <!--[if lt IE 9]>
      <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Bootstrap libraries -->
    <meta name="viewport" 
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" 
    crossorigin="anonymous">
 
    <!-- Latest compiled and minified JavaScript -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script 
    src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
    integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
    crossorigin="anonymous"></script>
    
    <script 
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
    integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
    crossorigin="anonymous"></script>
</head>

<body>
    <ul>
    <li><a class="active" href="simple_UI.php">Home</a></li>
    <li><a href="booking_page.php">View Bookings</a></li>
    <li style="float:right"><a class="active" href="facebook_login/logout.php">Logout</a></li>
    </ul>
    <div id="main-container" class="container">
        <h1 class="display-4">Confirm Cancel?</h1>
        <form id='updateBookingForm' >
            <button type="submit" class="btn btn-primary">Yes</button>
        </form>
    </div>

    <script>
        // Helper function to display error message
        function showError(message) {
            // Hide the table and button in the event of error
            $('#bookingTable').hide();
     
            // Display an error under the main container
            $('#main-container')
                .append("<label>"+message+"</label>");
        }
     
        // anonymous async function 
        // - using await requires the function that calls it to be async
        $("#updateBookingForm").submit(async(event) => {    
            event.preventDefault();       
            // Change serviceURL to your own
            var bookingID = <?php echo $bookingID; ?>;
            var serviceURL = "http://127.0.0.1:5000/booking/update" + "/";
            serviceURL += bookingID;
            var homeURL = "simple_UI.php?msg=Booking%20Cancelled!";
            try {
                console.log("Hello 1");
                const response =
                   await fetch(
                    serviceURL, { method: 'PUT' }
                );
                console.log("Hello 2");
                // const data = await response.json();
                console.log("Hello 3");
                if (response.ok) {
                    console.log("Hello 4");
                    window.location.replace(homeURL);
                    return false;
                }
                
            // }
            } catch (error) {
                // Errors when calling the service; such as network error, 
                // service offline, etc
                showError('There is a problem retrieving booking data, please try again later.<br />'+error);

                
           
            } // error
        });

        
    </script>
</body>
</html>