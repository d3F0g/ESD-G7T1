<?php                      
  if(!session_id()) {
    session_start();
  }
  if(isset($_GET["fname"])) {
    $firstName = $_GET["fname"];
  } 
  if(isset($_SESSION['userData']['first_name'])) {
    $firstName = $_SESSION['userData']['first_name'];
  }
  
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

  if(isset($_GET["msg"])) {
    $msg = $_GET["msg"];
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

    

    <title>Cafe Booking UI</title>
    <link rel="stylesheet" href="http://bootswatch.com/darkly/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

    <body>
        
          <body>

          <ul>
                            <li><a class="active" href="simple_UI.php">Home</a></li>
                            <li><a href="booking_page.php">Check Bookings</a></li>
                            <li style="float:right"><a class="active" href="facebook_login/logout.php">Logout</a></li>
                          </ul>
                    
                            <h1 style="text-align:center; font-family: Times New Roman, Times, serif; font-size:50px; font-style:italic">Hello, <?php echo $firstName;?> !</h1>
                            <?php if(isset($msg)) { echo "<h1 style='text-align:center; font-family: Times New Roman, Times, serif; font-size:50px; font-style:italic'> " . $msg . "</h1>"; }?>
                            
                            <header class="w3-display-container w3-content w3-hide-small" style="max-width:1500px">
                              <img class="w3-image" src="white.jpg" alt="cafe" id="responsive-image" style="max-height:350px">
                              
                              <div class="w3-display-middle" style="width:90%">
                                
                                <!-- Tabs -->
                                <div id="Search" class="w3-container w3-white w3-padding-16 myLink">
                                <form id = "searchCafeForm">
                                  <h3>Search with us</h3>
                                  <div class="w3-row-padding" style="margin:0 -16px;">
                                    <div class="w3-half">
                                      <label>Price Range</label>
                                      <!-- THIS IS FOR SLIDER-->
                                      <div class="slidecontainer" style="padding-top:10px">
                                        <input type="range" min="1" max="5" value="3" name="price" id="price" onchange="updateTextInput(this.value);">
                                        <input type="text" id="textInput" value="3" onchange="updateRangeInput(this.value);">
                                        <script>function updateTextInput(val) {
                                                  document.getElementById('textInput').value=val; 
                                                }
                                                function updateRangeInput(val) {
                                                  document.getElementById('rangeInput').value=val; 
                                                }
                                        </script>
                                      </div>
                                      <!-- END OF SLIDER-->
                                    </div>

                                    <div class="w3-half">
                                      <label>Location</label>
                                      <div class="w3-input">
                                      <select name="location" id="location"> ';
                                        <option selected></option>
                                        <?php
                                          foreach($cafes_locations as $l) {
                                            echo '<option value="' . $l . '">' . $l . '</option>';
                                          }
                                        ?>
                                      </select>
                                        </div>
                                    </div>
                                  </div>
                                        </br>
                                  <p><button class="w3-button w3-black" style="width:25%">Search</button></p>
                                </form>
                                </div>
                            
                            </header>

                            <div id="main-container" class="container">
                              <div class='w3-row-padding w3-padding-16' id="cafeTable">

                              </div>
                            
                            </div>
                        <label id="error" class="text-danger"></label>
        
            <script>
                // Helper function to display error message
                function showError(message) {
                    // Hide the table and button in the event of error
                    $('#cafeTable').hide();
             
                    // Display an error under the main container
                    $('#error').text(message);
                    $('#error').show();
                }
        
             
                // anonymous async function 
                // - using await requires the function that calls it to be async
                $(async() => {           
                    // Change serviceURL to your own
                    console.log(price)
                    var serviceURL = "http://127.0.0.1:5001/cafes";
                    console.log(serviceURL)
                    try {
                        const response =
                         await fetch(
                           serviceURL, { method: 'GET' }
                        );
                        const data = await response.json();
                        if (response.ok) {
                            console.log(data);
                        }
                        var cafes = data.cafes; //the arr is in data.books of the JSON data
                        console.log(cafes);
                        // array or array.length are false
                        if (!cafes || !cafes.length) {
                            showError('Cafes list empty or undefined.')
                        } else {
                            // for loop to setup all table rows with obtained book data
                            var rows = "";
                            for (const cafe of cafes) {
                              eachRow =
                                "<div class='w3-third w3-margin-bottom'>" +
                                // "<img src='cafe_background.jpg' alt='Norway' style='width:100%'>"+
                                "<img src='cafe_layouts/" + cafe.name + "/" + cafe.name + ".jpg' alt='Norway' style='width:100%'>"+
                                "<div class='w3-container w3-white'>"+
                                "<h3>" + cafe.name + "</h3>" +
                                "<h6>" +"<i class='fa fa-phone' aria-hidden='true'></i>"+"&nbsp"+ cafe.phone + "</h6>" +
                                "<p>" +"<i class='fa fa-star' aria-hidden='true'></i>"+"&nbsp"+ cafe.avg_review + "</p>" +
                                "<p>" +"<i class='fa fa-money' aria-hidden='true'></i>"+"&nbsp"+ cafe.price + "</p>" +
                                "<p>" +"<i class='fa fa-map-marker' aria-hidden='true'></i>"+"&nbsp"+ cafe.location + "</p>" +
                                "<p><a id='bookBtn' class='btn btn-primary' href='bookingcalendar/index.php?cafename=" + cafe.name +  "'>Book now!</a>"+
                                "&nbsp<a id='viewReviewBtn' class='btn btn-primary' href='viewreviews.php?cafeid=" + cafe.cafeID + "'>View Reviews</a></p>" +
                                "<p><a id='locationBtn' class='btn btn-primary' target='_blank' href='directions.html?key="+cafe.name+"'>Get Here!</a></p>" +
                                "</div>"+
                                "</div>"; 
                              rows += eachRow ;
                            }
                            // add all the rows to the table
                            $('#cafeTable').append(rows);
                        }
                    } catch (error) {
                        // Errors when calling the service; such as network error, 
                        // service offline, etc
                        showError('There is a problem retrieving cafes data, please try again later.<br />'+error);
                    } // error
                });

                $("#searchCafeForm").submit(async(event) => {  
                    event.preventDefault();         
                    $("#error").hide();
                    // Change serviceURL to your own
                    var price = $('#price').val()
                    var i;
                    var rows = "";
                    var location = $('#location').val()
                    console.log(price)
                    console.log(location)
                    if(!location || !location.length) {
                      for(i=1; i<=price; i++) {
                        var serviceURL = "http://127.0.0.1:5001/cafes"+ "/" + i;

                        try {
                            const response =
                              await fetch(
                                serviceURL, { method: 'GET' }
                              );
                            const data = await response.json();
                            if (response.ok) {
                                console.log(data);
                            }
                            var cafes = data.cafes; //the arr is in data.books of the JSON data
                            console.log(cafes);
                            // array or array.length are false
                            if (!cafes || !cafes.length) {
                                // showError('No cafes found. Please try again.')
                            } else {
                                // for loop to setup all table rows with obtained book data
                                for (const cafe of cafes) {

                                  eachRow =
                                    "<div class='w3-third w3-margin-bottom'>" +
                                    // "<img src='cafe_background.jpg' alt='Norway' style='width:100%'>"+
                                    "<img src='cafe_layouts/" + cafe.name + "/" + cafe.name + ".jpg' alt='Norway' style='width:100%'>"+
                                    "<div class='w3-container w3-white'>"+
                                    "<h3>" + cafe.name + "</h3>" +
                                    "<h6>" +"<i class='fa fa-phone' aria-hidden='true'></i>"+"&nbsp"+ cafe.phone + "</h6>" +
                                    "<p>" +"<i class='fa fa-star' aria-hidden='true'></i>"+"&nbsp"+ cafe.avg_review + "</p>" +
                                    "<p>" +"<i class='fa fa-money' aria-hidden='true'></i>"+"&nbsp"+ cafe.price + "</p>" +
                                    "<p>" +"<i class='fa fa-map-marker' aria-hidden='true'></i>"+"&nbsp"+ cafe.location + "</p>" +
                                    "<p><a id='bookBtn' class='btn btn-primary' href='bookingcalendar/index.php?cafename=" + cafe.name +  "'>Book now!</a>"+
                                    "&nbsp<a id='viewReviewBtn' class='btn btn-primary' href='viewreviews.php?cafeid=" + cafe.cafeID + "'>View Reviews</a></p>" +
                                    "<p><a id='locationBtn' class='btn btn-primary' target='_blank' href='directions.html?key="+cafe.name+"'>Get Here!</a></p>" +
                                    "</div>"+
                                    "</div>"; 
                                  rows += eachRow ;
                                }
                            }
                            
                        } catch (error) {
                            // Errors when calling the service; such as network error, 
                            // service offline, etc
                            showError('There is a problem retrieving cafes data, please try again later.<br />'+error);
                        } // error
                        // add all the rows to the table
                        $('#cafeTable').show();
                        $('#cafeTable').empty();
                        $('#cafeTable').append(rows);
                      }
                    }
                    else {
                      for(i=1; i<=price; i++) {
                        var serviceURL = "http://127.0.0.1:5001/cafes"+ "/" + i + "/" + location;

                        try {
                            const response =
                              await fetch(
                                serviceURL, { method: 'GET' }
                              );
                            const data = await response.json();
                            if (response.ok) {
                                console.log(data);
                            }
                            var cafes = data.cafes; //the arr is in data.books of the JSON data
                            console.log(cafes);
                            // array or array.length are false
                            if (!cafes || !cafes.length) {
                                // showError('No cafes found. Please try again.')
                            } else {
                                // for loop to setup all table rows with obtained book data
                                for (const cafe of cafes) {

                                  eachRow =
                                    "<div class='w3-third w3-margin-bottom'>" +
                                    "<img src='cafe_background.jpg' alt='Norway' style='width:100%'>"+
                                    "<div class='w3-container w3-white'>"+
                                    "<h3>" + cafe.name + "</h3>" +
                                    "<h6>" +"<i class='fa fa-phone' aria-hidden='true'></i>"+"&nbsp"+ cafe.phone + "</h6>" +
                                    "<p>" +"<i class='fa fa-star' aria-hidden='true'></i>"+"&nbsp"+ cafe.avg_review + "</p>" +
                                    "<p>" +"<i class='fa fa-map-marker' aria-hidden='true'></i>"+"&nbsp"+ cafe.location + "</p>" +
                                    "<p><a id='bookBtn' class='btn btn-primary' href='bookingcalendar/index.php?cafename=" + cafe.name +  "'>Book now!</a>"+
                                    "&nbsp<a id='viewReviewBtn' class='btn btn-primary' href='viewreviews.php?cafeid=" + cafe.cafeID + "'>View Reviews</a></p>" +
                                    "<p><a id='locationBtn' class='btn btn-primary' target='_blank' href='directions.html?key="+cafe.name+"'>Get Here!</a></p>" +
                                    "</div>"+
                                    "</div>"; 
                                  rows += eachRow ;
                                }
                            }
                            
                        } catch (error) {
                            // Errors when calling the service; such as network error, 
                            // service offline, etc
                            showError('There is a problem retrieving cafes data, please try again later.<br />'+error);
                        } // error
                        // add all the rows to the table
                        $('#cafeTable').show();
                        $('#cafeTable').empty();
                        $('#cafeTable').append(rows);
                      }
                    }
                    if(!rows.length) {
                      showError('\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0'+' No cafes found. Please try again.');
                    }
                });
            </script>
            
                        
        </body>
        </html>