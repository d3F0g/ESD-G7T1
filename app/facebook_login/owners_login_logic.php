<?php
$email = $_POST['loginEmail'];
$pass = $_POST['loginPassword'];

//Connect to db 
//Add registration details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esd";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM cafes WHERE email = '$email';";
    
    $stmt = $conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $db_password = $row['password'];
    $cafename = $row['name'];
    $cafephone = $row['phone'];
    $location = $row['location'];


    if (password_verify($pass, $db_password)) {
        session_start();
        $_SESSION['cafename'] = $cafename; 
        $_SESSION['cafephone'] = $cafephone;
        $_SESSION['location'] = $location;
        header("Location: ../cafe_admin/landing.php");
        exit();
    } else {
        $error_msg = 'Wrong Password!';
        header("Location: owners_login.php?error=$error_msg");
        exit();
    }
}
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;



?>