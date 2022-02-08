<?php
     
  require 'roleta_db2.php';
  
  if (!empty($_POST)) {
    $Stat = $_POST['Stat'];
      
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE statusled_2 SET Stat = ? WHERE ID = 1";
    $q = $pdo->prepare($sql);
    $q->execute(array($Stat));
    Database::disconnect();
    header("Location: domzajezabrijo.php");
  }

  
?>