<?php
session_start();
$_SESSION['last_form'] = array(
    "day" => "",
    "delta" => "",
    "month" => "",
    "year" => "",
    "field" => ""
);
unset($_SESSION['graph']);
header('location: graph.php');
?>
