<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Page</title>
</head>
<body>
<?php
include 'ParseRozetka.php';

echo '<b>' . 'Working.....' . '</b>';

$rozetka = new ParseRozetka();
$rozetka->getPictures();
?>
</body>
</html>



