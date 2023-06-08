<?php
session_start();
include('db_class.php');
$db = new MyDB();

$sql = $db->query("SELECT weather FROM Entries;")->fetchArray(SQLITE3_NUM);
$weather = end($sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <div class="nav_bar">
            <a href="index.php">Accueil</a>
            <a href="actual-weather.php">Temps du jour</a>
            <a href="graph.php">Génerer un graphe</a>
        </div>
    </body>
</html>
