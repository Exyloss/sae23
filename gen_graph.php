<?php
session_start();

$sid = session_id();

if (! isset($_POST['champ'])) {
    header('location: graph.php');
    exit;
}

$delta = 0;
if ($_POST['day'] !== '' and $_POST['delta'] !== '') {
    $duree = 'day';
    $delta = $_POST['delta'];
} else if ($_POST['month'] !== '') {
    $duree = 'month';
} else if ($_POST['year'] !== '') {
    $duree = 'year';
} else {
    header('location: graph.php');
    exit;
}

$cmd = "/usr/bin/python3 graph.py --file ".$sid.".png --".$duree." ".$_POST[$duree]." --champ ".$_POST['champ']. " --delta ".$delta;
$message = exec($cmd);

$data = file_get_contents($sid.".png");
$_SESSION['graph'] = base64_encode($data);
exec("/bin/rm ".$sid);
header("location: graph.php");
?>
