<?php

//connect to database
$conn = mysqli_connect('localhost','root','NEWPASSWORD','roleta_test2');

if(isset($_POST['Stat'])){
   $Stat = mysqli_real_escape_string($conn, $_POST['Stat']);

   echo 'POSTED....'. $_POST['Stat'];

   $query = "UPDATE statusled_2 SET Stat = '$Stat' WHERE id = 1 ";

   if(mysqli_query($conn,$query)){
      echo 'STAT UPDATED....';

   }else{
      echo 'ERROR: '.mysqlli_error($conn);
   }
}

if(isset($_POST['Mode'])){
   $Mode = mysqli_real_escape_string($conn, $_POST['Mode']);

   echo 'POSTED....'. $_POST['Mode'];

   $query = "UPDATE statusled_2 SET Mode = '$Mode' WHERE id = 1 ";

   if(mysqli_query($conn,$query)){
      echo 'MODE UPDATED....';

   }else{
      echo 'ERROR: '.mysqlli_error($conn);
   }
}

if(isset($_POST['Weather'])){
   $Weather = mysqli_real_escape_string($conn, $_POST['Weather']);

   echo 'POSTED....'. $_POST['Weather'];

   $query = "UPDATE statusled_2 SET Weather = '$Weather' WHERE id = 1 ";

   if(mysqli_query($conn,$query)){
      echo 'WEATHER UPDATED....';

   }else{
      echo 'ERROR: '.mysqlli_error($conn);
   }
}