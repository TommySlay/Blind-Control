<?php

require_once("dbconfig.php");

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

$id = $_GET['id'];

$stmt = $conn->prepare("delete from Korisnici where id='$id';");
$stmt->execute();
$data = $stmt->fetchAll();

header('Location: pocetnaNastavnik.php');

$conn = null;

?>