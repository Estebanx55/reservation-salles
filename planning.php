<?php
session_start();

echo "<button><a class='button' href='index.php'>Accueil</a></button>";
$connexion = mysqli_connect("localhost", "root", "");
mysqli_select_db($connexion, 'reservationsalles');
$currentDate = date('Y-m-d');
$weekEnd = date('Y-m-d', strtotime('+6 days'));
$sql = "SELECT debut, id, fin FROM reservations WHERE debut BETWEEN '$currentDate 08:00:00' AND '$weekEnd 19:00:00'";
$result = mysqli_query($connexion, $sql);
$reservations = mysqli_fetch_all($result);
$hour = 8;
date_default_timezone_set('Europe/Paris');
$currentDate = new DateTime();
$startDate = clone $currentDate;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
<?php
echo '<table>';
echo '<tr>';
echo '<th>Heures</th>';

for ($d = 0; $d < 7; $d++) {
    echo '<th>' . $startDate->format('l') . ": " . $startDate->format('Y-m-d') . "</th>";
    $startDate->add(new DateInterval('P1D'));
}
echo '</tr>';

for ($h = 8; $h < 19; $h++) {
    echo '<tr>';
    $m = ($h + 1);
    echo "<td>$h:00 - " . $m . ':00</td>';
    $startDate = clone $currentDate;

    for ($d = 0; $d < 7; $d++) {
        echo '<td>';
        $day = $startDate->format('l');
        if ($day == 'Saturday' or $day == 'Sunday') {
            echo '<div class="weekeend">&nbsp</br>';
            echo '&nbsp</br>';
            echo '&nbsp</br></div>';
        }
        if ($h < 10) { 
        $currentDateTime = $startDate->format('Y-m-d') . " 0$h:00:00";
        // $currentDateTime2 = $startDate->format('Y-m-d') . " 0$m:00:00";
        } else {
        $currentDateTime = $startDate->format('Y-m-d'). " $h:00:00";
        // $currentDateTime2 = $startDate->format('Y-m-d'). " $m:00:00";
        }
        foreach ($reservations as $reservation) {
            if ($reservation[0] == $currentDateTime) {
                if ((isset($_SESSION['login']))) {
                    echo '<a href="reservation.php?id=' . $reservation['1'] . ' "><button class="link">';
                    echo 'Reserve' . '</br>';
                    echo 'Info</button></a>';
                } else {
                    echo '<button class="link">';
                    echo 'Reserve' . '</br>';
                    echo 'Connectez-vous pour avoir plus d\'informations</button>';
                }
            }   
        }
        echo '</td>';
        $startDate->add(new DateInterval('P1D'));
    }
    echo '</tr>';
}
echo '</table>';
?>
</body>

</html>