<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">

    <title> Give Reviews! </title>

    <link rel="stylesheet" href="">
    <!--[if lt IE 9]>
      <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Bootstrap libraries -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    
</head>

<body>
    <h1 class="display-4">Add a Review</h1>
    <form id='addReviewForm'>
        <input type="hidden" id="userID" name="userID" value= <?php echo $_GET['userID']?>>
        <input type="hidden" id="cafeID" name="cafeID" value=<?php echo $_GET['cafeID']?>>
        <input type="hidden" id="bookingID" name="bookingID" value=<?php echo $_GET['bookingID']?>>
        <div class="form-group">
            <label for="stars">Stars</label>
            <select id="stars" name="stars">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <div class="form-group">
            <label for="comments">Comments</label>
            <input type="text" class="form-control" id="content" placeholder="Enter comments" value="Comments">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <label id="error" class="text-danger"></label>
</body>
<script>
    // Helper function to display error message
    function showError(message) {
        // Display an error under the the predefined label with error as the id
        $('#error').text(message);
    }

    $("#addReviewForm").submit(async (event) => {
        //Prevents screen from refreshing when submitting
        event.preventDefault();

        var ID = 1;
        var serviceURL = "http://127.0.0.1:5001/reviews/add/";
        var homeURL = "http://127.0.0.1/ESDProject/app/simple_UI.php";
        serviceURL += ID;

        //Get form data 
        var userID = $('#userID').val();
        var cafeID = $('#cafeID').val();
        var bookingID = $('#bookingID').val();
        var stars = $('#stars').val();
        var content = $('#content').val();
        try {
            const response =
                await fetch(
                    serviceURL, {
                    method: 'POST',
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({userID: userID, cafeID: cafeID, bookingID: bookingID, content: content, stars: stars })
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
                ("There is a problem adding this review, please try again later. " + error);

        } // error
    });
</script>
</html>