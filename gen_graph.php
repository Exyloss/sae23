<?php
session_start();

$sid = session_id();

if (! isset($_GET['champ'])) {
    header('location: graph.php');
    exit;
}

$delta = 0;
if ($_GET['day'] !== '' and $_GET['delta'] !== '') {
    $duree = 'day';
    $delta = $_GET['delta'];
} else if ($_GET['month'] !== '') {
    $duree = 'month';
} else if ($_GET['year'] !== '') {
    $duree = 'year';
} else {
    header('location: graph.php');
    exit;
}

$cmd = "/usr/bin/python3 graph.py --file ".$sid.".png --".$duree." ".$_GET[$duree]." --champ ".$_GET['champ']. " --delta ".$delta;
$message = exec($cmd);

$data = file_get_contents($sid.".png");
$_SESSION['graph'] = base64_encode($data);
exec("/bin/rm ".$sid);
header("location: graph.php");
?>
