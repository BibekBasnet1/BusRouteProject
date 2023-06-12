<?php

if (isset($_POST["submit"])) {
    // Take the data from the form
    $name = $_POST['person_name'];
    $parent_name = $_POST['parents_name'];
    $phone_no = $_POST['phone_no'];
    $relationship = $_POST['relationship'];
    $student_email = $_POST['student_email'];
    $roll_no = $_POST['roll_no'];
    $parent_no = $_POST['parent_no'];
    $address = strtolower($_POST['location']);

    // Include necessary files
    include "../models/Database_Connection.php";
    include "sign_database_query.php";
    include "SignIn_Control.php";

    // Instantiate the SignIn_Control class
    $signup = new SignIn_Control($name, $parent_name, $phone_no, $relationship, $student_email, $roll_no, $parent_no, $address);

    try {
        // Call the signUpUser method to perform validation and insert data
        $signup->signUpUser();
        $signup->updateLocationId($address);
        $signup->assignBusToStudent();

        // Convert address to latitude and longitude
        $geocodeUrl = 'https://us1.locationiq.com/v1/search.php?key=pk.4c10171d8ab538b4955fc7fc97dc1b03';
        $geocodeUrl .= '&format=json&q=' . urlencode($address);

        $geocodeResponse = file_get_contents($geocodeUrl);
        $geocodeData = json_decode($geocodeResponse);

        // Check if geocoding was successful
        if (!empty($geocodeData)) {
            $latitude = $geocodeData[0]->lat;
            $longitude = $geocodeData[0]->lon;

            // Update the location_id and coordinates in the Student table
            $signup->updateLocationCoordinates($latitude, $longitude);
        }

        // Display a success message
        header("Location: ../views/index.php");
        exit();

    } catch (Exception $e) {
        // If an exception occurs during the sign-up process, display an error message
        echo "Sign up failed: " . $e->getMessage();
    }
}
