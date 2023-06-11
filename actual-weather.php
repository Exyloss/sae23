<?php
session_start();
include('db_class.php');
$sid = session_id();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Graphiques</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <script src="https://cdn.plot.ly/plotly-2.24.2.min.js" charset="utf-8"></script>
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
    <div class="box">
<?php
$db = new MyDB();
$date = date('Y-m-d');
$values = $db->query("SELECT * FROM Champs;");
$div_id = 0;

while ($champ=$values->fetchArray()) {

    $cmd = "/usr/bin/python3 graph.py --day ".$date." --champ ".$champ['champ']. " --delta 60 --output dic";
    $message = exec($cmd);
    echo '<div id="'.$div_id.'"></div>';
    echo '<script>';
    echo 'var config = {';
    echo 'displayModeBar: true';
    echo '};';
    echo 'var layout = {';
    echo '  title: {';
    echo '      text: "'.$champ['nom'].' en fonction du temps",';
    echo '      font: {';
    echo '          size: 20';
    echo '      },';
    echo '      yref: "paper",';
    echo '      yanchor: "top"';
    echo '  },';
    echo '  autosize: false,';
    echo '  width: 500,';
    echo '  height: 500,';
    echo '  paper_bgcolor: \'#FFFFFF66\',';
    echo '  plot_bgcolor: \'#FFFFFF88\',';
    echo '  margin: {';
    echo '      l: 50,';
    echo '      r: 50,';
    echo '      b: 50,';
    echo '      t: 75,';
    echo '      pad: 4';
    echo '  }';
    echo '};';
    echo 'Plotly.newPlot("'.$div_id.'", /* JSON object */ {';
    echo '"data": ['.$message.'],';
    echo '"layout": layout,';
    echo '"config": config';
    echo '});';
    echo '</script>';
    $div_id = $div_id+1;
}

?>
</div>
</body>
</html>
