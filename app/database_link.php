<?php

$cafes_locations = [];
  
  $dsn = "mysql:host=localhost;dbname=esd";
  $pdo = new PDO($dsn, "root", "");
  $sql = 'select * from cafes';
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  while($row = $stmt->fetch()) { 
    $cafes_locations[] = $row["location"];
  }
  $stmt = null;
  $pdo = null;
  
  echo"<select name="location" id="location"> ';
    foreach($cafes_locations as $l) {
    echo '<option value="' . $l . '">' . $l . '</option>';
    }
    
echo '
    </select>"

?> 