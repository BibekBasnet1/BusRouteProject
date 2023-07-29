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


