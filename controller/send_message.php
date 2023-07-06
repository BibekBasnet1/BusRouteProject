<?php
session_start();
require_once "../models/Database_Connection.php";

// Check if the user is logged in
if (!isset($_SESSION['roll_id'])) {
    header("Location: ../views/index.php");
    exit();
}

// Create a database connection
$db_connection = new \models\Database_Connection();
$db = $db_connection->db_connection();

// Function to send a message
function sendMessage($senderId, $recipientId, $subject, $content)
{
    global $db;

    $stmt = $db->prepare("INSERT INTO messages (sender_id, recipient_id, subject, content) VALUES (:sender_id, :recipient_id, :subject, :content)");
    $stmt->bindParam(':sender_id', $senderId);
    $stmt->bindParam(':recipient_id', $recipientId);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':content', $content);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $recipient = $_POST['recipient'];
    $subject = $_POST['subject'];
    $content = $_POST['content'];


    // Validate form data (add your validation logic here)

    // Get the sender ID from the session
    $senderId = $_SESSION['roll_id'];

    // Get the recipient ID from the database based on the recipient name
    $stmt = $db->prepare("SELECT roll_id FROM STUDENT WHERE name = :name AND user_type = 'student'");
    $stmt->bindParam(':name', $recipient);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $recipientId = $result['roll_id'];

        // Send the message
        if (sendMessage($senderId, $recipientId, $subject, $content)) 
        {
            // Message sent successfully
            $response = array(
                'status' => 'success',
                'message' => 'Message sent successfully!'
            );
        } else {
            // Failed to send the message
            $response = array(
                'status' => 'error',
                'message' => 'Failed to send the message. Please try again.'
            );
        }
    } else {
        // Recipient not found
        $response = array(
            'status' => 'error',
            'message' => 'Recipient not found. Please enter a valid recipient name.'
        );
    }

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}


