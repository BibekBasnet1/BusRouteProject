<?php
//require "../models/Database_Connection.php";
session_start();

// check if roll_id session variable is set
if (isset($_SESSION["roll_id"])) {
    // get the roll_id value from the session variable
    $roll_id = $_SESSION["roll_id"];
//    $name = $_SESSION["name"];
//    $address = $_SESSION["address"];
//    $lat = $_SESSION["latitude"];
//    $lon = $_SESSION["longitude"];
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
    <link rel="stylesheet" href="../resources/dashboard.css">

    <title>Admin</title>
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
            <a href="#">
                <i class='bx bxs-dashboard' ></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li>
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

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Recent Orders</h3>
                    <i class='bx bx-search' ></i>
                    <i class='bx bx-filter' ></i>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Location</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Bus</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <img src="img/people.png">
                                <p>
                                    <?php
                                    require_once "../models/Database_Connection.php";
//                                                        session_start();

                                                        $db_connection = new \models\Database_Connection();
                                                        $stmt = $db_connection->db_connection()->prepare("SELECT * FROM STUDENT WHERE roll_id = ?");
                                                        $stmt->execute([$_SESSION['roll_id']]);

                                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                                        if ($result) {
                                                            echo $result['name'];
                                                        }
                                    ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php echo $result['email']; ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php
                                        echo $result['address'];
                                    ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php
                                        echo $result['latitude'];
                                    ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php
                                        echo $result["longitude"];
                                    ?>
                                </p>
                            </td>

                            <td>
                                <p>
                                    <?php
                                        echo $result["bus"];
                                    ?>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->

<script src="../resources/dashboard_code.js"></script>
</body>
</html>