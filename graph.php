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
    <form method="GET" action="gen_graph.php">
        <h2>Plotter un jour précis</h2>
        <label for="day">Jour</label><br>
        <input type="date" name="day" value="<?php echo $_SESSION['last_form']['day']; ?>"/> <br><br>
        <label for="delta">Intervalle entre les mesures (en minutes)</label><br>
        <input type="text" name="delta" value="<?php echo $_SESSION['last_form']['delta']; ?>"/>
        <h2>Plotter un mois du type YYYY-MM</h2>
        <label for="month">Mois (YYYY-MM)</label><br>
        <input type="month" name="month" value="<?php echo $_SESSION['last_form']['month']; ?>"/>
        <h2>Plotter une année</h2>
        <label for="year">Année (YYYY)</label><br>
        <input type="year" name="year" value="<?php echo $_SESSION['last_form']['year']; ?>"/>
        <h2>Plotter quel champ ?</h2>
        <select name="champ">
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
        <input type="submit" />
        <input type="reset" />
    </form>
<?php
if (isset($_SESSION['graph']) and isset($_SESSION['graph_type'])) {
    if ($_SESSION['graph_type'] == 'base64') {
        echo '<img class="graph" src="data:image/png;base64, '.$_SESSION['graph'].'"/>';
    } else {
        echo '<div id="gd"></div>';
        echo '<script>';
        echo 'const config = {';
        echo 'displayModeBar: true';
        echo '};';
        echo 'const layout = {';
        echo 'autosize: false,';
        echo 'width: 500,';
        echo 'height: 500,';
        echo 'paper_bgcolor: \'#FFFFFF00\',';
        echo 'plot_bgcolor: \'#FFFFFF88\',';
        echo 'margin: {';
        echo 'l: 50,';
        echo 'r: 50,';
        echo 'b: 100,';
        echo 't: 100,';
        echo 'pad: 4';
        echo '}';
        echo '};';
        echo 'Plotly.newPlot("gd", /* JSON object */ {';
        echo '"data": ['.$_SESSION['graph'].'],';
        echo '"layout": layout,';
        echo '"config": config';
        echo '});';
        echo '</script>';
    }
}
$_SESSION['last_form'] = array(
    "day" => "",
    "delta" => "",
    "month" => "",
    "year" => "",
    "field" => ""
);
?>
</div>
</body>

</html>
