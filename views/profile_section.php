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
$db_connection = $db->db_connection()->prepare("SELECT * FROM ADMIN WHERE staff_id = :roll_id");
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
        .profile-image-container {
            position: relative;
            display: inline-block;
        }

        .change-image-icon {
            position: absolute;
            top: -8px;
            right: 0;
            /*background-color: var(--orange);*/
            border-radius: 50%;
            padding: 8px;
            cursor: pointer;
        }


        .image-wrapper img {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }

        .profile-image-container{
            border: 2px solid black;
            padding: 1rem;
            border-radius: 50%;
        }

        #file {
            display: none;
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
<!--                <div class="profile-img-container">-->
<!--                    <img id="profile-image" src="path_to_default_image.jpg" alt="Profile Image">-->
<!--                    <input type="file" id="profile-image-upload" accept="image/*" onchange="previewProfileImage(event)">-->
<!--                </div>-->
                <div class="profile-image-container">
                    <div class="img-wrapper">
                        <img id="profile-image" src="" alt="Profile Image">
                    </div>

                    <label for="file" class="change-image-icon">
<!--                        <i class="fas fa-pencil-alt"></i>-->
                        <i class='bx bxs-edit-alt bx-rotate-90' style='color:#68289b' ></i>
                    </label>
                    <input type="file" name="file_name" id="file" accept="image/*" onchange="previewProfileImage(event)">
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
<script>
    // JavaScript
    function previewProfileImage(event) {
        const fileInput = event.target;
        const profileImage = document.getElementById('profile-image');

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                profileImage.src = e.target.result;
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    }

</script>
</body>
</html>