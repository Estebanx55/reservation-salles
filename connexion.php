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
    <h1>Connexion</h1>
    <form action="" method="post">
        <label for="login">Login: </label>
        <input type="text" name="login" id="login">
        <label for="password">Mot de passe: </label>
        <input type="password" name="password" id="password">
        <input type="submit" name="envoyer" value="Envoyer">
    </form>

    <?php
    $connexion = mysqli_connect("localhost", "root", );
    mysqli_select_db($connexion, "reservationsalles") or die(mysqli_error($connexion));
    if (isset($_POST["envoyer"])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        // var_dump($login);
        // var_dump($password);
        $sql = "SELECT * FROM utilisateurs WHERE login = '$login'";
        $resultAll = mysqli_query($connexion, $sql);
        if (mysqli_num_rows($resultAll) > 0) {
            
            $sqlPassword = "SELECT * FROM utilisateurs WHERE password = '$password' AND login = '$login'";
            $resultPassword = mysqli_query($connexion, $sqlPassword);
            if (mysqli_num_rows($resultPassword) > 0) {
                
                $sqlId = "SELECT id_utilisateur FROM utilisateurs WHERE login ='$login'";
                $resultId = mysqli_query($connexion, $sqlId);
                $id = mysqli_fetch_array($resultId);
                $_SESSION["id"] = $id["id_utilisateur"];
                $_SESSION["login"] = $login;
                // var_dump($_SESSION["login"]);
                // var_dump($_SESSION["id"]);
                header("location: index.php");
            } else {
                echo "Le mot de passe est incorrect.";
            }
        } 
        else {
            echo "Le login n'existe pas.";
        }
    }
    ?>
    <p>Vous n'êtes pas encore inscrit ? <a href="inscription.php">Inscrivez-vous !</a></p>
</body>

</html>