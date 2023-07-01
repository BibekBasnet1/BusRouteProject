<?php

//require "../models/Database_Connection.php";
session_start();

require_once "../models/Database_Connection.php";

// check if roll_id session variable is set
if (isset($_SESSION["roll_id"])) {
    // get the roll_id value from the session variable
    $roll_id = $_SESSION["roll_id"];

//    $name = $_SESSION["name"];

} else {
    // if roll_id session variable is not set, redirect to login page
    header("Location: ../views/index.php");
    exit();
}

$db = new \models\Database_Connection();

// count students for bus 1
$stmt1 = $db->db_connection()->prepare("SELECT COUNT(*) FROM STUDENT WHERE bus='1'");
$stmt1->execute();
$count1 = $stmt1->fetchColumn();

// count students for bus 2
$stmt2 = $db->db_connection()->prepare("SELECT COUNT(*) FROM STUDENT WHERE bus='2'");
$stmt2->execute();
$count2 = $stmt2->fetchColumn();

// count students for bus 3
$stmt3 = $db->db_connection()->prepare("SELECT COUNT(*) FROM STUDENT WHERE bus='3'");
$stmt3->execute();
$count3 = $stmt3->fetchColumn();


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
        #sidebar .side-menu li a{
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

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        textarea#message{
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #611BF5;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4f1db6;
        }
        /*#content main {*/
        /*    background-color: #060714;*/
        /*}*/


    </style>
</head>
<body>


<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand">
        <i class='bx bxs-smile'></i>
        <span class="text">
            <?php
            // to print the session
            echo $_SESSION['roll_id'];
            ?>
        </span>
    </a>
    <ul class="side-menu top">
        <li class="active">
            <a href="admin_dashboard.php">
                <i class='bx bxs-dashboard' ></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="student_dashboard.php">
                <i class='bx bxs-shopping-bag-alt' ></i>
                <span class="text">Student</span>
            </a>
        </li>
        <li>
            <a href="location_dashboard.php">
                <i class='bx bxs-doughnut-chart' ></i>
                <span class="text">Location</span>
            </a>
        </li>
        <li>
            <a href="admin_message.php">
                <i class='bx bxs-message-dots' ></i>
                <span class="text">Message</span>
            </a>
        </li>
        <li>
            <a href="profile_section.php">
                <i class='bx bxs-user'></i>
                <span class="text">Profile</span>
            </a>
        </li>
        <li>
            <a href="FileSendAdmin.php">
                <i class='bx bx-file-blank'></i>
                <span class="text">Files</span>
            </a>
        </li>

    </ul>
    <ul class="side-menu">

        <li>

            <a href="../controller/Logout.php" class="logout">
                <i class='bx bxs-log-out-circle' ></i>
                <span class="text">Logout</span>
            </a>
        </li>

    </ul>
</section>
<!-- SIDEBAR -->

<!-- CONTENT -->
<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu' ></i>
        <a href="#" class="nav-link">Categories</a>
        <form action="../controller/Update_Search.php" method="POST">
            <div class="form-input">
                <input type="search" name="search" placeholder="Search...">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </form>
        <input type="checkbox" id="switch-mode" hidden>
        <label for="switch-mode" class="switch-mode"></label>
        <a href="#" class="notification">
            <i class='bx bxs-bell' ></i>
            <span class="num">8</span>
        </a>
        <a href="#" class="profile">
            <img src="img/people.png">
        </a>
    </nav>
    <!-- NAVBAR -->
    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1></h1>
            </div>
        </div>

        <div class="container">
            <h1>Send a Message</h1>
            <form id="messageForm" method="post">
                <label for="recipient">Recipient</label>
                <input type="text" id="recipient" name="recipient" placeholder="Enter recipient name">

                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" placeholder="Enter message subject">

                <label for="content">Content</label>
                <textarea id="message" placeholder="Enter message content" name="message"></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>

    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->

<script src="../resources/dash_code.js"></script>
<script>
    document.getElementById('messageForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Retrieve form data
        var recipient = document.getElementById('recipient').value;
        var subject = document.getElementById('subject').value;
        var content = document.getElementById('message').value;
        console.log(content);
        // Validate form data

        // Prepare form data for sending
        var formData = new FormData();
        formData.append('recipient', recipient);
        formData.append('subject', subject);
        formData.append('content', content);

        // Perform AJAX request to send message
        fetch('../controller/send_message.php', {
            method: 'POST',
            body: formData
        })
            .then(function(response) {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Error: ' + response.status);
                }
            })
            .then(function(data) {
                // Handle successful response
                if (data.status === 'success') {
                    // Clear form fields or show success message
                    document.getElementById('messageForm').reset();
                    alert('Message sent successfully!');
                } else {
                    // Show error message
                    alert('Error: ' + data.message);
                }
            })
            .catch(function(error) {
                // Show error message
                alert(error.message);
            });
    });

</script>
</body>
</html>