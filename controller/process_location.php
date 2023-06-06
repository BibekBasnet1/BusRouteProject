<?php

// require "../models/Database_Connection.php";
session_start();

require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

// check if roll_id session variable is set
if (isset($_SESSION["roll_id"])) {
    // get the roll_id value from the session variable
    $roll_id = $_SESSION["roll_id"];

} else {
    // if roll_id session variable is not set, redirect to login page
    header("Location: ../views/index.php");
    exit();
}

try {
    // Retrieve the form data
    $locationId = $_POST["location_number"];
    $locationName = $_POST["location_data"];
    $routeId = $_POST["route_number"];

    // Check if the roll_id exists in the students table
    $stmt = $db_connection->db_connection()->prepare("SELECT * FROM STUDENT WHERE roll_id = :roll_id");
    $stmt->bindValue(":roll_id", $roll_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // The roll_id exists in the students table, proceed with inserting the new row

        // Perform the database operation (e.g., insert)
        $stmt = $db_connection->db_connection()->prepare("INSERT INTO LOCATIONS (location_id, location_name, route_id) VALUES (:location_id, :location_name, :route_id)");
        $stmt->bindValue(":location_id", $locationId);
        $stmt->bindValue(":location_name", $locationName);
        $stmt->bindValue(":route_id", $routeId);
        $stmt->execute();

        assignLocationAndBusToStudent();

        // Redirect back to the original page after the database operation is done
        header("Location: ../views/location_dashboard.php");
        exit();
    } else {
        // The roll_id does not exist in the students table, handle the error
        // You can redirect to an error page or display an error message
        throw new Exception("Error: Invalid roll_id");
    }
} catch (Exception $e) {
    // Handle the exception/error
    // You can redirect to an error page or display an error message
    echo "Error: " . $e->getMessage();
}

// Function to update the bus column in the STUDENT table
// Function to update the location_id and assign bus to student in the STUDENT table
function assignLocationAndBusToStudent(): void
{
    $db_connection = new \models\Database_Connection();

    // Update the location_id in the STUDENT table based on the address
    $updateLocationQuery = "UPDATE STUDENT s
                            INNER JOIN LOCATIONS l ON s.address = l.location_name
                            SET s.location_id = l.location_id";
    $updateLocationStmt = $db_connection->db_connection()->prepare($updateLocationQuery);
    $updateLocationStmt->execute();

    // Update the bus column in the STUDENT table based on the location_id
    $updateBusQuery = "UPDATE STUDENT s
                       INNER JOIN LOCATIONS l ON s.location_id = l.location_id
                       INNER JOIN ROUTES r ON l.route_id = r.route_id
                       INNER JOIN bus b ON r.bus_id = b.bus_id
                       SET s.bus = b.bus_num";
    $updateBusStmt = $db_connection->db_connection()->prepare($updateBusQuery);
    $updateBusStmt->execute();
}
