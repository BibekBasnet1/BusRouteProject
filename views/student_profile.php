<?php
//require "../models/Database_Connection.php";
session_start();
include_once "../models/Database_Connection.php";
$db = new \models\Database_Connection();


// check if roll_id session variable is set
if (isset($_SESSION["roll_id"])) {
    // get the roll_id value from the session variable
    $roll_id = $_SESSION["roll_id"];

} else {
    // if roll_id session variable is not set, redirect to login page
    header("Location: ../views/index.php");
    exit();
}

// Setting up the database connection
$db_connection = $db->db_connection()->prepare("SELECT * FROM STUDENT WHERE roll_id = :roll_id");
$db_connection->bindParam(':roll_id', $roll_id);

// Executing the statement
$db_connection->execute();


// fetching all the data from the table
$results = $db_connection->fetchAll(PDO::FETCH_ASSOC);

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

    <title>
        <?php
        echo $_SESSION["roll_id"];
        ?>
    </title>
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
            <a href="dashboard.php">
                <i class='bx bxs-dashboard' ></i>
                <span class="text">Dashboard</span>
            </a>

        </li>

        <li>
            <a href="messageStudent_dashboard.php">
                <i class='bx bxs-message-dots'></i>
                <span class="text">message</span>
            </a>
        </li>


        <li>
            <a href="student_profile.php">
                <i class='bx bxs-user'></i>
                <span class="text">Profile</span>
            </a>
        </li>

    </ul>

    <ul class="side-menu">
        <li>
            <a href="#">
                <i class='bx bxs-cog' ></i>
                <span class="text">Settings</span>
            </a>
        </li>
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
        <form action="#">
            <div class="form-input">
                <input type="search" placeholder="Search...">
                <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
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
                <h1>Dashboard</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right' ></i></li>
                    <li>
                        <a class="active" href="#">Home</a>
                    </li>
                </ul>
            </div>
        </div>
        <?php
        foreach($results as $result){?>
            <!-- this is the profile container -->
            <div class="profile-container">

                <!-- student info container -->
                <div class="student-info-container">

                    <!-- this is for storing the profile-img and some contents -->
                    <div class="profile-img-container">
                        <img src="" alt="">
                    </div>

                    <!-- this is for some-context information -->
                    <div class="text-profile">
                        <h2>
                            <?php
                            echo $result['name'];
                            ?>
                        </h2>
                    </div>

                </div>
                <!-- end of the student info container -->

                <div class="personal-information">

                    <h2 style="text-align: center;">Personal Information </h2><br>

                    <!-- this is for the row-1 information  -->
                    <div class="row-1-info">
                        <div class="info-1">
                            <h2>
                                Post
                            </h2><br>
                            <h4>
                                <?php echo $result['user_type'] ; ?>
                            </h4>
                        </div>
                        <div class="info-2">
                            <h2>Phone</h2><br>
                            <h4>
                                <?php echo $result['phone_no'] ; ?>
                            </h4>
                        </div>
                    </div>

                    <!-- this is for the row-2 information -->
                    <div class="row-2-info">
                        <div class="info-3">
                            <h2>Email</h2><br>
                            <h4>
                                <?php echo $result['email'] ; ?>
                            </h4>
                        </div>
                        <div class="info-4">
                            <h2>Roll Id</h2><br>
                            <h4>
                                <?php
                                echo $roll_id;
                                ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- end of the personal Information -->

                <!-- start of the address details -->

                <div class="address_details">

                    <h2 style="text-align: center;">Address</h2><br>
                    <div class="row-3-info">

                        <div class="info-5">
                            <h2>Country</h2><br>
                            <h4>Nepal</h4>
                        </div>

                        <div class="info-6">
                            <h2>Location</h2><br>
                            <h4>
                                <?php
                                echo $result['address'];
                                ?>
                            </h4>
                        </div>

                    </div>
                </div>
                <!-- end of the address details -->
            </div>
            <?php
        }?>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->

<script src="../resources/dash_code.js"></script>
</body>
</html>