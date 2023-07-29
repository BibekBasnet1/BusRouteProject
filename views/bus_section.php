<?php

//require "../models/Database_Connection.php";
session_start();

require_once "../models/Database_Connection.php";
$db_connection = new \models\Database_Connection();

$stmt = $db_connection->db_connection()->prepare("select * from bus");
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
            overflow: hidden;
        }

        .main-section
        {
            display: flex;
            justify-content: center;
            margin-top: 4rem;
            
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

         /* location  update form */
         .location_update_form_container{
            /* Existing styles */
            position: fixed;
            display : none;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /*background: rgba(0, 0, 0, 0.5);*/
            /*backdrop-filter: blur(5px);*/
            z-index: 9999;
            background-color: #ffffff;
        }
        .row-1,.row-2,.row-3{
            margin-bottom: 2rem;
        }
        #location,#route,#location_id{
            padding: 10px;
            border: 1px solid var(--dark-grey);
            /*border-bottom: 1px solid #611bf5;*/
        }
        #route{
            width: 100%;
            background-color: var(--light);
        }
        form input[type="text"]#location:focus,form input[type="number"]#route:focus
        {
            outline: none;
        }
        .container-form{
            border: 1px solid #cec3c381;
            padding: 2rem;
        }

        .btn-location-update{
            display: block;
            margin-top: 20px;
            padding: 10px 10px 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #611BF5;
            color: #fff;
            cursor: pointer;
            width: 100%;
        }
        /* Hide the number input spin buttons */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Hide the number input spin buttons in Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }

        svg{
            position: relative;
            top: -83px;
            left: 25px;
        }
        /* end of the location update form */

    </style>
        
</head>
<body>
    <?php
        include_once "sidebar.php";
    ?>

<section id="content">

    <main class="main-section">
        <div class="table-data">
    <div class="order">
        <div class="head">
            <h3 style="text-align: center;">Bus Details</h3>
            <input type="text" id="searchInput" placeholder="Search...">
            <i class="bx bx-search search-icon"></i>
            <i class='bx bx-filter' ></i>

        </div>
        <table>
            <thead>
            <tr>
                <th>Bus No</th>
                <th>Driver Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    $count = 0;
                ?>
            <?php
            foreach($results as $result){
                $count++;
                ?>
                <tr>

                    <td>
                        <?php  echo $result['bus_num']  ?>
                    </td>

                    <td>
                        <?php echo $result['driver_name'];?>
                    </td>

                    <td>
                        <?php
                        $rollId = $result['roll_id'];
                        ?>

                        <button type="button" class="edit-btn" data-rollid="<?php echo $rollId; ?>" data-usertype="<?php echo $result['user_type']; ?>">Update</button>

                    </td>

                    <td>
                            <button type="submit" class="delete-btn" name="delete_id" data-rollid="<?php echo $result['roll_id']; ?>" data-usertype="<?php echo $result['user_type']; ?>">Delete</button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="location_update_form_container">

        <form action="../controller/process_location.php" method="post" class="container-form">
            <h1 style="margin-bottom: 1.5rem; text-align: center">Add Address</h1>
            <p class="error-message"></p><br>
            <div class="image wrong-location-form"style="text-align: right;position: relative;top: 0;right:0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: rotate(180deg);msFilter:progid:DXImageTransform.Microsoft.BasicImage(rotation=2);"><path d="M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z"></path><path d="M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z"></path></svg>
            </div>
            <div class="row-1 location-data">
                <label for="location"></label>
                <input type="text" name="location_data"  id="location" placeholder="Enter Address" required>
            </div>
            <div class="row-2 route_data">
                <label for="route"></label>
            
                <select name="route_number" id="route">
                <?php 
                    foreach($routeResult as $route){
                ?>
                    <option value="<?php echo $route['route_id'] ;?>"><?php  echo $route['route_name']; ?></option>
                    <?php } ?>
                </select>
                
                <!-- <input type="number" name="route_number" id="route" placeholder="Enter Route Number" required> -->
            </div>
            <div class="row-3">
                <label for="location_id"></label>
                <input type="number" name="location_number" id="location_id" placeholder="Enter location id" required>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn-location-update" >Update</button>
            </div>
        </form>
        </div>

</div>

</main>
</section>
</body>