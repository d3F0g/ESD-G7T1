<!DOCTYPE html>

<?php
    $cafeID = $_GET["cafeid"];
    session_start();
?>

<html>
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

<title>Café Profile</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
</style>
<body class="w3-theme-l5">

<!-- Navbar -->
<div class="w3-top">
 <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
  <?php
  echo "<a href='landing.php?cafeid=" . $cafeID . "'class='w3-bar-item w3-button w3-padding-large w3-theme-d4'><i class='fa fa-home w3-margin-right'></i></a>";
  echo "<a href='view_reviews.php?cafeid=" .$cafeID . "'class='w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white' title='View Reviews'>View Reviews</a>";
  ?>
  <!-- <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Account Settings"><i class="fa fa-user"></i></a>
  <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Messages"><i class="fa fa-envelope"></i></a>
  <div class="w3-dropdown-hover w3-hide-small">
    <button class="w3-button w3-padding-large" title="Notifications"><i class="fa fa-bell"></i><span class="w3-badge w3-right w3-small w3-green">3</span></button>     
  </div> -->
  
  
  <a href="owners_logout.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" title="Log Out">Logout</a>
  
 </div>
</div>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Café Profile</a>
</div>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3">
      <!-- Profile -->
      <div class="w3-card w3-round w3-white">
        <div class="w3-container">
         <h4 class="w3-center">Café Profile</h4>
         <p class="w3-center"><img src="cafe.jpg" class="w3-circle" style="height:106px;width:145px" alt="Avatar"></p>
         <hr>
         <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> <?php echo $_SESSION['cafename'];?> </p>
         <p><i class="fa fa-map-marker fa-fw w3-margin-right w3-text-theme"></i> <?php echo $_SESSION['location'];?></p>
         <p><i class="fa fa-phone fa-fw w3-margin-right w3-text-theme"></i> <?php echo $_SESSION['cafephone'];?></p>
        </div>
      </div>
      <br>
      
      <!-- Accordion -->
      <div class="w3-card w3-round">
        <!-- <div class="w3-white">
          <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> My Groups</button>
          <div id="Demo1" class="w3-hide w3-container">
            <p>Some text..</p>
          </div>
          <button onclick="myFunction('Demo2')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-calendar-check-o fa-fw w3-margin-right"></i> My Events</button>
          <div id="Demo2" class="w3-hide w3-container">
            <p>Some other text..</p>
          </div>
          <button onclick="myFunction('Demo3')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> My Photos</button>
          <div id="Demo3" class="w3-hide w3-container">
         <div class="w3-row-padding">
         <br> -->
           <!-- <div class="w3-half">
             <img src="/w3images/lights.jpg" style="width:100%" class="w3-margin-bottom">
           </div>
           <div class="w3-half">
             <img src="/w3images/nature.jpg" style="width:100%" class="w3-margin-bottom">
           </div>
           <div class="w3-half">
             <img src="/w3images/mountains.jpg" style="width:100%" class="w3-margin-bottom">
           </div>
           <div class="w3-half">
             <img src="/w3images/forest.jpg" style="width:100%" class="w3-margin-bottom">
           </div>
           <div class="w3-half">
             <img src="/w3images/nature.jpg" style="width:100%" class="w3-margin-bottom">
           </div>
           <div class="w3-half">
             <img src="/w3images/snow.jpg" style="width:100%" class="w3-margin-bottom">
           </div> -->
         <!-- </div>
          </div>
        </div>       -->
      </div>
      <br>

    
    <!-- End Left Column -->
    </div>
    
    <!-- Middle Column -->
    <div class="w3-col m7">
    
      <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
                <img src="cafe.jpg" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
                <h4><?php echo $_SESSION['cafename']?></h4><br>
                <hr class="w3-clear">
                <div id="main-container" class="container">
                    <table id="bookingTable" class="table table-striped" border="1">
                        <thead class="thead-dark">
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer ID</th>
                                <th>Seat No</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>View Customer Info</th>
                            </tr>
                        </thead>
                    </table>   
                </div>
                <label id="error" class="text-danger"></label>
            </div>
          </div>
        </div>
      </div>
      

      
    <!-- End Middle Column -->
    </div>
    
    <!-- Right Column -->
    <!-- <div class="w3-col m2">
      <div class="w3-card w3-round w3-white w3-center">
        <div class="w3-container">
          <p>Upcoming Bookings:</p>
          <p><strong>Holiday</strong></p>
          <p>Friday 15:00</p>
          <p><button class="w3-button w3-block w3-theme-l4">Info</button></p>
        </div>
      </div>
      <br>
      
      
      
      
      <div class="w3-card w3-round w3-white w3-padding-32 w3-center">
        <p><i class="fa fa-bug w3-xxlarge"></i></p>
      </div> -->
      
    <!-- End Right Column -->
    <!-- </div> -->
    
  <!-- End Grid -->
  </div>
  
