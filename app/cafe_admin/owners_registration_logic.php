<?php
    //Retrieve from form 
    $email = $_POST['email'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $first_name = $_POST['fname'];
    $phone = $_POST['phone'];
    $cafename = $_POST['cafe_name'];
    $reviews = NULL;
    $price = 5;
    $location = $_POST['postal'];


    //Connect to db 
    //Add registration details
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "esd";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT IGNORE INTO cafes (name, email, password, phone, poc,avg_review,price,location)
        VALUES (:name, :email, :password, :phone, :poc, :avg_review, :price, :location)";
        // use exec() because no results are returned
        $stmt = $conn->prepare($sql);
        //bind param
        $stmt->bindParam(':name', $cafename, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':poc', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':avg_review', $reviews, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);

        $stmt->execute();
    }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }

    $conn = null;

    header("Location: landing.php");
?>