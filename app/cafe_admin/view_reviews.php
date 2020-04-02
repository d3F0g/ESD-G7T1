<?php                      
  if(!session_id()) {
    session_start();
  }
  $cafeID = $_GET["cafeid"];
  $cafes_locations = [];
  $dsn = "mysql:host=localhost;dbname=esd";
  $pdo = new PDO($dsn, "root", "root");
  $sql = 'select * from cafes';
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  while($row = $stmt->fetch()) { 
    if(!(in_array($row["location"],$cafes_locations))) {
        $cafes_locations[] = $row["location"];
    }
  }
  $stmt = null;
  $pdo = null;
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
 
    <title>Cafe</title>
 
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

    </br>

    <title>View All Reviews</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>


          
        <body class="w3-theme-l5">
            <!-- Navbar -->
            <div class="w3-top">
            <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
            <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
            <?php
            echo "<a href='landing.php?cafeid=" . $cafeID . "'class='w3-bar-item w3-button w3-padding-large w3-theme-d4'><i class='fa fa-home w3-margin-right'></i></a>";
            echo "<a href='view_reviews.php?cafeid=" . $cafeID . "'class='w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white' title='View Reviews'>View Reviews</a>";
            ?>
            <!-- <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Account Settings"><i class="fa fa-user"></i></a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Messages"><i class="fa fa-envelope"></i></a>
            <div class="w3-dropdown-hover w3-hide-small">
                <button class="w3-button w3-padding-large" title="Notifications"><i class="fa fa-bell"></i><span class="w3-badge w3-right w3-small w3-green">3</span></button>     
            </div> -->
            
            
            <a href="owners_logout.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" title="Log Out">Logout</a>
            
            </div>
            </div>
            <br>


            <div id="main-container" class="container">
            <h1 class="display-4">All reviews for <?php echo $_SESSION["cafename"]?></h1>
            <table id="reviewsTable" class="table table-striped" border="1">
                <thead class="thead-dark">
                    <tr>
                        <th>Review ID</th>
                        <th>User ID</th>
                        <th>Cafe ID</th>
                        <th>Booking ID</th>
                        <th>Content</th>
                        <th>Stars Awarded</th>
                    </tr>
                </thead>
            </table>
            <label id="error" class="text-danger"></label>
            </div>

            <script>
                // Helper function to display error message
                function showError(message) {
                    // Hide the table and button in the event of error
                    $('#reviewsTable').hide();
             
                    // Display an error under the main container
                    $('#error').text(message);
                    $('#error').show();
                }
        
             
                // anonymous async function 
                // - using await requires the function that calls it to be async
                $(async() => {           
                    // Change serviceURL to your own
                    var serviceURL = "http://127.0.0.1:5001/reviews/cafe/"+<?php echo $_SESSION['cafeID'] ?>;
             
                    try {
                        const response =
                         await fetch(
                           serviceURL, { method: 'GET' }
                        );
                        const data = await response.json();
                        if (response.ok) {
                            console.log(data);
                        }
                        var reviews = data.reviews; //the arr is in data.books of the JSON data
                        console.log(reviews);
                        // array or array.length are false
                        if (!reviews || !reviews.length) {
                            showError('No reviews made. :(')
                        } else {
                            // for loop to setup all table rows with obtained book data
                            var rows = "";
                            for (const review of reviews) {

                                eachRow =
                                    "<td>" + review.ID + "</td>" +
                                    "<td>" + review.userID + "</td>" +
                                    "<td>" + review.cafeID + "</td>" +
                                    "<td>" + review.bookingID + "</td>" +
                                    "<td>" + review.content + "</td>" +
                                    "<td>" + review.stars + "</td>" ;
                                rows += "<tbody><tr>" + eachRow + "</tr></tbody>";
                            }
                            // add all the rows to the table
                            $('#reviewsTable').append(rows);
                        }
                    } catch (error) {
                        // Errors when calling the service; such as network error, 
                        // service offline, etc
                        showError('There is a problem retrieving cafes data, please try again later.<br />'+error);
                    } // error
                });

              
            </script>
 
                        
        </body>
        </html>