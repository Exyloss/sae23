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
    background-image: url(<?php echo '"'.$row2.'"'; ?>);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
}
</style>
<body>
<?php
include('nav.php');
if (! isset($_SESSION['last_form'])) {
    $_SESSION['last_form'] = array(
        "day" => "",
        "delta" => "",
        "month" => "",
        "year" => "",
        "field" => ""
    );
}

?>
    <h1 class="text">Générer des graphiques</h1>
    <div class="box">
    <form method="GET" action="gen_graph.php" class="graph_form">
        <h2>Traçer un jour précis</h2>
        <label for="day">Jour</label><br>
        <input class="form_input" type="date" name="day" value="<?php echo $_SESSION['last_form']['day']; ?>"/> <br><br>
        <label for="delta">Intervalle entre les mesures (en minutes)</label><br>
        <input class="form_input" type="text" name="delta" value="<?php echo $_SESSION['last_form']['delta']; ?>"/>
        <h2>Traçer un mois du type YYYY-MM</h2>
        <label for="month">Mois (YYYY-MM)</label><br>
        <input class="form_input" type="month" name="month" value="<?php echo $_SESSION['last_form']['month']; ?>"/>
        <h2>Traçer une année</h2>
        <label for="year">Année (YYYY)</label><br>
        <input class="form_input" type="year" name="year" value="<?php echo $_SESSION['last_form']['year']; ?>"/>
        <h2>Mesurer quelle donnée ?</h2>
        <select class="form_input" name="champ">
<?php
$db = new MyDB();
$req = "SELECT * FROM Champs";
$reponse = $db->query($req);
// On parcourt les catégories pour le menu déroulant
while ($donnees=$reponse->fetchArray())
{
    $selected = $_SESSION['last_form']['field'] == $donnees['champ'] ? 'selected' : '';
    echo '<option value="'.$donnees['champ'].'" '.$selected.'>'.$donnees['nom'].'</option>';
}
?>
        </select><br><br>
        <input class="form_button" type="submit" />
        <a class="form_button" href="clear_graph.php">Effacer</a>
    </form>
<?php
if (isset($_SESSION['graph']) and $_SESSION['last_form']['field'] !== '') {
    $plot_field = $db->query("SELECT nom FROM Champs WHERE champ='".$_SESSION['last_form']['field']."'")->fetchArray()['nom'];
    echo '<div id="gd"></div>';
    echo '<script>';
    echo 'const config = {';
    echo 'displayModeBar: true';
    echo '};';
    echo 'const layout = {';
    echo '  title: {';
    echo '      text: "'.$plot_field.' en fonction du temps",';
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
    echo 'Plotly.newPlot("gd", /* JSON object */ {';
    echo '"data": ['.$_SESSION['graph'].'],';
    echo '"layout": layout,';
    echo '"config": config';
    echo '});';
    echo '</script>';
}
?>
</div>
</body>

</html>
