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
    $mysqli = new mysqli('localhost', 'root', '', 'bookingcalendar');
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
  <h1 class="text-center">Book for Date: <?php echo date('m/d/Y', strtotime($date)); echo ", ";echo date('l', strtotime($date));?></h1><hr>
  
  <h1 class="text-center">Location: <?php echo $cafe; ?></h1><hr>
  

</head>


<body>
<link rel="stylesheet" type="text/css" href="../../css/booktimeslot.css">
<div class="d-flex justify-content-center align-items-center container">
  <button class="neu" id="block1">
    <i class="material-icons">0800-0900</i>
  </button>
  <button class="neu" id="block1">
    <i class="material-icons">0900-1000</i>
  </button>
  <button class="neu" id="block2">
    <i class="material-icons">1000-1100</i>
  </button>
  <button class="neu" id="block3">
    <i class="material-icons">1100-1200</i>
  </button>
  <button class="neu" id="block4">
    <i class="material-icons">1200-1300</i>
  </button>
  <button class="neu" id="block5">
    <i class="material-icons">1300-1400</i>
  </button>
  <button class="neu" id="block6">
    <i class="material-icons">1400-1500</i>
  </button>
  <button class="neu" id="block7">
    <i class="material-icons">1500-1600</i>
  </button>
  <button class="neu" id="block8">
    <i class="material-icons">1600-1700</i>
  </button>
  <button class="neu" id="block9">
    <i class="material-icons">1700-1800</i>
  </button>
  <button class="neu" id="block10">
    <i class="material-icons">1800-1900</i>
  </button>
  <button class="neu" id="block11">
    <i class="material-icons">1900-2000</i>
  </button>
  <button class="neu" id="block12">
    <i class="material-icons">2000-2100</i>
  </button>
  <button class="neu" id="block13">
    <i class="material-icons">2100-2200</i>
  </button>
  <button class="neu" id="block14">
    <i class="material-icons">2200-2300</i>
  </button>
  
</div>
<script src="comply.js"></script>
</body>


</html>
