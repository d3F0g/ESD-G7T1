<?php
session_start();
if(isset($_POST['cafe'])){
    $name = $_POST['cafe'];
}
if(isset($_POST['cafeID'])){
    $cafeID = $_POST['cafeID'];
}
if(isset($_POST['seat_no'])){
    $seat = $_POST['seat_no'];
}
if(isset($_POST['date'])){
    $date = $_POST['date'];
}
if(isset($_POST['block'])){
    $block = $_POST['block'];
}

$seat = json_encode($seat);

$date = json_encode($date);
$bookTime = "";
if($block == 1) {
    $bookTime = "0800-0900";
} 
if($block== 2) {
    $bookTime = "0900-1000";
}
if($block == 3) {
    $bookTime = "1000-1100";
}
if($block == 4) {
    $bookTime = "1100-1200";
}
if($block == 5) {
    $bookTime = "1200-1300";
}
if($block == 6) {
    $bookTime = "1300-1400";
}
if($block == 7) {
    $bookTime = "1400-1500";
}
if($block == 8) {
    $bookTime = "1500-1600";
}
if($block == 9) {
    $bookTime = "1600-1700";
}
if($block == 10) {
    $bookTime = "1700-1800";
}
if($block == 11) {
    $bookTime = "1800-1900";
}
if($block == 12) {
    $bookTime = "1900-2000";
}
if($block == 13) {
    $ookTime = "2000-2100";
}
if($block == 14) {
    $bookTime = "2100-2200";
}
if($block == 15) {
    $bookTime = "2200-2300";
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PayPal Integration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        #container{
            width: 100%;
            max-width: 500px;
            display: table;
            margin: 150px auto 0;
        }
        .productBlock{
            width: 100%;
            max-width: 200px;
            display: table;
            margin: 0 auto;
            border: 3px solid #666;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div id="container">
        <div class="productBlock">
            <p><b>Cafe Name:</b> <?php echo $_POST["cafe"]; ?></p>
            <p><b>Booking Date:</b> <?php echo $_POST["date"]; ?></p>
            <p><b>Booking Time:</b> <?php echo $bookTime; ?></p>
            <p><b>Booking Fees:</b> $1.50 </p>

            <!-- Your PayPal Button here -->

<head>
    <!-- Add meta tags for mobile and IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>

<body>
    <!-- Set up a container element for the button -->
    <div id="paypal-button-container"></div>

    <!-- Include the PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=SGD"></script>

    <script>
        // Render the PayPal button into #paypal-button-container
        //email ID for PAYPAL: sb-ahfw2581173@business.example.com
        //password for PAYPAL: JU-z(3v=

        // paypal.Buttons({
        //     // Finalize the transaction
        //     onApprove: function(data, actions) {
        //         return actions.order.capture().then(function(details) {
        //             // Show a success message to the buyer
        //             alert('Transaction completed by ' + details.payer.name.given_name + '!');               
        //                 });                
        //             }
        // }).render('#paypal-button-container');


        paypal.Buttons({
             // Set up the transaction
             createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '1.50'
                        }
                    }]
                });
            },

            onApprove: async function bookingPOST(){
                    var foundBookingID;
                    var getBookingIDURL = "http://127.0.0.1:5000/booking/get_id";
                    try {
                        const response =
                            await fetch(
                                getBookingIDURL, { method: 'GET' }
                            );
                            const data = await response.json();
                            if (response.ok) {
                                console.log(data);
                                foundBookingID = data;
                            }
                    } catch (error) {
                        // Errors when calling the service; such as network error, 
                        // service offline, etc
                        showError('Cannot get Booking ID'+error);
                    } 
                    var serviceURL = "http://127.0.0.1:5000/booking/";
                    serviceURL += foundBookingID;
                    var homeURL = "simple_UI.php?msg=Booking%20Confirmed!";

                    //Get form data 
                    var userID = <?php echo $_SESSION["userData"]["userID"]; ?>;
                    var cafeID = <?php echo $_POST["cafeID"]; ?>;
                    
                    var seat_no = <?php echo $seat; ?>;
                    var block = <?php echo $_POST["block"]; ?>;
                    var date = <?php echo $date; ?>;
                    // console.log(date)
                    // var validDate = new Date(date);
                    // console.log(validDate)
                    var status = "Confirmed";

                    try {
                        const response =
                            await fetch(
                                serviceURL, {
                                method: 'POST',
                                headers: { "Content-Type": "application/json" },
                                body: JSON.stringify({ userID: userID, cafeID: cafeID, seat_no: seat_no, block: block, date: date, status: status })
                            });
                        
                            const data = await response.json();

                        if (response.ok) {
                            // relocate to home page
                            window.location.replace(homeURL);
                            return false;

                        } else {
                            console.log(data);
                            showError(data.message);
                        }
                    } catch (error) {
                        // Errors when calling the service; such as network error, 
                        // service offline, etc
                        showError
                            ("There is a problem adding this booking, please try again later. " + error);

            } // error
                    }
                }).render('#paypal-button-container');


       
      
    </script>    
        </div>
    </div>
</body>
</html>