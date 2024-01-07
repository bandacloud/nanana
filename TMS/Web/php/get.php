<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'connect.php';

$date = strtotime(date("Y-m-d h:i:sa"));

//Creating Array for JSON response
$response = array();

// Check if we got the field from the user
if (isset($_GET['v1'], $_GET['v2'], $_GET['v3'],$_GET['c1'],$_GET['c2'],$_GET['c3'])) {

    $v1 = $_GET['v1'];
    $v2 = $_GET['v2'];
    $v3 = $_GET['v3'];

    $c1 = $_GET['c1'];
    $c2 = $_GET['c2'];
    $c3 = $_GET['c3'];
   

    $sql = "INSERT INTO `sensor_data` (`v1`,`v2`,`v3`,`c1`,`c2`,`c3`,`stamp`) VALUES('$v1','$v2','$v3','$c1','$c2','$c3','$date')";

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
