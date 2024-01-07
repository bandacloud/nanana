<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

 // Include data base connect class
 include "./connect.php";

//Creating Array for JSON response
$response = array();

// Check if we got the field from the user
if (isset($_GET['id'], $_GET['mode'])) {

    $id = $_GET['id'];
    $mode = $_GET['mode'];

    // Fire SQL query to update weather data by id
    $result = mysqli_query($conn, "UPDATE `gates` SET `mode`='$mode' WHERE `gid` = $id");

    // Check for succesfull execution of query and no results found
    if ($result) {
        // successfully updation of temp (temperature)
        $response["success"] = 1;
        $response["message"] = "Mode was successfully updated to $mode";

        // Show JSON response
        echo json_encode($response);
    } else {
        die(mysqli_error($conn));
    }
} else if (isset($_GET['id'], $_GET['direction'])) {
    $id = $_GET['id'];
    $direction = $_GET['direction'];

    // Fire SQL query to update weather data by id
    $result = mysqli_query($conn, "UPDATE `gates` SET `direction`='$direction' WHERE `gid` = $id");

    // Check for succesfull execution of query and no results found
    if ($result) {
        // successfully updation of temp (temperature)
        $response["success"] = 1;
        $response["message"] = "Direction was successfully updated to $direction";

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
