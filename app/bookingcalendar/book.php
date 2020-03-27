<?php
if(isset($_GET['date'])){
    $date = $_GET['date'];
}
if(isset($_GET['cafe'])){
    $cafe = $_GET['cafe'];
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mysqli = new mysqli('localhost', 'root', 'root', 'bookingcalendar');
    $stmt = $mysqli->prepare("INSERT INTO bookings (name, email, date) VALUES (?,?,?)");
    $stmt->bind_param('sss', $name, $email, $date);
    $stmt->execute();
    $msg = "<div class='alert alert-success'>Booking Successfull</div>";
    $stmt->close();
    $mysqli->close();
}

?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
  </head>
  <h1 class="text-center">Book for Date: <?php echo date('m/d/Y', strtotime($date)); ?></h1><hr>
  <h1 class="text-center">Location: <?php echo $cafe; ?></h1><hr>
  <link rel="stylesheet" type="text/css" href="../../css/booktimeslot.css">
  <div class="time-picker-container">
  <input type="radio" name="AppointmentDateTime" id="radio-morning" />
  <input type="radio" name="AppointmentDateTime" id="radio-afternoon" />
  <input type="radio" name="AppointmentDateTime" id="radio-evening" />
  <input type="radio" name="AppointmentDateTime" id="radio-night" />
  <div class="clock-container">
    <label for="radio-morning" class="pie pie-morning">
      <span>Morning</span>
    </label>
    <label for="radio-afternoon" class="pie pie-afternoon">
      <span>Afternoon</span>
    </label>
    <label for="radio-night" class="pie pie-night">
      <span>Night</span>
    </label>
    <label for="radio-evening" class="pie pie-evening">
      <span>Evening</span>
    </label>
    
  </div>

  <h2 class="time-display">
                            <span class="time-display-inner">
                                <span>9AM to 12PM</span>
                                <span>12PM to 3PM</span>
                                <span>3PM to 6PM</span>
                                <span>6PM to 9PM</span>
                            </span>
                        </h2>
</div>

</html>
