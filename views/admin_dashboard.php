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

// counts the buses
$buses = $db->db_connection()->prepare("SELECT * from bus");
$buses->execute();
$busesCount = $buses->rowCount(); // Get the total number of buses

// Create a new empty array to store the bus_id values
$busIds = array();

// Loop through the result set and push each bus_id into the array
while ($row = $buses->fetch(PDO::FETCH_ASSOC)) {
    $busIds[] = $row['bus_num'];
}


?>
<!DOCTYPE html>

<head>
    <html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="../resources/dash.css">

    <title>Admin</title>
    <style>
        #sidebar .side-menu li a {
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
    <!-- <link href="toastr.css" rel="stylesheet"/> -->
</head>

<body>

    <?php
    include_once "sidebar.php";
    ?>

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
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

                <?php foreach ($busIds as $busId) : ?>
                    <li>
                        <i class='bx bx-bus'></i>
                        <span class="text">
                            <?php
                            $stmt = $db->db_connection()->prepare("SELECT COUNT(*) FROM STUDENT WHERE bus = :busId");
                            $stmt->bindParam(':busId', $busId, PDO::PARAM_INT);
                            $stmt->execute();
                            $studentCount = $stmt->fetchColumn();
                            ?>
                            <h3><?php echo $studentCount; ?></h3>
                            <p>Bus No <span style="color: red;"><?php echo $busId; ?></span></p>
                        </span>
                    </li>
                <?php endforeach; ?>

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
    <!-- <script src="toastr.js"></script> -->
</body>

</html>