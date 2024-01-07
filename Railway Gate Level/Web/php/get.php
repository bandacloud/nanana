<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'connect.php';

$date = date('G:i:s', time());

//Creating Array for JSON response
$response = array();
 
// Check if we got the field from the user
if (isset($_GET['gateStatus'])) {
 
    $gateStatus = $_GET['gateStatus'];
 
   	$sql = "UPDATE `gates` SET `status`= '$gateStatus' WHERE `gid`=1";

    // Fire SQL query to insert data in weather
    $result = mysqli_query($conn,$sql);
 
    // Check for succesfull execution of query
    if ($result) {
        // successfully inserted 
        $response["success"] = 1;
        $response["message"] = "Gate successfully updated.";
 
        // Show JSON response
        echo json_encode($response);
    } else {
        // Failed to insert data in database
        $response["success"] = 0;
        $response["message"] = "Something has been wrong";
 
        // Show JSON response
        echo json_encode($response);
    }
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // Show JSON response
    echo json_encode($response);
}
