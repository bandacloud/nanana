<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'connect.php';

$date = strtotime(date("Y-m-d h:i:sa"));

//Creating Array for JSON response
$response = array();

// Check if we got the field from the user
if (isset($_GET['x'], $_GET['y'], $_GET['z'], $_GET['temperature'],$_GET['angular'])) {

    $x = $_GET['x'];
    $y = $_GET['y'];
    $z = $_GET['z'];
    $temp = $_GET['temperature'];
    $angular = $_GET['angular'];

    $sql = "INSERT INTO `sensor_data` (`x`,`y`,`z`,`temp`,`stamp`,`angular`) VALUES('$x','$y','$z','$temp','$date','$angular')";

    // Fire SQL query to insert data in weather
    $result = mysqli_query($conn, $sql);

    // Check for succesfull execution of query
    if ($result) {
        // successfully inserted 
        $response["success"] = 1;
        $response["message"] = "Sensor_Data successfully added";

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
