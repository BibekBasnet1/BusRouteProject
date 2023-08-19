<?php


require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();



// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data sent by the client
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Validate and sanitize the data
    // $location_id = intval($requestData['location_id']);;
    $location_name = $requestData['location_name'];
    $route_id = intval($requestData['route_id']);;

    var_dump($location_id, $location_name, $route_id);
    // Perform the database update
    // Note: Replace this with your actual update query and database connection logic
    try {
        // Your database connection setup
        // $connection = new PDO(...);
        // Prepare the query to retrieve location_id
        $query = "SELECT location_id FROM LOCATIONS WHERE location_name = :location_name";

        // Create a new PDO statement
        $new_query = $db_connection->db_connection()->prepare($query);

        // Bind the location_name parameter
        $new_query->bindParam(':location_name', $location_name);

        // Execute the query
        $new_query->execute();

        // Fetch the result
        $result = $new_query->fetch(PDO::FETCH_ASSOC);

        // Check if a row was found
        if ($result) {
            // Extract the location_id from the result
            $extracted_location_id = $result['location_id'];

            // Now you can use $extracted_location_id for further processing
        } else {
            // No matching row found
            echo "Location not found.";
        }

        $sql = "UPDATE LOCATIONS SET location_name = :location_name, route_id = :route_id WHERE location_id = :location_id";
        $updateQuery = $db_connection->db_connection()->prepare($sql);
        $updateQuery->bindParam(':location_id', $extracted_location_id);
        $updateQuery->bindParam(':location_name', $location_name);
        $updateQuery->bindParam(':route_id', $route_id);


        // Execute the query
        if ($updateQuery->execute()) {
            // Prepare the response 
            $response = [
                'success' => true,
                'message' => 'Location updated successfully.'
            ];
        }
        // Prepare the response 
        $response = [
            'success' => false,
            'message' => 'something went wrong.'
        ];
    } catch (PDOException $e) {
        // Handle database errors
        $response = [
            'success' => false,
            'message' => 'Error updating location: ' . $e->getMessage()
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Invalid request method.'
    ];
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
