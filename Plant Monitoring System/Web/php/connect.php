<?php
//variables used in connection
$port='localhost';
$username='root';
$password='';
$database='plant_monitoring';
//creating query
$conn=mysqli_connect($port,$username,$password,$database);
//checking if the query has run successfully
if(!$conn)
{
	die('could not connect'.'<br>'.mysqli_connect_error());
}

?>