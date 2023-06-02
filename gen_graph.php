<?php
session_start();

$sid = session_id();
$message = exec("/usr/bin/python3 graph.py --file ".$sid.".png");
$data = file_get_contents($sid.".png");
$_SESSION['graph'] = base64_encode($data);
header("location: graph.php");
?>
