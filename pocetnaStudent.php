<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naslovna stranica</title>
</head>
<body>
  <?php
    session_start();
    echo "<h1> Student " . $_SESSION["imeKorisnika"] . " " . $_SESSION["prezimeKorisnika"]  . "</h1>";
  ?>
  <p>Upisivanje kolegija</p>
  <form method="POST">
    <select name="kolegij" id="kolegij">
      <?php
        require_once("dbconfig.php");

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $stmt = $conn->prepare("select id, imeKolegija from Kolegiji;");
        $stmt->execute();
        $data = $stmt->fetchAll();
        
        foreach ($data as $row) {
          echo "<option value=" . $row['id'] . ">" . $row['imeKolegija'] . "</option>";
        }

        $conn = null;
      ?>
    </select>
    <input type="submit" value="Upiši me na kolegij" name="upisKolegija">
  </form>

  <?php
    if(isset($_POST['upisKolegija'])) {
        $idKolegija = $_POST['kolegij'];

        require_once("dbconfig.php");

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $idStudenta = $_SESSION['id'];

        try {
          $stmt = $conn->prepare("insert into KolegijiStudenata (idStudenta, idKolegija) values ($idStudenta, $idKolegija);");
          $data = $stmt->execute();
          echo "<p style='color:green'>Termin je dodan</p>"; 
        }catch (Exception $e) {
          echo "<p style='color:red'>Nuespješno dodavanje termina</p>";
        }
    }
  ?>

  <p>Moji kolegiji</p>
  <table name="student" id="student">
    <tr>
        <th>Ime kolegija</th>
        <th></th>
    </tr>
  <?php
        require_once("dbconfig.php");

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $id = $_SESSION['id'];

        $stmt = $conn->prepare("select id, imeKolegija from Kolegiji left join KolegijiStudenata on idKolegija=Kolegiji.id where idStudenta=$id");
        $stmt->execute();
        $data = $stmt->fetchAll();

        foreach ($data as $row) {
          echo "<tr> <td>" . $row['imeKolegija'] . "</td>" . 
            "<td><a href='ispisiPredmet.php?idKolegija=" . $row['id'] . "'>Ispiši</a></td></tr>";
        }
        $conn = null;
    ?>
  </table>
  <br> 
  <p>Prisutstvo</p>
  <table name="student" id="student">
    <tr>
        <th>Ime kolegija</th>
        <th>Početak</th>
        <th>Kraj</th>
    </tr>
  <?php
        require_once("dbconfig.php");

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $id = $_SESSION['id'];

        $stmt = $conn->prepare("select imeKolegija, pocetak, kraj from PrisutnosNaTerminu left join TerminiNastave on 
          idTermina=TerminiNastave.id left join Kolegiji on idKolegija=kolegiji.id where idStudenta=$id");
        $stmt->execute();
        $data = $stmt->fetchAll();

        foreach ($data as $row) {
          echo "<tr> <td>" . $row['imeKolegija'] . "</td>" . 
            "<td>" . $row['pocetak'] . "</td>" .
            "<td>" . $row['kraj'] . "</td>" . "</tr>";
        }
        $conn = null;
    ?>
  </table>
  <br>   

  <form action="index.html">
    <input type="submit" value="Odjava">
  </form> 

</body>
</html>