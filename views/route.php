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
                    <input type="text" id="searchInput" placeholder="Search...">
                    <i class="bx bx-search search-icon"></i>
                    <i class="bx bx-plus-circle add_bus"></i>

                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Route Name</th>
                            <th>Bus Num</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach($results as $result)
                    {
                        ?>
                    <tbody>

                        <tr>
                            <td>
                                <?php echo  $result['route_name'] ; ?>
                            </td>
                            
                            <td>
                                <?php echo $result['bus_id'] ; ?>
                            </td>

                            <td>
                                <button type="submit" class="delete_route"  data-routeId = "<?php  echo $result['route_id'];?>" >
                                        Delete                                 
                                </button>
                            </td>

                            <td>
                                <button type="submit" class="update_route"  data-routeId = "<?php  echo $result['route_id'];  ?> " >
                                        Update                                 
                                </button>
                            </td>
                            
                        </tr>


                    </tbody>
                    <?php } ?>
                </table>
            </div>


    </main>
    <!-- MAIN -->

    <script src="../resources/dash_code.js"></script>
</section>
<script>
    const deleteRouteBtn = document.querySelectorAll(".delete_route");
    // console.log(deleteRouteBtn)
    deleteRouteBtn.forEach(btn=>{
        btn.addEventListener('click',()=>{
            let deleteAttribute = btn.getAttribute('data-routeId');
            // console.log(deleteAttribute);
            fetch(`../controller/deleteRoute.php`,
            {
                method: 'POST',
                body :JSON.stringify(
                    {
                        route_id : deleteAttribute,
                    }
                ),
            })
            .then(response=>response.json())
            .then((data)=>{
                console.log(data);
            })
            .catch(error=>console.log(error));
        });
    })  
</script>