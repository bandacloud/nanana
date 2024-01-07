<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


//Creating Array for JSON response
$response = array();

// Include data base connect class
include "./connect.php";

// Fire SQL query to get all data from weather
$result = mysqli_query($conn, "SELECT * FROM `lackson` ") or die(mysqli_error($conn));

// Check for succesfull execution of query and no results found
if (mysqli_num_rows($result) > 0) {
    $response["lackson"] = array();
    $lackson = array();
    // While loop to store all the returned response in variable
    while ($row = mysqli_fetch_array($result)) {

        $lackson["lid"] = $row["lid"];
        $lackson["n"] = $row["n"];
        $lackson["p"] = $row["p"];
        $lackson["k"] = $row["k"];

        // Push all the items 
        array_push($response["lackson"], $lackson);
    }

    // On success
    $response["success"] = 1;

    // Show JSON response
    echo json_encode($response);
} else {
    // If no data is found
    $response["success"] = 0;
    $response["message"] = "No data on lackson found";

    // Show JSON response
    echo json_encode($response);
}
