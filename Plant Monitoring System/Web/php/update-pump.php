<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Creating Array for JSON response
$response = array();
 
// Check if we got the field from the user
if (isset($_GET['id'],$_GET['status'])) {
 
    $id = $_GET['id']; 
    $status = $_GET['status']; 
 
    // Include data base connect class
	include "./connect.php";

	// Fire SQL query to update weather data by id
    $result = mysqli_query($conn,"UPDATE `pump` SET `status`= '$status' WHERE `pid` = $id");
 
    // Check for succesfull execution of query and no results found
    if ($result) {
        // successfully updation of temp (temperature)
        $response["success"] = 1;
        $response["message"] = "Pump Data successfully updated to $status";
 
        // Show JSON response
        echo json_encode($response);
    } else {
        die(mysqli_error($conn));
    }
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // Show JSON response
    echo json_encode($response);
}
?>