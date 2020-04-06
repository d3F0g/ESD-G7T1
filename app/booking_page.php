<?php
session_start();
//add to window page
if (isset($_GET['r'])) {
    $results = $_GET['r'];
    $revs = unserialize($results);
}
else {
    // get review booking IDs
    $dsn = "mysql:host=localhost;dbname=esd";
    $pdo = new PDO($dsn, "root", "");
    $sql = "select bookingID from reviews";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $review_bookingIDs = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $review_bookingIDs[] = $row['bookingID'];
    }
    $stmt = null;
    $pdo = null;
    $review_data = serialize($review_bookingIDs);
    header("Location: booking_page.php?r=$review_data");
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
    
    <title>View Bookings</title>
 
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
    <li><a href="booking_page.php">Check Bookings</a></li>
    <li style="float:right"><a class="active" href="facebook_login/logout.php">Logout</a></li>
    </ul>
    <div id="main-container" class="container">
        <h1 class="display-4">View Bookings</h1>
        <table id="bookingTable" class='table table-striped' border='1'>
            <thead class='thead-dark'>
                <tr>
                    <th>BookingID</th>
                    <th>Cafe Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
        </table>
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
        $(async() => {           
            // Change serviceURL to your own
            var serviceURL = "http://127.0.0.1:5000/booking/user/"+ <?php echo $_SESSION['userData']['userID']?>;
     
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
                    showError('Booking list empty or undefined.')
                } else {
                    // for loop to setup all table rows with obtained book data
                    var rows = "";
                    var reviews = <?php echo json_encode($revs); ?>;
                    var result = reviews.map(function (x) { 
                    return parseInt(x, 10); 
                    });
                    for (const booking of bookings) {
                        var cafeid = booking.cafeID;
                        var getCafeURL = "http://127.0.0.1:5001/cafes/get/";
                        getCafeURL += cafeid;
                        try{
                            const response =
                                await fetch(
                                getCafeURL, { method: 'GET' }
                            );
                            const data1 = await response.json();
                            if (response.ok) {
                                var foundCafeName = data1.name;
                                console.log(foundCafeName);
                            }

                        } catch(error) {
                            showError('There is a problem retrieving booking data, please try again later.<br />'+error);
                        }
                        //bookings are now loaded onto the url of the page
                        if (result.includes(booking.ID)) {
                            eachRow =
                            "<td>" + booking.ID + "</td>" +
                            "<td>" + foundCafeName + "</td>" +
                            "<td>" + booking.date + "</td>" +
                            "<td>" + booking.status + "</td>" ;
                            
                            if(booking.status != "Cancelled") {
                                eachRow += "<td>" + "<a id='bookBtn' class='btn btn-primary' style='background-color:red; border-color:red' href='delete_review.php?bookingID=" + booking.ID + "'>Delete Review</a>" + "</td>" +
                                "<td>" + "<a id='cancelBtn' class='btn btn-primary' href='confirmCancel.php?bookingID=" + booking.ID + "'>Cancel booking!</a>" + "</td>";
                            } else {
                                eachRow += "<td></td>" + "<td></td>";
                            }
                            rows += "<tbody><tr>" + eachRow + "</tr></tbody>";
                        }
                        else {
                            eachRow =
                            "<td>" + booking.ID + "</td>" +
                            "<td>" + foundCafeName + "</td>" +
                            "<td>" + booking.date + "</td>" +
                            "<td>" + booking.status + "</td>" ;

                            if(booking.status != "Cancelled") {
                                eachRow += "<td>" + "<a id='bookBtn' class='btn btn-primary' href='user_review.php?bookingID=" + booking.ID + "&cafeID=" + booking.cafeID + "&userID=" + booking.userID + "'>Give Review!</a>" + "</td>" +
                                "<td>" + "<a id='cancelBtn' class='btn btn-primary' href='confirmCancel.php?bookingID=" + booking.ID + "'>Cancel booking!</a>" + "</td>";
                            } else {
                                eachRow += "<td></td>" + "<td></td>";
                            }
                            rows += "<tbody><tr>" + eachRow + "</tr></tbody>";
                        }

                        

                    }
                    // add all the rows to the table
                    $('#bookingTable').append(rows);
                }
            // }
            }
             catch (error) {
                // Errors when calling the service; such as network error, 
                // service offline, etc
                showError('There is a problem retrieving booking data, please try again later.<br />'+error);

                
           
            } // error
        });

        
    </script>

</body>
</html>