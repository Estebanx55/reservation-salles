<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <h1>Mon site de reservation</h1>

    <?php
    if (isset($_SESSION["login"])) {
        echo "</br>";
        echo '<button type="button"><a class="button" href="profil.php">Profil</a></button>';
    } else {
        echo '<h2>Ici, vous pouvez réserver des salles en vous inscrivant sur mon site. Voici le lien pour vous <a href="inscription.php">inscrire</a>. Si vous
        êtes déjà inscrit, <a href="connexion.php">connectez-vous</a>.
    </h2>';
    }

    ?>
    <button><a class="button" href="planning.php">Planning</a></button>
    <button><a class="button" href="reservation-form.php">Faire une reservation</a></button>
</body>

</html>