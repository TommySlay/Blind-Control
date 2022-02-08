<?php

//connect to database
$conn = mysqli_connect('localhost','root','NEWPASSWORD','roleta_test2');



/*if(isset($_POST['name'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);

   echo 'POSTED....'. $_POST['name'];

   $query = "INSERT INTO users(name) VALUES('$name')";

   if(mysqli_query($conn,$query)){
      echo 'USER ADDED....';

   }else{
      echo 'ERROR: '.mysqlli_error($conn);
   }
}
*/

if(isset($_POST['Stat'])){
   $Stat = mysqli_real_escape_string($conn, $_POST['Stat']);

   echo 'POSTED....'. $_POST['Stat'];

   $query = "UPDATE statusled_2 SET Stat = '$Stat' WHERE id = 1 ";

   if(mysqli_query($conn,$query)){
      echo 'USER ADDED....';

   }else{
      echo 'ERROR: '.mysqlli_error($conn);
   }
}
