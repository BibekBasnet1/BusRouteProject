<?php

// Perform database update to set the new verification status
require_once "../models/Database_Connection.php";
$db = new \models\Database_Connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rollId = $_POST['roll_id'];
    $userType = $_POST['user_type'];
    $verification = isset($_POST['verification']) && $_POST['verification'] === '1' ? 1 : 0;

    try {
        $query = $db->db_connection()->prepare("UPDATE STUDENT SET verification = :verification WHERE roll_id = :rollId");
        $query->bindValue(':verification', $verification, PDO::PARAM_INT);
        $query->bindValue(':rollId', $rollId, PDO::PARAM_INT);

        if ($query->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Successfully Updated',
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Query failed',
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Something Went Wrong',
        ]);
    }
}
