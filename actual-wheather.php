<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
    <?php 
    include('nav.php');
    include('db_class.php');

$db = new MyDB();

$date = date('Y-m-d');

$sql = "SELECT * FROM Entries WHERE date = '".$date."' ";
$result = $db->query($sql);
$row = $results->fetchArray();

echo $row[];

    
    
?>
</body>
</html>