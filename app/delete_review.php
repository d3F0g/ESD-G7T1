<?php
if (isset($_GET['bookingID'])) {
    $booking = $_GET['bookingID'];
}

// get review booking IDs
$dsn = "mysql:host=localhost;dbname=esd";
$pdo = new PDO($dsn, "root", "root");
$sql = "delete from reviews where bookingID=:bookingID";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':bookingID', $booking, PDO::PARAM_STR);
$stmt->execute();

$stmt = null;
$pdo = null;

header("Location: booking_page.php");

?>