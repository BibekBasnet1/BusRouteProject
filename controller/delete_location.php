<?php
require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

// Retrieve the location_id to be deleted
$locationId = $_POST["location_id"];

try {
    // Update the STUDENT table to set the location_id column to NULL where it matches the location_name
    $stmt = $db_connection->db_connection()->prepare("UPDATE STUDENT SET location_id = NULL , bus = NULL WHERE location_id IN (SELECT location_id FROM LOCATIONS WHERE location_id = :location_id)");
    $stmt->bindValue(":location_id", $locationId);
    $stmt->execute();

    // Delete the row from the LOCATIONS table
    $stmt = $db_connection->db_connection()->prepare("DELETE FROM LOCATIONS WHERE location_id = :location_id");
    $stmt->bindValue(":location_id", $locationId);
    $stmt->execute();

    // Redirect back to the original page after the deletion is done
    header("Location: ../views/location_dashboard.php");
    exit();
} catch (Exception $e) {
    // Handle the exception/error
    echo "Error: " . $e->getMessage();
}

