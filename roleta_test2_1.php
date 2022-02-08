<?php
  include 'roleta_db2.php';

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM statusled_2 WHERE ID = 1';
    
    $q = $pdo->prepare($sql);
    $q->execute(array($Stat));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
?>


<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style_test2.css" />
  </head>
  <body>
    <h1>Welcome!</h1>
    
    <form action="roleta_updateData2.php" method="post" id="set0">
      <input type="hidden" name="Stat" value="0"/>    
    </form>
    
    <form action="roleta_updateData2.php" method="post" id="set1">
      <input type="hidden" name="Stat" value="1"/>
    </form>

    <form action="roleta_updateData2.php" method="post" id="set2">
      <input type="hidden" name="Stat" value="2"/>
    </form>

    <form action="roleta_updateData2.php" method="post" id="set3">
      <input type="hidden" name="Stat" value="3"/>
    </form>

    <form action="roleta_updateData2.php" method="post" id="set4">
      <input type="hidden" name="Stat" value="4"/>
    </form>

    <form action="roleta_updateData2.php" method="post" id="set5">
      <input type="hidden" name="Stat" value="5"/>
    </form>

    <form action="roleta_updateData2.php" method="post" id="set6">
      <input type="hidden" name="Stat" value="6"/>
    </form>

    <form action="roleta_updateData2.php" method="post" id="set7">
      <input type="hidden" name="Stat" value="7"/>
    </form>

    <form action="roleta_updateData2.php" method="post" id="set8">
      <input type="hidden" name="Stat" value="8"/>
    </form>


    <button class="button" name= "subject0" type="submit" form="set0" value="SubmitLEDON" >SET 0</button>
    <button class="button" name= "subject1" type="submit" form="set1" value="SubmitLEDON" >SET 1</button>
    <button class="button" name= "subject2" type="submit" form="set2" value="SubmitLEDON" >SET 2</button>
    <button class="button" name= "subject3" type="submit" form="set3" value="SubmitLEDON" >SET 3</button>
    <button class="button" name= "subject4" type="submit" form="set4" value="SubmitLEDON" >SET 4</button>
    <button class="button" name= "subject5" type="submit" form="set5" value="SubmitLEDON" >SET 5</button>
    <button class="button" name= "subject6" type="submit" form="set6" value="SubmitLEDON" >SET 6</button>
    <button class="button" name= "subject7" type="submit" form="set7" value="SubmitLEDON" >SET 7</button>
    <button class="button" name= "subject8" type="submit" form="set8" value="SubmitLEDON" >SET 8</button>

 

<img src =" <?php echo $data['Stat']; ?>.png" style='width:675px;height:450px;'/>


  </body>
</html>