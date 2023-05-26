<?php
require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

if (isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];

    // Check if the user type is not "admin"
    $getUserTypeStmt = $db_connection->db_connection()->prepare("SELECT user_type FROM STUDENT WHERE roll_id = :id");
    $getUserTypeStmt->bindValue(':id', $deleteId);
    $getUserTypeStmt->execute();
    $userType = $getUserTypeStmt->fetchColumn();

    if ($userType !== 'admin') {
        // Delete associated records from other tables (e.g., locations, bus, route)
        // Modify the following code based on your table structure and foreign key relationships

        // Delete associated records from the "locations" table
        $deleteLocationsStmt = $db_connection->db_connection()->prepare("DELETE FROM STUDENT WHERE roll_id = :id");
        $deleteLocationsStmt->bindValue(':id', $deleteId);
        $deleteLocationsStmt->execute();

        // Refresh the page after a short delay
//        header("Location: ../views/admin_dashboard.php");
//        exit();

        // Perform any other actions or redirection after deletion if needed
    } else {
        // Handle the case where the user type is "admin" and deletion is not allowed
        // Display an error message or perform other actions as needed
        header("Location: ../views/admin_dashboard.php?error=cannotRemoveAdmin");
    }
}