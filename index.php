<?php
session_start();
include('db_class.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Graphiques</title>
</head>
<?php


$sql = "SELECT weather FROM Entries";
$results = $db->query($sql);
$row = end($results->fetchArray());


$sql2 = "SELECT Image FROM Images WHERE idImage = '".$row['weather']."' ";
$results2 = $db->query($sql2);
$row2 = $results2->fetchArray();

?>
<style>
body {
    background-image : url(<?php echo '"'.$row2['Image'].'"'; ?> )
}
</style>
<body>
    <h1>Générer des graphiques</h1>
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
        <br>
        <br>
        <input type="submit"/>
    </form>




</body>
</html>
