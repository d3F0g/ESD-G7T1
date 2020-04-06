<?php
if (isset($_GET['bookingID'])) {
    $booking = $_GET['bookingID'];
}

// // get review booking IDs
// $dsn = "mysql:host=localhost;dbname=esd";
// $pdo = new PDO($dsn, "root", "root");
// $sql = "delete from reviews where bookingID=:bookingID";
// $stmt = $pdo->prepare($sql);
// $stmt->bindParam(':bookingID', $booking, PDO::PARAM_STR);
// $stmt->execute();

// $stmt = null;
// $pdo = null;

// header("Location: booking_page.php");

?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
<script>
    
        var deletionID = <?=$booking?>;
        var serviceURL = "http://127.0.0.1:5002/reviews/delete/";
        var homeURL = "simple_UI.php?msg=Review%20Deleted!";
        serviceURL += deletionID;

        try {
            const response =
                fetch(
                    serviceURL, {
                    method: 'POST',
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({bookingID: deletionID})
                });

        } catch (error) {
            // Errors when calling the service; such as network error, 
            // service offline, etc
            throw "There is an error deleting the review";
        }
        finally {
            // relocate to home page
            window.location.replace(homeURL);
        }
</script>

