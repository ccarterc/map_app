<?php

try {  
  $pdo_db = new PDO("mysql:host=localhost;dbname=map_app", 'YOUR_DB_USERNAME', 'YOUR_DB_PASSWORD');

}catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}


?>
