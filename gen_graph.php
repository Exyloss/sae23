<?php
session_start();

$sid = session_id();

function rm_reg($string) {
    $pattern = '/[^a-zA-Z0-9-_]/';
    $replacement = '';
    return preg_replace($pattern, $replacement, $string);
}

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

$cmd = "/usr/bin/python3 graph.py --file ".$sid.".png --".rm_reg($duree)." ".rm_reg($_GET[$duree])." --champ ".$_GET['champ']. " --delta ".rm_reg($delta)." --output dic";
$message = exec($cmd);

$_SESSION['last_form'] = array(
    "day" => $_GET['day'],
    "delta" => $_GET['delta'],
    "month" => $_GET['month'],
    "year" => $_GET['year'],
    "field" => $_GET['champ']
);
$_SESSION['graph'] = $message;
header("location: graph.php");
?>
