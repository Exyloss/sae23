<?php
session_start();
include('db_class.php');
$db = new MyDB();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Graphiques</title>
</head>
<body>
    <h1>Générer des graphiques</h1>
    <form method="POST" action="gen_graph.php">
        <h2>Plotter un jour précis</h2>
        <input type="date" name="day"></input>
        <h2>Plotter un mois du type YYYY-MM</h2>
        <input type="month" name="month" />
        <h2>Plotter une année</h2>
        <input type="year" name="year" />
        <h2>Plotter quel champ ?</h2>
        <option name="champ">
<?php
$req = "SELECT * FROM Champs";
$reponse = $db->exec($req);
while ($donnees=$reponse->fetchArray()) {

}
?>
        </option>
        <input type="submit"/>
    </form>
<?php
if (isset($_SESSION['graph'])) {
    echo '<img src="data:image/png;base64, '.$_SESSION['graph'].'"/>';
}
?>
</body>
</html>
