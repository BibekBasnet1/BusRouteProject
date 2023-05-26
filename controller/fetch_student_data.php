<?php
require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

if (isset($_GET['rollId'])) {
    $roll_id = $_GET['rollId'];

    $stmt = $db_connection->db_connection()->prepare("SELECT * FROM STUDENT WHERE roll_id = :roll_id");
    $stmt->bindValue(':roll_id', $roll_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if a record was found
    if ($result) {
        $response = [
            'status' => 'success',
            'data' => $result
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'No record found for the provided roll ID.'
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request. Roll ID not provided.'
    ];
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
