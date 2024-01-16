<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: connexion.php');
}

echo "<button type='button'><a class='button' href='planning.php'>Planning</a></button></br>";

$id = (int) $_REQUEST['id'];

$connexion = mysqli_connect("localhost", "root", "");

mysqli_select_db($connexion, 'reservationsalles');

$sql = "SELECT * FROM reservations NATURAL JOIN utilisateurs WHERE id = $id";

$result = mysqli_query($connexion, $sql);

$reservation = mysqli_fetch_assoc($result);

// var_dump($reservation);

echo "<h1>Titre: " . $reservation['titre'] . "</h1>";

echo "<h2>Information de la réservation : </h2>" . "</br>";

echo "<p>Description -" . $reservation['description'] . "-</p></br>";

echo "<p>Heure de début -" . $reservation['debut'] . "-</p></br>";

echo "<p>Heure de fin -" . $reservation['fin'] . "-</p></br>";

echo "<p>Fait par -" . $reservation['login'] . "-</p></br>";

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

</body>

</html>