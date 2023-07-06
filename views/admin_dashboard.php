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

    </style>
</head>
<body>

        <?php
            include_once "sidebar.php";
        ?>

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
        <div class="head-title">
            <div class="left">
                <h1></h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Admin Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="#">Home</a>
                    </li>
                </ul>
            </div>
        </div>
        <ul class="box-info">
            <li>
<!--                <i class='bx bxs-calendar-check'></i>-->
                <i class='bx bx-bus-school' ></i>
                <span class="text">
                    <?php
                        echo "<h3>$count1</h3>";
                    ?>

						<p>Bus 1</p>
					</span>
            </li>
            <li>
<!--                <i class='bx bxs-group' ></i>-->
                <i class='bx bxs-bus' ></i>
                <span class="text">

                    <?php
                    echo "<h3>$count2</h3>";
                    ?>
                    <p>Bus 2</p>
                </span>

            </li>
            <li>
<!--                <i class='bx bxs-dollar-circle' ></i>-->
                <i class='bx bx-bus' ></i>
                <span class="text">

                            <?php
                            echo "<h3>$count3</h3>";
                            ?>

						<p>Bus 3</p>
                </span>
            </li>
        </ul>

        <!-- this is for the form container      -->
        <?php
            include_once "updated_form.php";
        ?>
        <!--  this is the end of the form container -->
        <?php
            include_once "../controller/Update_Search.php";
        ?>

    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->

<script src="../resources/dash_code.js"></script>
</body>
</html>