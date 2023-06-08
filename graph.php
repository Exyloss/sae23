<?php
session_start();
include('db_class.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Graphiques</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<?php

$db = new MyDB();
$sql = "SELECT * FROM Entries;";
$results = $db->query($sql);
while ($donnees=$results->fetchArray()) {
    $last_weather=$donnees['weather'];
}

$sql2 = "SELECT Image FROM Images WHERE idImage='".$last_weather."';";
$results2 = $db->query($sql2);
$row2 = $results2->fetchArray()['Image'];

?>
<style>
body {
    background-image: url(<?php echo '"'.$row2.'"'; ?> );
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
}
form {
    background-color: rgba(255, 255, 255, .3);
    width: fit-content;
    padding: 10px;
    border-radius: 10px;
}
</style>
<body>
    <?php include('nav.php'); ?>
    <h1 class="text">Générer des graphiques</h1>
    <div class="box">
    <form method="GET" action="gen_graph.php">
        <h2>Plotter un jour précis</h2>
        <input type="date" name="day"></input> <br>
        <input type="text" name="delta"/>
        <h2>Plotter un mois du type YYYY-MM</h2>
        <input type="month" name="month" />
        <h2>Plotter une année</h2>
        <input type="year" name="year" />
        <h2>Plotter quel champ ?</h2>
        <select name="champ">
<?php
$db = new MyDB();
$req = "SELECT * FROM Champs";
$reponse = $db->query($req);

// On parcourt les catégories pour le menu déroulant
while ($donnees=$reponse->fetchArray())
{
    echo '<option value="'.$donnees['champ'].'">'.$donnees['nom'].'</option>';
}
?>
        </select>
        <input type="submit"/>
    </form>
<?php
if (isset($_SESSION['graph'])) {
    echo '<img class="graph" src="data:image/png;base64, '.$_SESSION['graph'].'"/>';
}
?>
</div>
</body>
</html>
