<?php
if(isset($_GET['date'])){
    $date = $_GET['date'];
}
if(isset($_GET['cafe'])){
    $cafe = $_GET['cafe'];
}
$seats = [];

if(isset($_POST['seats'])){
    $seats = $_POST['seats'];
    $seat_data = serialize($seats);
    header("Location: book.php?date=$date&cafe=$cafe&seats=$seat_data");
}

require_once "../cafe_layouts/$cafe/$cafe.php";
echo "<link rel='stylesheet' type='text/css' href='../cafe_layouts/$cafe/$cafe.css'>";

//upon clicking send the cafe,date,seat over
?>
