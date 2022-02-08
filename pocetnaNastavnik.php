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
        echo "<h1> Nastavnik " . $_SESSION["imeKorisnika"] . " " . $_SESSION["prezimeKorisnika"]  . "</h1>";
    ?>
    <p>Dodaj studenta</p>
    <form method="POST">
        <input type="text" id="ime" name="ime" placeholder="Ime">
        <input type="text" id="prezime" name="prezime" placeholder="Prezime">
        <input type="text" id="zaporka" name="zaporka" placeholder="Zaporka">
        <input type="text" id="RFID" name="RFID" placeholder="RFID"><br><br>
        <input type="submit" value="Dodaj studenta" name="dodajStudenta">
    </form>

    <?php
        if(isset($_POST['dodajStudenta'])) {
            $ime = $_POST['ime'];
            $prezime = $_POST['prezime'];
            $zaporka = $_POST['zaporka'];
            $RFID = $_POST['RFID'];

            if(empty($ime) || empty($prezime) || empty($zaporka) || empty($RFID))
                echo "<p style='color:red'>Svi traženi podatci moraju biti uneseni</p>";
            else{
                require_once("dbconfig.php");

                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

                $stmt = $conn->prepare("insert into Korisnici (ime, prezime, zaporka, RFID, idUloge)  values ('$ime', '$prezime', '$zaporka', '$RFID', 1);");
                $data = $stmt->execute();
                
                if($data)
                    echo "<p style='color:green'>Student uspješno dodan</p>";    
                else
                    echo "<p style='color:red'>Pogrška prilikom unosa</p>";
                    
                $conn = null;
            }
        }
    ?>

    <p>Popis studenata</p>
    <table name="student" id="student">
        <tr>
            <th>Ime</th>
            <th>Prezime</th>
            <th></th>
        </tr>
        <?php
            require_once("dbconfig.php");

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            $stmt = $conn->prepare("select ime, prezime, id from Korisnici where idUloge=1;");
            $stmt->execute();
            $data = $stmt->fetchAll();
            
            foreach ($data as $row) {
                echo "<tr> <td>" . $row['ime'] . "</td>" . "<td>" . $row['prezime'] . "</td>" .
                    "<td><a href='obrisiStudenta.php?id=" . $row['id'] . "'>Obriši</a></td></tr>";
                }
            $conn = null;
        ?>
    </table>

    <form method="POST">
        <p>Dodaj temrin predavanja</p>
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
            ?>
        </select>
        <input type="datetime-local" id="pocetak" name="pocetak" placeholder="Početak">
        <input type="datetime-local" id="kraj" name="kraj" placeholder="Kraj"><br><br>
        <input type="submit" value="Dodaj termin" name="termin">
    </form>

    <?php
        if(isset($_POST['termin'])) {
            $idTermina = $_POST['kolegij'];
            $pocetak = $_POST['pocetak'];
            $kraj = $_POST['kraj'];

            require_once("dbconfig.php");

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            $stmt = $conn->prepare("insert into TerminiNastave (idKolegija, pocetak, kraj) values ($idTermina, '$pocetak', '$kraj'); ");
            $data = $stmt->execute();

            if($data)
                echo "<p style='color:green'>Termin je dodan</p>";    
            else
                echo "<p style='color:red'>Nuespješno dodavanje termina</p>";
        }
    ?>

    <br>
    <form action="index.html">
        <input type="submit" value="Odjava">
    </form> 

</body>
</html>