<?php


session_start();
// setting up the connection
require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

if (isset($_POST['submit'])) {
    try {

        $bus_num = $_POST['bus_num'];
        $driver_name = $_POST['driver_name'];

        // First, prepare the SQL query with a placeholder
        $checkBus = $db_connection->db_connection()->prepare("SELECT * FROM bus WHERE bus_num = :bus_num");

        // Bind the parameter value (bus_num)
        $checkBus->bindParam(':bus_num', $bus_num, PDO::PARAM_STR);

        // Execute the query
        $checkBus->execute();

        // Fetch the results (you can use fetchAll() if you expect multiple rows)
        $result = $checkBus->fetch(PDO::FETCH_ASSOC);

        // Check if the query returned any rows
        if ($result !== false) {
            // Bus number already exists, redirect with an error message
            header("Location: ../views/bus_section.php?error=BusAlreadyExist");
            echo "<script>toastr.warning('Bus Already Exist')</script>";
            exit();
        }



        // setting up the database connection
        $connection = $db_connection->db_connection()->prepare("INSERT INTO bus (bus_num, driver_name)
    VALUES (:bus_num , :driver_name)");
        $connection->bindParam(':bus_num', $bus_num);
        $connection->bindValue(':driver_name', $driver_name);
        $connection->execute();

        // Return a success response
        // echo json_encode([
        // 'success' => true
        // ]);
        header("Location: ../views/bus_section.php");
        exit();
    } catch (Exception $e) {
        // Return an error response
        // echo json_encode([
        //     'success' => false,
        //     'message' => 'Update failed: ' . $e->getMessage()
        // ]);
        header("Location : ../views/bus_section.php");
        exit();
    }
}
