<!doctype html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  </head>

  <body>
    <div class="container">
        <h1 class="text-center"> Give Reviews! </h1><hr>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form id = "reviewform" action="" method="GET" autocomplete="off">
                <input type="hidden" id="userID" name="userID" value= <?php echo $_GET['userID']?>>
                <input type="hidden" id="cafeID" name="cafeID" value=<?php echo $_GET['cafeID']?>>
                <input type="hidden" id="bookingID" name="bookingID" value=<?php echo $_GET['bookingID']?>>
                    <div class="form-group">
                        <label for="">Stars</label>
                        <select id="reviews" name="stars">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Comments</label><br>
                        <textarea id="contents" name ="contents" rows="4" cols="50">
                        </textarea>
                    </div>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
    
    <script>
    window.onload = function(){
       document.getElementById("#reviewform").onsubmit = function(){reviewsPOST()};

                async function reviewPOST(){
                    var serviceURL = "http://127.0.0.1:5001/reviews/1";
                    var homeURL = "http://127.0.0.1/ESD-G7T1/app/simple_UI.php";

                    //Get form data 
                    var ID = "1";
                    var userID =  $_GET['userID'];;
                    var cafeID = $_GET['cafeID'];
                    var bookingID = $_GET['bookingID'];
                    var content = $_GET['comments'];
                    var stars = $_GET['stars'];

                    try {
                        const response =
                            await fetch(
                                serviceURL, {
                                method: 'POST',
                                headers: { "Content-Type": "application/json" },
                                body: JSON.stringify({ ID: ID, userID: userID, cafeID: cafeID, bookingID: bookingID, content: content, stars: stars })
                            });
                        
                            const data = await response.json();
                            console.log(data);
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
    }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>

</html>