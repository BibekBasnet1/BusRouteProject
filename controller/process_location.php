<?php

session_start();

require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

// Check if the roll_id session variable is set
if (!isset($_SESSION["roll_id"])) {
    // If roll_id session variable is not set, redirect to the login page
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
    $stmt->bindValue(":roll_id", $_SESSION["roll_id"]);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // The roll_id exists in the students table, proceed with inserting the new row

        // Check if the location ID or location name already exists
        $checkLocationQuery = "SELECT * FROM LOCATIONS WHERE location_id = :location_id OR location_name = :location_name";
        $checkLocationStmt = $db_connection->db_connection()->prepare($checkLocationQuery);
        $checkLocationStmt->bindValue(":location_id", $locationId);
        $checkLocationStmt->bindValue(":location_name", $locationName);
        $checkLocationStmt->execute();

        if ($checkLocationStmt->rowCount() > 0) {
            // The location ID or location name already exists, inform the user
            $errorMessage = "Location ID or location name already exists.";
            header("Location: ../views/location_dashboard.php?error=" . urlencode($errorMessage));
            exit();
        }

        // Perform the database operation (e.g., insert)
        $insertLocationQuery = "INSERT INTO LOCATIONS (location_id, location_name, route_id) VALUES (:location_id, :location_name, :route_id)";
        $insertLocationStmt = $db_connection->db_connection()->prepare($insertLocationQuery);
        $insertLocationStmt->bindValue(":location_id", $locationId);
        $insertLocationStmt->bindValue(":location_name", $locationName);
        $insertLocationStmt->bindValue(":route_id", $routeId);
        $insertLocationStmt->execute();

        assignLocationAndBusToStudent();

        // Redirect back to the original page after the database operation is done
        header("Location: ../views/location_dashboard.php");
        exit();
    } else {
        // The roll_id does not exist in the students table, handle the error
        $errorMessage = "Invalid roll_id.";
        header("Location: ../views/error.php?error=" . urlencode($errorMessage));
        exit();
    }
} catch (PDOException $e) {
    // Handle database errors
    $errorMessage = "Database Error: " . $e->getMessage();
    header("Location: ../views/error.php?error=" . urlencode($errorMessage));
    exit();
} catch (Exception $e) {
    // Handle other exceptions
    $errorMessage = "Error: " . $e->getMessage();
    header("Location: ../views/error.php?error=" . urlencode($errorMessage));
    exit();
}

// Function to update the bus column in the STUDENT table
// Function to update the bus_num column in the STUDENT table
function assignLocationAndBusToStudent(): void
{
    $db_connection = new \models\Database_Connection();

    // Update the location_id in the STUDENT table based on the address
    $updateLocationQuery = "UPDATE STUDENT s
                            INNER JOIN LOCATIONS l ON s.address = l.location_name
                            SET s.location_id = l.location_id";
    $updateLocationStmt = $db_connection->db_connection()->prepare($updateLocationQuery);
    $updateLocationStmt->execute();

    // Update the bus_num column in the STUDENT table based on the location_id
    $updateBusQuery = "UPDATE STUDENT s
                       INNER JOIN LOCATIONS l ON s.location_id = l.location_id
                       INNER JOIN ROUTES r ON l.route_id = r.route_id
                       INNER JOIN bus b ON r.bus_id = b.bus_id
                       SET s.bus = (
                           SELECT bus_num FROM bus WHERE bus.bus_id = b.bus_id
                       )";
    $updateBusStmt = $db_connection->db_connection()->prepare($updateBusQuery);
    $updateBusStmt->execute();
}

