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
    $address = $_POST['location'];

    // Include necessary files
    include "../models/Database_Connection.php";
    include "sign_database_query.php";
    include "SignIn_Control.php";

    // Instantiate the SignIn_Control class
    $signup = new SignIn_Control($name, $parent_name, $phone_no, $relationship, $student_email, $roll_no, $parent_no, $address);

    try {
        // Call the signUpUser method to perform validation and insert data
        $signup->signUpUser();


        // Update the location_id in the Student table based on matching address
        $signup->updateLocationId($address);

        // Display a success message
        header("Location: ../views/index.php");

        // Clear the form fields if needed
        // ...

    } catch (Exception $e) {
        // If an exception occurs during the sign-up process, display an error message
        echo "Sign up failed: " . $e->getMessage();
    }
}
