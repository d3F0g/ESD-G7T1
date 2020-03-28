<?php
$email = $_POST['loginEmail'];
$pass = $_POST['loginPassword'];

//Connect to db 
//Add registration details
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "esd";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM owners WHERE email = '$email';";
    
    $stmt = $conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $db_password = $row['password'];
    $first_name = $row['first_name'];

    if (password_verify($pass, $db_password)) {
        session_start();
        $_SESSION['userData']['first_name'] = $first_name; 
        header("Location: ../owners_simple_UI.php");
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