<?php
require 'connect.php';

$sql = "SELECT * FROM sensor_data ORDER BY Sid DESC";
$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));

$row = mysqli_fetch_array($result);

echo json_encode($row);
?>