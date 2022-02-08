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
    <h1>Roleta se nalazi u poziciji: <?php echo $data['Stat']; ?></h1>
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
        <table>
            <tr>
                <td><input class="button" name="set0" type="submit" form="set0" value="SET0" /></td>
                <td rowspan="9">

                    <img src =" <?php echo $data['Stat']; ?>.png" style='width: 675px;;height: 450px;;'/>
                </td>
            </tr>
            <tr>
                <td><input class="button" name="set1" type="submit" form="set1" value="SET1" /></td>
            </tr>
            <tr>
                <td><input class="button" name="set2" type="submit" form="set2" value="SET2" /></td>
            </tr>
            <tr>
                <td><input class="button" name="set3" type="submit" form="set3" value="SET3" /></td>
            </tr>
            <tr>
                <td><input class="button" name="set4" type="submit" form="set4" value="SET4" /></td>
            </tr>
            <tr>
                <td><input class="button" name="set5" type="submit" form="set5" value="SET5" /></td>
            </tr>
            <tr>
                <td><input class="button" name="set6" type="submit" form="set6" value="SET6" /></td>
            </tr>
            <tr>
                <td><input class="button" name="set7" type="submit" form="set7" value="SET7" /></td>
            </tr>
            <tr>
                <td><input class="button" name="set8" type="submit" form="set8" value="SET8" /></td>

            </tr>
            <tr>
            </tr>
        </table>

        <h3> 
        <video width="320" height="240" controls>
  <source src="BLINDS.mp4" type="video/mp4">
Your browser does not support the video tag.
</video> 
        
        
        <h3>
  </body>

</html>