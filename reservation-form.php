<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <button type="button"><a class="button" href="index.php">Accueil</a></button>
    <h2>Create Event</h2>

    <form action="" method="post">
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" required maxlength="255">
        <br>
        <p>Les horaires entre 8:00 et 19:00 prennent en compte l'heure d'entrée pour la planification.</p>
        <label for="debut">Heure d'entrée:</label>
        <input type="datetime-local" id="debut" name="debut" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>
        <br>
        <button type="submit">Submit</button>
    </form>

</body>

</html>

<?php
if (!isset($_SESSION['login'])) {
    header('Location: inscription.php');
}
$connexion = mysqli_connect("localhost", "root", );
mysqli_select_db($connexion, "reservationsalles");

if (isset($_POST["titre"]) && isset($_POST["debut"]) && isset($_POST["description"])) {
    $titre = $_POST["titre"];
    $debut = $_POST["debut"];
    $date = new DateTime($debut);
    $date->add(new DateInterval('PT1H'));
    $fin = $date->format('Y-m-d H:i:s');
    $description = $_POST["description"];
    $id = $_SESSION["id"];
    $sqlVerify = "SELECT debut FROM reservations WHERE debut = '" . $_POST["debut"] . "';";
    $resultVerify = mysqli_query($connexion, $sqlVerify);
    $debutVerify = mysqli_fetch_assoc($resultVerify);
    if ($debutVerify > 0) {
        echo "Date déjà utilisée";
    } else {
        $sql = "INSERT INTO `reservations` (`titre`, `debut`, `fin`, `description`, `id_utilisateur`) VALUES ('$titre', '$debut', '$fin', '$description', '$id')";
        $result = mysqli_query($connexion, $sql);
        header('Location: planning.php');
    }
}