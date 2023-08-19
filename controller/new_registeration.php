<?php

use models\Database_Connection;

include "../models/Database_Connection.php";

$db = new Database_Connection();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize a response array
    $response = array();

    // Get form data
    $symbolNo = $_POST['symbolNo'];

    // Perform some server-side validation if needed
    if (empty($symbolNo)) {
        $response['success'] = false;
        $response['message'] = "SymbolNo is a required field.";
    } else {
        // Perform database insertion
        try {
            $stmt = $db->db_connection()->prepare("INSERT INTO User_Registration (SymbolNo) VALUES (:symbolNo)");
            $stmt->bindValue(':symbolNo', $symbolNo);
            $stmt->execute();

            if ($stmt) {
                $response['success'] = true;
                $response['message'] = "Student added successfully.";
            } else {
                $response['success'] = false;
                $response['message'] = "Failed to add student.";
            }
        } catch (PDOException $e) {
            $response['success'] = false;
            $response['message'] = "Database error: " . $e->getMessage();
        }
    }

    // Send a JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle other request methods (e.g., GET) or return an error
    http_response_code(405); // Method Not Allowed
    echo "Method not allowed.";
}
?>
