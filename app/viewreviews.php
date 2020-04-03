<?php
    $cafeID = $_GET["cafeid"]
?>

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
 
    <title>Cafe Reviews</title>
 
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

    

    <title>Cafe Reviews</title>
    <link rel="stylesheet" href="http://bootswatch.com/darkly/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

    <body>
        
          <body>

          <ul>
                            <li><a class="active" href="simple_UI.php">Home</a></li>
                            <li><a href="booking_page.php">Check Booking</a></li>
                            <li style="float:right"><a class="active" href="facebook_login/logout.php">Logout</a></li>
                          </ul>

                            <div id="main-container" class="container">
                            <h1 class="display-4">Reviews Listing</h1>
                            <table id="reviewsTable" class="table table-striped" border="1">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Cafe ID</th>
                                        <th>Booking ID</th>
                                        <th>Comments</th>
                                        <th>Stars</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <label id="error" class="text-danger"></label>
        
            <script>
                // Helper function to display error message
                function showError(message) {
                    // Hide the table and button in the event of error
                    $('#reviewTable').hide();
             
                    // Display an error under the main container
                    $('#error').text(message);
                    $('#error').show();
                }
        
             
                // anonymous async function 
                // - using await requires the function that calls it to be async
                $(async() => {           
                    // Change serviceURL to your own
                    var cafeid = <?php echo $_GET["cafeid"] ?> ;
                    var serviceURL = "http://127.0.0.1:5002/reviews/cafe" + "/" + cafeid;
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
                            showError('Reviews list empty or undefined.')
                        } else {
                            // for loop to setup all table rows with obtained book data
                            var rows = "";
                            for (const review of reviews) {

                                eachRow =
                                    "<td>" + review.cafeID + "</td>" +
                                    "<td>" + review.bookingID + "</td>" +
                                    "<td>" + review.content + "</td>" +
                                    "<td>" + review.stars + "</td>"; 
                                rows += "<tbody><tr>" + eachRow + "</tr></tbody>";
                            }
                            // add all the rows to the table
                            $('#reviewsTable').append(rows);
                        }
                    } catch (error) {
                        // Errors when calling the service; such as network error, 
                        // service offline, etc
                        showError('There is a problem retrieving reviews data, please try again later.<br />'+error);
                    } // error
                });

                
            </script>
            
                        
        </body>
        </html>