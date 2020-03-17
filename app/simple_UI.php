<!DOCTYPE html>
<html>
    
    <head>
    <title>Cafe Booking UI</title>
    <link rel="stylesheet" href="http://bootswatch.com/darkly/bootstrap.min.css">
    </head>

    <body>
    <div align="justify">
        <a href="booking_page.php">Booking</a>
        <a href="payment_service.php">Payment</a>
    </div>
    <div align="right">
        <a href="facebook_login/login.php">Login</a>
        <a href="login.html">Sign Up</a>
    </div>
    
    <hr>
    <h1>Search for the cafe:</h1>
        <form method = 'POST' action = 'search.php'>
            Booking (date):<input type="date" id="bookingdate" name="bookingdate">
            Booking (time):<input type="time" id="bookingtime" name="bookingtime">
            Number of People: <input type='number' id='pax' name='pax'>
            Location: 
            <select name="location">
                <option value="amk">Ang Mo Kio</option>
                <option value="bishan">Bishan</option>
                <option value="city hall">City Hall</option>
                <option value="duxton">Duxton</option>
            </select>
            <input type='submit'>
        </form>
    </body>

</html>
