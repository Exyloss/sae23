<?php
// On définit la classe de la base de données. Ce script sera appelé par chaque programme qui utilise la bdd
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('bdd.db');
    }
}
?>
