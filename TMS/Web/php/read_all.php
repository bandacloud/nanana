<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


//Creating Array for JSON response
$response = array();
 
// Include data base connect class
include "./connect.php";
 
 // Fire SQL query to get all data from weather
$result = mysqli_query($conn,"SELECT * FROM `sensor_data`") or die(mysqli_error($conn));
 
// Check for succesfull execution of query and no results found
if (mysqli_num_rows($result) > 0) {
    
	// Storing the returned array in response
    $response["tms"] = array();
 
	// While loop to store all the returned response in variable
    while ($row = mysqli_fetch_array($result)) {
        // temporary user array
        $tms = array();
        $tms["sid"] = $row["sid"];
		$tms["v1"] = $row["v1"];
		$tms["v2"] = $row["v2"];
        $tms["v3"] = $row["v3"];
        $tms["c1"] = $row["c1"];
        $tms["c2"] = $row["c2"];
        $tms["c3"] = $row["c3"];
        $tms["stamp"] = date('H:i:s',$row["stamp"]);

		// Push all the items 
        array_push($response["tms"], $tms);
    }
    // On success
    $response["success"] = 1;
 
    // Show JSON response
    echo json_encode($response);
}	
else 
{
    // If no data is found
	$response["success"] = 0;
    $response["message"] = "No data on dht found";
 
    // Show JSON response
    echo json_encode($response);
}
