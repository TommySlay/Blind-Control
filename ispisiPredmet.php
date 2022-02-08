<?php

require_once("dbconfig.php");

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

session_start();
$id = $_SESSION['id'];
$idKolegija = $_GET['idKolegija'];

$stmt = $conn->prepare("delete from KolegijiStudenata where idStudenta=$id AND idKolegija=$idKolegija;");
$stmt->execute();
$data = $stmt->fetchAll();

header('Location: pocetnaStudent.php');

$conn = null;

?>