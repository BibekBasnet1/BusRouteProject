<?php
require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

// Retrieve the route_id to be deleted
if (isset($_POST["route_id"])) {
    try {
        // Delete the route
        $route_id = $_POST['route_id'];

        // to set null value on the location table 
        $locationTableRoute = $db_connection->db_connection()->prepare("UPDATE LOCATIONS SET route_id = NULL WHERE route_id =:route_id"); 
        $locationTableRoute->bindValue(':route_id',$route_id);
        $locationTableRoute->execute();

        // set null value for the student table too 
        $studentBusTable = $db_connection->db_connection()->prepare('UPDATE STUDENT AS s
        JOIN LOCATIONS AS l ON s.location_id = l.location_id
        SET s.bus = NULL
        WHERE l.route_id IS NULL');
        $studentBusTable->execute();


        // to set null value in the     

        $connection = $db_connection->db_connection()->prepare("DELETE FROM ROUTES WHERE route_id=:route_id");
        $connection->bindValue(':route_id', $route_id);
        $connection->execute();

        // Redirect back to the original page after the deletion is done
        header("Location: ../views/route.php");
        exit();
    } catch (Exception $e) {
        // Handle the exception/error
        echo "Error: " . $e->getMessage();
    }
}
?>
