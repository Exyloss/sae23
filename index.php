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
    <h1 class="text">Accueil</h1>
<p class="text">
Bienvenue sur notre site de génération de graphes météorologiques, votre source en ligne pour des visualisations météorologiques précises et attrayantes. Que vous soyez un amateur de météorologie passionné, un professionnel du secteur ou simplement curieux de connaître les conditions météorologiques, notre site vous offre une expérience graphique immersive pour explorer et comprendre les données météorologiques.
<br>
<br>
Notre générateur de graphes météorologiques utilise les données en temps réel provenant de sources météorologiques fiables et les transforme en graphiques interactifs et visuellement captivants. Vous pouvez sélectionner une ville, une région ou même un emplacement spécifique pour obtenir des informations météorologiques détaillées, présentées sous forme de graphiques clairs et informatifs.
<br>
<br>
Grâce à notre interface conviviale, vous pouvez personnaliser les graphes selon vos besoins. Choisissez parmi une variété de paramètres, tels que la température, la pression atmosphérique, l'humidité, la vitesse du vent et bien plus encore, pour créer des graphiques adaptés à vos intérêts spécifiques. Que vous souhaitiez observer les variations quotidiennes, les tendances hebdomadaires ou les changements saisonniers, notre générateur vous fournit les outils nécessaires pour visualiser les données météorologiques de manière claire et compréhensible.
</p>
</body>
</html>
