<?php
session_start();
?>
<!DOCTYPE html>
<html>
 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
 
    <title>Past Bookings</title>
 
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
    <div id="main-container" class="container">
        <h1 class="display-4">Past Bookings</h1>
        <table id="bookingTable" class='table table-striped' border='1'>
            <thead class='thead-dark'>
                <tr>
                    <th>BookingID</th>
                    <th>CafeID</th>
                    <th>Date</th>
                    <th>Review</th>
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
                // var bookings = data.bookings; //the arr is in data.books of the JSON data
                // console.log(bookings);

                // array or array.length are false
                if (!data) {
                    showError('Booking list empty or undefined.')
                } else {
                    // for loop to setup all table rows with obtained book data
                    var rows = "";
                    // for (var booking in data)) {

                        eachRow =
                            "<td>" + data.ID + "</td>" +
                            "<td>" + data.cafeID + "</td>" +
                            "<td>" + data.date + "</td>" +
                            "<td>" + "<a id='bookBtn' class='btn btn-primary' href='user_review.php?bookingID=" + data.ID + "&cafeID=" + data.cafeID + "&userID=" + data.userID + "'>Give Review!</a>" + "</td>";
                        rows += "<tbody><tr>" + eachRow + "</tr></tbody>";

                    // }
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