<?php
if (isset($_POST["submit"])) {
    require_once "../models/Database_Connection.php";
    require_once "sign_database_query.php";
    require_once "SignIn_Control.php";
    // Include necessary files

    // Function to handle success and failure redirects
    function redirect($success)
    {
        if ($success) {
            header("Location: ../views/index.php");
            echo "<script>toastr.success('Successfully Registered');</script>";
            exit();
        } else {
            header("Location: ../views/index.php?error=RollIdSame");
            exit();
        }
    }

    // Function to perform geocoding using cURL
    function geocodeLocation($address, $signup)
    {
        $geocodeUrl = 'https://us1.locationiq.com/v1/search.php?key=pk.4c10171d8ab538b4955fc7fc97dc1b03';
        $geocodeUrl .= '&format=json&q=' . urlencode($address);

        $ch = curl_init($geocodeUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $geocodeResponse = curl_exec($ch);

        if (curl_errno($ch)) {
            // Handle cURL error
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode === 200) {
                // Geocoding was successful, parse the JSON response
                $geocodeData = json_decode($geocodeResponse);

                if (!empty($geocodeData)) {
                    $latitude = $geocodeData[0]->lat;
                    $longitude = $geocodeData[0]->lon;
                    $signup->updateLocationCoordinates($latitude, $longitude);
                }
            } else {
                // Handle non-200 HTTP response
                echo 'HTTP Error: ' . $httpCode;
            }
        }

        curl_close($ch);
    }


    try {
        // Take the data from the form
        $name = $_POST['person_name'];
        $parent_name = $_POST['parents_name'];
        $phone_no = $_POST['phone_no'];
        $relationship = $_POST['relationship'];
        $student_email = $_POST['student_email'];
        $roll_no = $_POST['roll_no'];
        $parent_no = $_POST['parent_no'];
        $address = strtolower($_POST['location']);

        // Instantiate the SignIn_Control class
        $signup = new SignIn_Control($name, $parent_name, $phone_no, $relationship, $student_email, $roll_no, $parent_no, $address);

        // Call the signUpUser method to perform validation and insert data
        $success = true;
        try {
            $signup->signUpUser();
        } catch (Exception $e) {
            $success = false;
        }

        $signup->updateLocationId($address);
        $signup->assignBusToStudent();
        geocodeLocation($address, $signup);

        redirect($success);
    } catch (Exception $e) {
        echo "Sign up failed: " . $e->getMessage();
    }
}
