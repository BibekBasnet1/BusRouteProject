<?php


use models\Database_Connection;

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

$db_connection = new Database_Connection();

//  to select the data from the routes table 
$stmt = $db_connection->db_connection()->prepare('select * from ROUTES');
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


$bus = $db_connection->db_connection()->prepare("select * from bus");
$bus_num = $db_connection->db_connection()->prepare("select bus_num from bus inner join ROUTES on bus.bus_id = ROUTES.bus_id");
$bus_num->execute();
$bus->execute();

$buses = $bus->fetchAll(PDO::FETCH_ASSOC);
$bus_numbers =  $bus_num->fetchAll(PDO::FETCH_ASSOC);
// dd($buses);

$busNumbers  = [];
foreach ($bus_numbers as $bus_num) {
    array_push($busNumbers, $bus_num['bus_num']);
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

        #bus_route_number select {
            /* background-color: blue; */
            width: 100%;
            height: 2rem;
            text-align: center;
        }

        .update_route_form {
            position: fixed;
            display: none;
            top: 50%;
            left: 50%;
            justify-content: center;
            align-items: center;
            transform: translate(-50%, -50%);
            /*background: rgba(0, 0, 0, 0.5);*/
            /* backdrop-filter: blur(5px); */
            z-index: 9999;
            width: 20%;
            height: 55%;
            background-color: #ffffff;
        }

        .RouteName,
        .routeNumber,
        .route_id {
            width: 100%;
            padding: 0.3rem;
        }

        .delete_route,
        .update_route {
            font-size: 1rem;
            padding: 0.5em 1em;
            border: transparent;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
            background: red;
            color: white;
            border-radius: 4px;
        }

        .update_route {
            background: var(--blue);
        }

        .btn-route-update {
            display: block;
            position: absolute;
            margin-top: 20px;
            padding: 10px 10px 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #611BF5;
            color: #fff;
            cursor: pointer;
            width: 90%;
            /* margin: 1rem; */
        }

        .btn-container {
            position: relative;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<!-- SIDEBAR -->
<?php
include_once "sidebar.php";
?>

<!-- SIDEBAR -->

<!-- CONTENT -->
<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu'></i>
        <!--        <a href="#" class="nav-link">Categories</a>-->
        <form action="../controller/Update_Search.php" method="POST">
            <!--            <div class="form-input">-->
            <!--                <input type="search" name="search" placeholder="Search...">-->
            <!--                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>-->
            </div>
        </form>
        <input type="checkbox" id="switch-mode" hidden>
        <label for="switch-mode" class="switch-mode"></label>
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
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="admin_dashboard.php">Home</a>
                    </li>
                </ul>
            </div>


        </div>

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3 style="text-align: center;">Route Details</h3>
                    <!-- <input type="text" id="searchInput" placeholder="Search..."> -->
                    <!-- <i class="bx bx-search search-icon"></i> -->
                    <i class="bx bx-plus-circle add_route"></i>

                </div>
                <table>
                    <thead>

                        <tr>
                            <th>Route Name</th>
                            <th>RouteLocations</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    <?php foreach ($results as $result) {
                    ?>
                        <tbody>

                            <tr>
                                <td>
                                    <?php echo  $result['route_name']; ?>
                                </td>


                                <td>
                                    <?php
                                    // Fetch associated locations for the current route using INNER JOIN
                                    $route_id = $result['route_id'];
                                    $stmt = $db_connection->db_connection()->prepare("
                                        SELECT location_name 
                                            FROM LOCATIONS
                                        INNER JOIN ROUTES ON LOCATIONS.route_id = ROUTES.route_id
                                        WHERE ROUTES.route_id = :route_id
                                    "); 
                                    $stmt->bindValue(':route_id', $route_id, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Display the associated locations
                                    foreach ($locations as $location) {
                                        echo $location['location_name'] . '<br>';
                                    }
                                    ?>
                                </td>

                                <td>
                                    <form action="../controller/deleteRoute.php" method="post">
                                        <input type="hidden" name="route_id" value="<?php echo $result['route_id']; ?>">
                                        <button type="submit" class="delete_route" data-routeId="<?php echo $result['route_id']; ?>">
                                            Delete
                                        </button>
                                    </form>
                                </td>

                            </tr>

                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>

        <!-- to insset -->
        <div class="update_route_form">

            <form action="../controller/add_route.php" class="route-container" method="POST">

                <h1 style="margin-bottom: 1rem; text-align: center">Add Route</h1>
                <!-- <p class="error-message"></p><br> -->
                <div class="exit-form wrong-location-form" style="text-align: right;position: relative;top: 0;right:0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: rotate(180deg);msFilter:progid:DXImageTransform.Microsoft.BasicImage(rotation=2);">
                        <path d="M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z"></path>
                        <path d="M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z"></path>
                    </svg>
                </div>
                <div class="row-1 routeNumber" id="bus_route_number">

                    <label for="">Bus Number</label>

                    <select name="bus_id" id="">

                        <?php foreach ($buses as $result) {
                        ?>
                            <option value="<?php echo $result['bus_id'];  ?>"><?php echo $result['bus_num']; ?></option>
                        <?php
                        } ?>

                    </select>

                </div>

                <div class="row-2 RouteName">
                    <label for="route">Route Name</label>
                    <input type="text" name="route_name" id="route_name" placeholder="Enter Route Name" required>
                </div>

                <div class="row-3 route_id">
                    <label for="route">Route Number</label>
                    <input type="text" name="route_id" id="route_id" placeholder="Enter Route Number" required>
                </div>


                <div class="btn-container">
                    <button type="submit" class="btn-route-update" name="submit">Insert</button>
                </div>
            </form>

        </div>

    </main>
    <!-- MAIN -->

    <script src="../resources/dash_code.js"></script>
</section>

<script>
    const wrongImage = document.querySelector(".exit-form");
    const addForm = document.querySelector(".update_route_form");
    const addButton = document.querySelector(".add_route");
    const tableData = document.querySelector(".table-data");

    addButton.addEventListener('click', () => {
        addForm.style.display = "flex";
        tableData.style.filter = "blur(5px)";
    })


    wrongImage.addEventListener('click', () => {
        addForm.style.display = "none";
    })
    // const deleteBtn = document.querySelectorAll(".delete_route");
    const deleteBtns = document.querySelectorAll(".delete_route");
    deleteBtns.forEach(deleteBtn => {
        deleteBtn.addEventListener('click', (e) => {
            e.preventDefault();
            let answer = prompt("Do you want to delete the route? Some Students may still be associated with the route. Enter 'yes' to confirm.");
            if (answer === "yes") {
                deleteBtn.closest('form').submit();
            }
        });
    });
</script>