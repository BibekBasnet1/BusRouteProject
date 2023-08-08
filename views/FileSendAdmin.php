<?php

use \Dropbox\Client;
//require "../models/Database_Connection.php";
session_start();

require_once "../models/Database_Connection.php";

// check if roll_id session variable is set
if (isset($_SESSION["roll_id"])) {
    // get the roll_id value from the session variable
    $roll_id = $_SESSION["roll_id"];



} else {
    // if roll_id session variable is not set, redirect to login page
    header("Location: ../views/index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="../resources/dash.css">

    <title>Admin</title>
    <style>
        #sidebar .side-menu li a
        {
            width: 100%;
            height: 100%;
            background: var(--light);
            display: flex;
            align-items: center;
            border-radius: 48px;
            font-size: 16px;
            color: var(--dark);
            white-space: nowrap;
            overflow-x: hidden;
        }
        .file-upload-container {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
        }

        .file-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 200px;
            color: #888;
            font-size: 18px;
            cursor: pointer;
        }

        .file-icon {
            font-size: 48px;
        }

        .file-text {
            margin-top: 10px;
        }

        .file-input {
            display: none;
        }

        .submit-button {
            margin-top: 10px;
            background-color: var(--blue);
            color: white;
            padding: 10px 20px 10px 20px;
            border: none;
            cursor: pointer;
        }

    </style>
</head>
<body>


<!-- SIDEBAR -->
<?php
    include_once "sidebar.php";
?>
<!-- SIDEBAR -->

<!-- CONTENT -->
<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu' ></i>
        <!--        <a href="#" class="nav-link">Categories</a>-->
        <form action="../controller/Update_Search.php" method="POST">
            <div class="form-input">
                <input type="search" name="search" placeholder="Search...">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </form>
        <input type="checkbox" id="switch-mode" hidden>
        <label for="switch-mode" class="switch-mode"></label>
    </nav>
    <!-- NAVBAR -->

    <!-- MAIN -->
    <main>
            <!-- this content will display the main important part -->
            
            <!-- this will send the file  -->
<!--            <div id="fileUpload" style="border: 2px solid black;" class="file-upload-container">-->
<!--                <form class="file-upload-form" method="post" action="" enctype="multipart/form-data" >-->
<!--                    <label for="file" class="file-label">Choose File</label><br>-->
<!--                    <input type="file" name="file_name" id="file" class="file-input"><br>-->
<!--                    <button type="submit" class="submit-button">Submit</button>-->
<!--                </form>-->
<!--            </div>-->
        <div id="fileUpload" class="file-upload-container">
            <form class="file-upload-form" method="post" action="" enctype="multipart/form-data">
                <label for="file" class="file-label">
                    <span class="file-icon"><i class="fas fa-cloud-upload-alt"></i></span>
                    <span class="file-text">Drag and drop files here or click to browse</span>
                </label>
                <input type="file" name="file_name" id="file" class="file-input">
                <button type="submit" class="submit-button">Upload</button>
            </form>
            <!-- <div id="fileDisplay"></div> -->
        </div>

        <!-- end of the main important part -->
    </main>
    <!-- MAIN -->

</section>
<!-- CONTENT -->
<script src="../resources/dash_code.js"></script>

<script>




    let form = document.querySelector('.file-upload-form');
    function submitForm(event) {
        event.preventDefault(); // Prevent the default form submission
        let formData = new FormData(form);

        // Send the form data using AJAX
        fetch('../controller/uploadFile.php', {
            method: 'POST',
            body: formData
        })
            .then(function(response) {
                if (response.ok) {
                    return response.text(); // Parse response as text
                } else {
                    throw new Error('Invalid response ' + response.status);
                }
            })
            .then(function(data) {
                // Display the response in the container
                // document.getElementById('response').textContent = data;
                console.log(data);
                alert("uploaded");
            })
            .catch(function(error) {
                // Display any errors
                console.error(error);
            });
    }

    // Attach the submitForm function to the form submit event
    form.addEventListener('submit', submitForm);

</script>
</body>
</html>