<!-- End Page Container -->
</div>
<br>

<!-- Footer -->
<footer class="w3-container w3-theme-d3 w3-padding-16">
  <h5>Café Profile for <?php echo $_SESSION['cafename']?></h5>
</footer>

<footer class="w3-container w3-theme-d5">
  <p>Powered by ESD G7T1</p>
</footer>
 
<script>
// Accordion
function myFunction(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += " w3-theme-d1";
  } else { 
    x.className = x.className.replace("w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" w3-theme-d1", "");
  }
}

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}

// Helper function to display error message
function showError(message) {
    // Hide the table and button in the event of error
    $('#bookingTable').hide();

    // Display an error under the main container
    $('#error').text(message);
    $('#error').show();
}

// anonymous async function 
// - using await requires the function that calls it to be async
$(async() => {           
    // Change serviceURL to your own
    var cafeid = <?php echo $_GET["cafeid"] ?> ;
    var serviceURL = "http://localhost:8000/api/v1/booking/cafe" + "/" + cafeid;
    try {
        const response =
          await fetch(
            serviceURL, { method: 'GET' }
        );
        const data = await response.json();
        if (response.ok) {
            console.log(data);
        }
        var bookings = data.bookings; //the arr is in data.books of the JSON data
        console.log(bookings);
        // array or array.length are false
        if (!bookings || !bookings.length) {
            showError('No bookings made. :(')
        } else {
            // for loop to setup all table rows with obtained book data
            var rows = "";
            var bookTime = "";
            for (const booking of bookings) {
                if(booking.block == 1) {
                    bookTime = "0800-0900";
                } 
                if(booking.block == 2) {
                    bookTime = "0900-1000";
                }
                if(booking.block == 3) {
                    bookTime = "1000-1100";
                }
                if(booking.block == 4) {
                    bookTime = "1100-1200";
                }
                if(booking.block == 5) {
                    bookTime = "1200-1300";
                }
                if(booking.block == 6) {
                    bookTime = "1300-1400";
                }
                if(booking.block == 7) {
                    bookTime = "1400-1500";
                }
                if(booking.block == 8) {
                    bookTime = "1500-1600";
                }
                if(booking.block == 9) {
                    bookTime = "1600-1700";
                }
                if(booking.block == 10) {
                    bookTime = "1700-1800";
                }
                if(booking.block == 11) {
                    bookTime = "1800-1900";
                }
                if(booking.block == 12) {
                    bookTime = "1900-2000";
                }
                if(booking.block == 13) {
                    bookTime = "2000-2100";
                }
                if(booking.block == 14) {
                    bookTime = "2100-2200";
                }
                if(booking.block == 15) {
                    bookTime = "2200-2300";
                }
                eachRow =
                    "<td style='text-align:center'>" + booking.ID + "</td>" +
                    "<td style='text-align:center'>" + booking.userID + "</td>" +
                    "<td style='text-align:center'>" + booking.seat_no + "</td>" +
                    "<td style='text-align:center'>" + booking.date+ "</td>" +
                    "<td style='text-align:center'>" + bookTime + "</td>" +
                    "<td style='text-align:center'>" + booking.status+ "</td>" + 
                    "<td style='text-align:center'>" + "<a href = 'viewuserinfo.php?userid=" + booking.userID + "&cafeid=" + cafeid + "'>User Info</a></td>";
                rows += "<tbody><tr>" + eachRow + "</tr></tbody>";
            }
            // add all the rows to the table
            $('#bookingTable').append(rows);
          }
    } catch (error) {
        // Errors when calling the service; such as network error, 
        // service offline, etc
        showError('There is a problem retrieving bookings data, please try again later.<br />'+error);
    } // error
});
</script>

</body>
</html> 
