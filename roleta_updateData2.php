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


  /*$conn = mysqli_connect('localhost', 'root','NEWPASSWORD','roleta_test2');
  
  if($conn){
  echo 'Connected....';
  }
*/

  /*echo 'WORKING...';
  if(isset($_POST['name'])){
    echo 'Post: name is'. $_POST['name'];
  } 
  */   
    /*$name = mysqli_real_escape_string($conn, $_POST['name']);
    echo 'POST:'. $_POST['name'];

    $query = "INSERT INTO users(name) VALUES ('$name')";

    if(mysqli_query($conn, $query)){
      echo 'added...';
    }else{
      echo 'ERROR:'.mysqli_error($conn);
    }
  }
*/



/*
if (isset($_POST['name'])) {
  $name = $_POST['name'];
  
    
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO USERS(name) VALUES ('$name')";
  $q = $pdo->prepare($sql);
  $q->execute(array($name));
  Database::disconnect();
  //header("Location: domzajezabrijo.php");
}
*/
?>