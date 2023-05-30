<?php

//require "../models/Database_Connection.php";
session_start();

require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

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


$stmt = $db_connection->db_connection()->prepare("SELECT * FROM LOCATIONS");
$stmt->execute();

// to fetch the data from the database
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="../resources/dashboard.css">

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

        .add-btn{
            font-size: 1rem;
            padding: 0.5em 1em;
            border: transparent;
            box-shadow: 2px 2px 4px rgba(0,0,0,0.4);
            background: var(--blue);
            color: white;
            border-radius: 4px;
        }
        /* Styling for the form inputs within the "Add Location" form */
        #add-location-form .custom-input {
            width: 100%;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            /* ... */
        }
        .location_name{
            min-width: 100%;
        }
        .form-content{
            display: flex;
            flex-direction: column;
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
            <a href="#">
                <i class='bx bxs-message-dots' ></i>
                <span class="text">Message</span>
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
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Location Reference</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="#">Home</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Student Details</h3>
                    <i class="bx bx-search"></i>
                    <i class='bx bx-filter' ></i>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>location Id</th>
                        <!--                <th>Email</th>-->
                        <th>Location Name</th>
                        <th>Route Id</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($results as $result){ ?>
                        <tr>
                            <td>
<!--                                <img src="img/people.png">-->
                                <p><?php echo $result['location_id']; ?></p>
                            </td>
                            <td>
                                <?php echo $result["location_name"]; ?>
                            </td>
                            <td>
                                <?php echo $result["route_id"]; ?>
                            </td>

                            <td>
                                <?php
                                $rollId = $result['roll_id'];
                                ?>

                                <button type="button" class="add-btn" data-rollid="<?php echo $rollId; ?>">Add</button>

                            </td>

<!--                            <td>-->
<!--                                <button type="submit" class="delete-btn" name="delete_id" data-rollid="--><?php //echo $result['roll_id']; ?><!--" data-usertype="--><?php //echo $result['user_type']; ?><!--">Delete</button>-->
<!--                            </td>-->

                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add location form -->
        <div class="sign-up-container" id="add-location-form">
            <form action="../controller/update_student_data.php" method="POST" class="form-form" id="update-form">
                <div class="title-signUP">
                    <h2>Add Location</h2>
                </div>
                <div class="form-content">
                    <div class="content-1">
                        <div class="location_name">
                            <input type="text" name="location_name" id="location_name" class="custom-input" placeholder="Location Name" required>
                        </div>
                        <div class="route_id">
                            <input type="number" name="route_id" id="route_id" class="custom-input" placeholder="Route ID" required>
                        </div>
                    </div>
                </div>
                <div class="btn">
                    <button type="submit" name="add-submit">Add Location</button>
                </div>
            </form>
        </div>


    </main>
    <!-- MAIN -->


</section>
<!-- CONTENT -->

<script src="../resources/dash_code.js"></script>
</body>
</html>

<script>
    // JavaScript code to handle Add button click event
    const addButtons = document.querySelectorAll('.add-btn');
    const addForm = document.getElementById('add-location-form');

    addButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const rollId = button.dataset.rollid;
            const locationName = button.parentNode.parentNode.querySelector('td:nth-child(2)').textContent;

            // Set the form fields with the data
            const locationNameInput = addForm.querySelector('#location_name');
            locationNameInput.value = locationName;

            // Display the form
            addForm.style.display = 'flex';
        });
    });
</script>

