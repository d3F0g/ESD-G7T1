<?php
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
            <p><b>Cafe Name:</b> <?php echo $_GET['cafename']?></p>
            <p><b>Booking Date:</b> #DATE</p>
            <p><b>Booking Time:</b> #TIME</p>

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
                        var serviceURL = "http://127.0.0.1:5000/booking/4";
                        var homeURL = "http://127.0.0.1/ESD-G7T1/app/simple_UI.php?msg=Booking%20Confirmed!";

                    //Get form data 
                    var userID = "2";
                    var cafeID = "2";
                    var seat_no = "3";
                    var block = "3";
                    var date = "2020-03-30";
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