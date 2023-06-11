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
    <h1 class="text">Données du jour</h1>
<?php
$db = new MyDB();
$date = date('Y-m-d');
$values = $db->query("SELECT * FROM Champs;");

while ($champ=$values->fetchArray()) {

    $cmd = "/usr/bin/python3 graph.py --file ".$sid.".png --day ".$date." --champ ".$champ['champ']. " --delta 60";
    $message = exec($cmd);

    $data = file_get_contents($sid.".png");
    echo '<img class="graph" src="data:image/png;base64, '.base64_encode($data).'/>';
    exec("/bin/rm ".$sid.".png");
}

?>
</div>
</body>
</html>
