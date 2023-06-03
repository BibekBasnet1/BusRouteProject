<?php
//require "../models/Database_Connection.php";
session_start();

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
    <link rel="stylesheet" href="../resources/dashboard.css">

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
                        <th>Sender_id</th>
                        <th>Receiver</th>
                        <th>subject</th>
                        <th>content</th>
                        <th>Send At</th>
                    </tr>
                    </thead>

                    <!-- ... Rest of the code ... -->

                    <tbody>
                    <?php
                    require_once "../models/Database_Connection.php";
                    $db_connection = new \models\Database_Connection();

                    $stmt = $db_connection->db_connection()->prepare("SELECT * from messages m inner join STUDENT
                                                                                      s on m.recipient_id = s.roll_id where recipient_id = ?");

                    $stmt->execute([$_SESSION['roll_id']]);
                    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($messages as $message) {
                        ?>
                            <tr>
                        <td>
                            <p>
                                <?php  echo $message['sender_id']?>
                            </p>
                        </td>
                        <td>
                            <p>
                                <?php  echo $message['name']?>
                            </p>
                        </td>
                        <td>
                            <p>
                                <?php  echo $message['subject']?>
                            </p>
                        </td>
                        <td>
                            <p>
                                <?php  echo $message['content']?>
                            </p>
                        </td>

                        <td>
                            <p>
                                <?php  echo $message['created_at']?>
                            </p>
                        </td>
                            </tr>
                    <?php
                    }
                    ?>
                    </tbody>

                    <!-- ... Rest of the code ... -->

                </table>
            </div>

        </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->

<script src="../resources/dash_code.js"></script>
</body>
</html>