<?php
// session_start();

require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // $delete_id = $_POST['delete_id'];
        $data = json_decode(file_get_contents('php://input'), true);

        $deleteId = $data['delete_id'];
        $userType = $data['userType'];
        // echo $userType;

        $userId = $db_connection->db_connection()->prepare("DELETE from User_Registration where symbolNo = :symbolNo");
        $userId->bindValue(':symbolNo', $deleteId);


        if($userType != 'admin')
        {
            $userId->execute();
        
        }
        $response = [
            'success' => true,
            'message' => 'Deleted successfully',
        ];
        echo json_encode($response);
        // exit();

    
        
    } catch (Exception $e) {
        $response = [
            'succession' => false,
            'message' => 'Error deleting record: ' . $e->getMessage()
        ];

        echo json_encode($response);
    }
}
