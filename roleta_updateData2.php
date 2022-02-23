<?php
     
  require 'roleta_db2.php';

  // SLANJE PODATKA O TIPKALU U DATA BAZU

  if (!empty($_POST)) {
    $Stat = $_POST['Stat'];
      
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE statusled_2 SET Stat = ? WHERE ID = 1";
    $q = $pdo->prepare($sql);
    $q->execute(array($Stat));
    Database::disconnect();
  }

  // SLANJE PODATKA O MODU RADA U DATA BAZU

  if (!empty($_POST)) {
    $Mode = $_POST['Mode'];
      
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE statusled_2 SET Mode = ? WHERE ID = 1";
    $q = $pdo->prepare($sql);
    $q->execute(array($Mode));
    Database::disconnect();
  }

  // SLANJE PODATKA O VREMENU U DATA BAZU

  if (!empty($_POST)) {
    $Weather = $_POST['Weather'];
      
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE statusled_2 SET Weather = ? WHERE ID = 1";
    $q = $pdo->prepare($sql);
    $q->execute(array($Weather));
    Database::disconnect();
  }
  
?>