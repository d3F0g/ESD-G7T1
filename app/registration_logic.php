<?php
    //Retrieve from form 
    $email = $_POST['email'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $phone = $_POST['phone'];
    $social = NULL;

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "esd";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully"."</br>";
        $sql = "INSERT IGNORE INTO users (email, password, first_name, last_name, phone, social_media) VALUES (:email, :pass, :first_name, :last_name, :phone, :social_media)";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':social_media', $social_media, PDO::PARAM_STR);


        $stmt->execute();

    }
        
        
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }

    
    header("Location: simple_UI.php");
?>