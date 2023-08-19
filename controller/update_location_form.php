<?php
// session_start();

require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();



if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    try {
        // $delete_id = $_POST['delete_id'];
        $data = json_decode(file_get_contents('php://input'), true);
        $updateId = $data['updateId'];

        // Get the detail of the bus with the specified ID
        $query = $db_connection->db_connection()->prepare("SELECT * FROM LOCATIONS WHERE location_id = :location_id");
        $query->bindValue(':location_id', $updateId);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        // if(isset($_S))

        // Prepare the response with the fetched bus details
        $response = [
            'success' => true,
            'message' => $result,
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
