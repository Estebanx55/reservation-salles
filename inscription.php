<?php
session_start();

if (isset($_SESSION["login"])) {
    header("location: profil.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <h1>Inscription</h1>
    <form method="post">
        <label for="login">Votre login: </label>
        <input type="text" name="login" id="login" required>
        <label for="password">Mot de passe: </label>
        <input type="password" name="password" id="password" required>
        <label for="passwordConfirm">Verfication mot de passe: </label>
        <input type="password" name="passwordConfirm" id="passwordConfirm" required>
        <input type="submit" name="envoyer" value="Envoyer">
    </form>
    <?php
    $connexion = mysqli_connect('localhost', 'root');
    mysqli_select_db($connexion, 'reservationsalles');

    if (isset($_POST["envoyer"])) {
        $login = $_POST["login"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["passwordConfirm"];
        $sqlVerify = "SELECT * FROM utilisateurs WHERE login = '$login';";
        $resultVerify = mysqli_query($connexion, $sqlVerify);
        if (mysqli_num_rows($resultVerify) > 0) {
            echo "Le login est déjà utilisé.";
        } else {
            if ($password === $confirmPassword) {
                $sql = "INSERT INTO `utilisateurs` (`login`, `password`) VALUES ('$login', '$password');";
                $result = mysqli_query($connexion, $sql);
                header("location: connexion.php");
            } else {
                echo "Les deux mots de passe ne correspondent pas.";
            }
        }
    }
    ?>
    <p>Déjà inscrit ? <a href="connexion.php">Connectez-vous !</a></p>
</body>

</html>