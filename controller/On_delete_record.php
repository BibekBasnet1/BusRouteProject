<?php
require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

// check if the delete_id is set
if (isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];

    $stmt = $db_connection->db_connection()->prepare("DELETE FROM STUDENT WHERE roll_id = :roll_id");
    $stmt->bindValue(':roll_id', $deleteId);
    $stmt->execute();

    // Check if the delete operation was successful
    if ($stmt->rowCount() > 0) {
        $response = [
            'status' => 'success',
            'message' => 'Record deleted successfully.'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Failed to delete the record.'
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request. Delete ID not provided.'
    ];
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
