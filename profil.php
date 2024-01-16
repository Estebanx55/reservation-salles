<?php
session_start();

$connexion = mysqli_connect('localhost', 'root');
mysqli_select_db($connexion, 'reservationsalles');

// var_dump($_SESSION["login"]);
// var_dump($_SESSION["id"]);

if (!isset($_SESSION["id"])) {
    header("location: index.php");
} else {
    echo '<h1>' . "Hello " . $_SESSION["login"] . '</h1>';
}

$login = $_SESSION["login"];

if (isset($_SESSION["login"])) {
    $command = "SELECT * FROM utilisateurs WHERE login = '$login'";
    $result = mysqli_query($connexion, $command);

    echo "<table>";
    echo "<tr>";
    while ($fieldInfo = mysqli_fetch_field($result)) {
        echo "<th>" . $fieldInfo->name . "</th>";
    }
    echo "</tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <form method="post">
        <label for="login">Nouveau login :</label>
        <input type="text" name="login" id="login">
        <label for="password">Nouveau mot de passe :</label>
        <input type="password" name="password" id="password">
        <label for="passwordVer">Vérification du mot de passe :</label>
        <input type="password" name="passwordVer" id="passwordVer">
        <input type="submit" name="envoyer" value="Envoyer">
        <input type="submit" name="gg" value="Deconnexion">
    </form>



    <?php
    if (isset($_POST['envoyer'])) {
        if ($_POST["password"] != $_POST["passwordVer"]) {
            echo "Les deux mots de passe ne correspondent pas.";
            exit;
        }
        if ($_POST['password'] == "") {
        } else {
            $passwordPost = $_POST["password"];
            $sqlPassword = "UPDATE utilisateurs SET password ='$passwordPost' WHERE login='$login'";
            $resultPassword = mysqli_query($connexion, $sqlPassword);
            header("Location:" . $_SERVER['PHP_SELF']);
        }

        // echo "envoyer";
        if ($_POST['login'] == "") {
            // echo "vacio";
        } else {
            // echo "lleno";
            $loginPost = $_POST["login"];
            $sqlCheck = "SELECT * FROM utilisateurs WHERE login= '$loginPost'";
            $resultCheck = mysqli_query($connexion, $sqlCheck);
            if (mysqli_num_rows($resultCheck) > 0) {
                echo "Ce login est déjà utilisé.";
                // echo "si";
            } else {
                // echo "no";
                $loginPost = $_POST["login"];
                $sqlLogin = "UPDATE utilisateurs SET login ='$loginPost' WHERE login='$login'";
                $resultLogin = mysqli_query($connexion, $sqlLogin);
                $_SESSION["login"] = $loginPost;
                var_dump($login);
                header("Location:" . $_SERVER['PHP_SELF']);
            }
        }

    }
    if (isset($_POST["gg"])) {
        session_unset();
        session_destroy();
        header("Location:" . $_SERVER['PHP_SELF']);
    }
    ?>
    <button><a class="button" href="index.php">Accueil</a></button>
</body>

</html>