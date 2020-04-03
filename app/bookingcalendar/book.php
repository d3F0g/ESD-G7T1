<?php
if(isset($_GET['date'])){
    $date = $_GET['date'];
}
if(isset($_GET['cafe'])){
    $cafe = $_GET['cafe'];
}
if(isset($_GET['seats'])){
  $seats = $_GET['seats'];
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

// Retrieves the cafeID-------------------------DO NOT TOUCH-------------------------------------
$dsn = "mysql:host=localhost;dbname=esd";
$pdo = new PDO($dsn, "root", "root");
$sql = "select ID from cafes where name=:name";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':name', $cafe, PDO::PARAM_STR);
$stmt->execute();
$results = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $results[] = $row['ID'];
}
$stmt = null;
$pdo = null;
//retrieve the cafeID
$cafeID = $results[0];
$id = (int)$cafeID;
$seat_no = unserialize($seats)[0];

//retrieve the block from booking----------------with CafeID and SeatID---------------------
$dsn = "mysql:host=localhost;dbname=esd";
$pdo = new PDO($dsn, "root", "root");
$sql = "select block from booking where cafeID=:cafeID and seat_no=:seat_no and date=:date";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':cafeID', $cafeID, PDO::PARAM_STR);
$stmt->bindParam(':seat_no', $seat_no, PDO::PARAM_STR);
$stmt->bindParam(':date', $date, PDO::PARAM_STR);
$stmt->execute();
$timings = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $timings[] = $row['block'];
}
$stmt = null;
$pdo = null;
//timings will contain different strings of the blocks occupied for that seat

?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
  </head>
  <h1 class="text-center">Book for Date: <?php echo date('m/d/Y', strtotime($date)); echo ", ";echo date('l', strtotime($date));?></h1><hr>
  
  <h1 class="text-center">Location: <?php echo $cafe; ?></h1><hr>
  

</head>


<body>
<form action="../payment_service.php" method="POST">
<?php
  // echo "<input type='hidden' name='userID' value=''>";
  echo "<input type='hidden' name='cafe' value='$cafe'>";
  echo "<input type='hidden' name='cafeID' value='$id'>";
  echo "<input type='hidden' name='seat_no' value='$seat_no'>";
  echo "<input type='hidden' name='date' value='$date'>";
?>

<link rel="stylesheet" type="text/css" href="../../css/booktimeslot.css">
<div class="d-flex justify-content-center align-items-center container">

  <button class="neu" name="block" onclick="save_click(this.id)" id="1">
    <i class="material-icons">0800-0900</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="2">
    <i class="material-icons">0900-1000</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="3">
    <i class="material-icons">1000-1100</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="4">
    <i class="material-icons">1100-1200</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="5">
    <i class="material-icons">1200-1300</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="6">
    <i class="material-icons">1300-1400</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="7">
    <i class="material-icons">1400-1500</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="8">
    <i class="material-icons">1500-1600</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="9">
    <i class="material-icons">1600-1700</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="10">
    <i class="material-icons">1700-1800</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="11">
    <i class="material-icons">1800-1900</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="12">
    <i class="material-icons">1900-2000</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="13">
    <i class="material-icons">2000-2100</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="14">
    <i class="material-icons">2100-2200</i>
  </button>
  <button class="neu" name="block" onclick="save_click(this.id)" id="15">
    <i class="material-icons">2200-2300</i>
  </button>
  
</div>
<script>
  function disabler(id) {
    // this function would highlight and disable timings already booked
    var el = document.getElementById(id);
    el.style.background = "red";
    el.style.color = "white";
    el.disabled = true;
}
  function save_click(clicked_id) {
    document.getElementById(clicked_id).value = clicked_id;
  }
  var listing = <?php echo json_encode($timings); ?>;
  var i;
  for (i of listing) {
    disabler(i);
  }
</script>
</form>
</body>


</html>
