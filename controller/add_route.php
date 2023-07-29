<?php
session_start();
require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

if (isset($_POST['submit'])) {
    try {
        $route_name = $_POST['route_name'];
        $bus_id = $_POST['bus_id'];
        $route_id = $_POST['route_id'];

        $connection = $db_connection->db_connection()->prepare("INSERT INTO ROUTES (route_id, route_name, bus_id) VALUES (:route_id, :route_name, :bus_id)");
        $connection->bindValue(':route_name', $route_name);
        $connection->bindValue(':bus_id', $bus_id);
        $connection->bindValue(':route_id', $route_id); // Corrected binding for route_id
        $connection->execute();

        header("Location: ../views/route.php");
        exit();

    } catch (Exception $e) {
        header("Location: ../views/route.php"); // Removed extra space after "Location"
        exit();
    }
}
?>
