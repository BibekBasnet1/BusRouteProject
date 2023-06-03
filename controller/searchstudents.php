<?php
require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

$search = $_POST['search'];
$stmt = $db_connection->db_connection()->prepare("SELECT * FROM STUDENT WHERE LOWER(name) LIKE :search OR LOWER(address) LIKE :search OR latitude LIKE :search OR longitude LIKE :search OR phone_no LIKE :search OR bus LIKE :search");
$stmt->bindValue(':search', '%' . $search . '%');
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = array(
    'status' => 'success',
    'data' => $results
);

header('Content-Type: application/json');
echo json_encode($response);


