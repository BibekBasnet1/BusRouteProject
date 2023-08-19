<?php

require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

session_start();

// ... (existing code)

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the updated data from the request
    $rollId = $_POST['roll_id'];
    $name = $_POST['student_name'];
    $parentsName = $_POST['parents_name'];
    $phoneNo = $_POST['phone_no'];
    $relationship = $_POST['relationship'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $parentNo = $_POST['parent_no'];

    try {
        // Fetch the user type from the database for the specified roll ID
        $query = "SELECT user_type FROM STUDENT WHERE roll_id = :rollId";
        $stmt = $db_connection->db_connection()->prepare($query);
        $stmt->bindParam(':rollId', $rollId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user type is admin
        // If admin, return an error response
        if ($result['user_type'] === "admin") {
            $response = [
                'status' => 'error',
                'message' => 'Update functionality disabled for admins'
            ];
            echo json_encode($response);
            exit;
        }

        // Update the student data in the database
        $query = "UPDATE STUDENT SET name = :name, parents_name = :parentsName, phone_no = :phoneNo, relationship = :relationship, email = :email, address = :address, parent_no = :parentNo WHERE roll_id = :rollId";
        $stmt = $db_connection->db_connection()->prepare($query);
        $stmt->bindParam(':rollId', $rollId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':parentsName', $parentsName);
        $stmt->bindParam(':phoneNo', $phoneNo);
        $stmt->bindParam(':relationship', $relationship);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':parentNo', $parentNo);
        $stmt->execute();

        // Update the location_id in the STUDENT table based on the address
        $locationId = getLocationIdByAddress($address);
        if ($locationId !== null) {
            $locationQuery = "UPDATE STUDENT SET location_id = :locationId WHERE roll_id = :rollId";
            $locationStmt = $db_connection->db_connection()->prepare($locationQuery);
            $locationStmt->bindParam(':locationId', $locationId);
            $locationStmt->bindParam(':rollId', $rollId);
            $locationStmt->execute();



            // Check if the location's route_id is null
            $routeIdQuery = "SELECT route_id FROM LOCATIONS WHERE location_id = :locationId";
            $routeIdStmt = $db_connection->db_connection()->prepare($routeIdQuery);
            $routeIdStmt->bindParam(':locationId', $locationId);
            $routeIdStmt->execute();

            $routeIdResult = $routeIdStmt->fetch(PDO::FETCH_ASSOC);
            $locationRouteId = $routeIdResult['route_id'];

            if ($locationRouteId === null) {
                // Set the bus to null if the location's route_id is null
                $nullBusQuery = "UPDATE STUDENT SET bus = NULL WHERE roll_id = :rollId";
                $nullBusStmt = $db_connection->db_connection()->prepare($nullBusQuery);
                $nullBusStmt->bindParam(':rollId', $rollId);
                $nullBusStmt->execute();
            }

            assignBusToStudent();
        } else {
            // Set the bus and location_id to null if the address doesn't exist
            $nullQuery = "UPDATE STUDENT SET bus = NULL, location_id = NULL WHERE roll_id = :rollId";
            $nullStmt = $db_connection->db_connection()->prepare($nullQuery);
            $nullStmt->bindParam(':rollId', $rollId);
            $nullStmt->execute();
        }

        $response = [
            'status' => 'success',
            'message' => 'Student data updated successfully'
        ];

        echo $response['message'];
    } catch (PDOException $e) {
        $response = [
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage()
        ];
        echo $response['message'];
        exit;
    }
}

// Function to retrieve location_id from the LOCATIONS table based on the address
function getLocationIdByAddress($address)
{
    $db_connection = new \models\Database_Connection();

    $sql = "SELECT location_id FROM LOCATIONS WHERE location_name = :address";
    $stmt = $db_connection->db_connection()->prepare($sql);
    $stmt->bindParam(':address', $address);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($result !== false) ? $result['location_id'] : null;
}

function assignBusToStudent()
{
    $db_connection = new \models\Database_Connection();

    $sql = "UPDATE STUDENT s
            INNER JOIN LOCATIONS l ON s.location_id = l.location_id AND s.address = l.location_name
            INNER JOIN ROUTES r ON l.route_id = r.route_id
            INNER JOIN bus b ON r.bus_id = b.bus_id
            SET s.bus = b.bus_num";

    $stmt = $db_connection->db_connection()->prepare($sql);
    $stmt->execute();
}

// function assignBusToStudent()
// {
//     $db_connection = new \models\Database_Connection();

//     $sql = "UPDATE STUDENT s
//             INNER JOIN LOCATIONS l ON s.location_id = l.location_id AND s.address = l.location_name
//             INNER JOIN ROUTES r ON l.route_id = r.route_id
//             INNER JOIN bus b ON r.bus_id = b.bus_id
//             SET s.bus = CASE
//                 WHEN l.route_id IS NULL THEN NULL
//                 WHEN l.route_id IS NOT NULL AND r.route_id IS NOT NULL THEN b.bus_num
//                 ELSE s.bus
//             END";

//     $stmt = $db_connection->db_connection()->prepare($sql);
//     $stmt->execute();
// }

// ... (remaining code)
