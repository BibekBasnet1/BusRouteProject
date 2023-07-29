<?php
// sort_locations.php

// require the necessary files and initialize the database connection
require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

// Retrieve the sort parameter (you can pass it in the AJAX request)
$sort = $_GET['sort'] ?? 'location_name';

// Build the SQL query dynamically based on the sort parameter
$query = "SELECT * FROM LOCATIONS ORDER BY $sort ASC";

// Execute the SQL query and retrieve the sorted results
$stmt = $db_connection->db_connection()->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate the HTML for the sorted table rows
$html = "";
foreach ($results as $result) {
    $html .= "<tr>";
    $html .= "<td>" . $result['location_id'] . "</td>";
    $html .= "<td>" . $result['location_name'] . "</td>";
    $html .= "<td>" . $result['route_id'] . "</td>";
    $html .= "</tr>";
}

// Return the sorted table HTML as the response
echo $html;
?>
