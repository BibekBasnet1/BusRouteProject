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

        // to set the student bus number to null
        $query = $db_connection->db_connection()->prepare("UPDATE STUDENT SET bus = NULL WHERE bus = $deleteId");
        // $query->bindValue(':bus',$deleteId);
        $query->execute();
 
        // setting route bus_id to null
        $route = $db_connection->db_connection()->prepare("UPDATE ROUTES SET bus_id = NULL WHERE bus_id = :bus_id");
        $route->bindValue(':bus_id',$deleteId);
        $route->execute();

        // deleteing the record bus
        $stmt = $db_connection->db_connection()->prepare("DELETE FROM bus WHERE bus_id = :bus_id");
        $stmt->bindValue(':bus_id', $deleteId);
        $stmt->execute();
        
        
    
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


