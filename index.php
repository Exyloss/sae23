<html>
<body>
    <h1>Température à Mont-de-Marsans</h1>
<?php

class MyDB extends SQLite3 {
    function  __construct(){
        $this->open('bdd.db');
    }
}
$db = new MyDB();

$sql = "SELECT * FROM Entries;";
$result = $db->query($sql);

    echo '<table>';

    $doublerow = true;

while ($row = $result->fetchArray()) {
    echo '<tr>';

    $columnCount = count($row);

    for ($i = 0; $i < $columnCount; $i++) {

        echo '<td>'.$row[$i].'</td>';
    }

    echo '</tr>';

    $doublerow = false;
}
echo '</table>';

$db->close();
?>

</body>
</html>
