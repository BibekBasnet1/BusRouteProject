<?php
// session_start();

require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();



if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    try {
        // $delete_id = $_POST['delete_id'];
        $data = json_decode(file_get_contents('php://input'), true);

        $deleteId = $data['delete_id'];

        // var_dump($deleteId);

        $routeId = $db_connection->db_connection()->prepare("SELECT route_id FROM ROUTES WHERE bus_id = :bus_id"); 
        $routeId->bindValue(':bus_id', $deleteId);
        $routeId->execute();

        $routeId->fetch(PDO::FETCH_ASSOC);
        $id = 0;
        foreach($routeId as $route)
        {
            $id = $route;
        }

        // to delete the locations from the location table using routeId 
        $locationDelete = $db_connection->db_connection()->prepare("DELETE FROM LOCATIONS WHERE route_id = :route_id");
        $deleteRoutesQuery->bindValue(':route_id', $id);
        $deleteRoutesQuery->execute();

        // Delete routes associated with the bus
        $deleteRoutesQuery = $db_connection->db_connection()->prepare("DELETE FROM ROUTES WHERE bus_id = :bus_id");
        $deleteRoutesQuery->bindValue(':bus_id', $deleteId);
        $deleteRoutesQuery->execute();


        // Delete the bus record itself
        $deleteBusQuery = $db_connection->db_connection()->prepare("DELETE FROM bus WHERE bus_id = :bus_id");
        $deleteBusQuery->bindValue(':bus_id', $deleteId);
        $deleteBusQuery->execute();

        // Delete related student bus assignments if needed
        $deleteStudentQuery = $db_connection->db_connection()->prepare("UPDATE STUDENT SET bus = NULL WHERE bus = :bus_id");
        $deleteStudentQuery->bindValue(':bus_id', $deleteId);
        $deleteStudentQuery->execute();
        
    
        // echo "Affected rows: " . $stmt->rowCount(); // Debugging statement
        $response = [
            'success' => true,
            'message' => 'deleted successfully',
        ];

        echo json_encode($response);
      
        // exit(); // Ensure the script stops executing after redirection
    } catch (Exception $e) {
        $response = [
            'success' => false,
            'message' => 'Error deleting record: ' . $e->getMessage()
        ];
    
        echo json_encode($response);
    }
}


