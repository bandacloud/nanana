<?php
//variables used in connection
$port='localhost';
$username='root';
$password='';
$database='tms';

//PROJECT_API_KEY is the exact duplicate of, PROJECT_API_KEY in NodeMCU sketch file
//Both values must be same
define('PROJECT_API_KEY', 'wt9mhker');

//set time zone for your country
date_default_timezone_set('Africa/Blantyre');

//creating query
$conn=mysqli_connect($port,$username,$password,$database);
//checking if the query has run successfully
if(!$conn)
{
	die('could not connect'.'<br>'.mysqli_connect_error());
}
?>