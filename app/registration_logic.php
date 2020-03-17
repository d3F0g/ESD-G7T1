<?php
    //Retrieve from form 
    $email = $_POST['email'];
    $pass = password_hash($_POST['pass']);
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $phone = $_POST['phone'];


    //Connect to db 
    //Add registration details
    
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "esd";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO users (email, password, first_name, last_name, phone)
        VALUES ($email, $pass, $first_name, $last_name, $phone)";
        // use exec() because no results are returned
        $conn->exec($sql);
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }

    $conn = null;

    header("Location: simple_UI.php");
?>