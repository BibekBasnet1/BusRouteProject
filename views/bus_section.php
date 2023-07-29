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
            overflow: hidden;
        }

        .main-section {
            display: flex;
            justify-content: center;
            margin-top: 4rem;

        }

        .delete-bus {
            font-size: 1rem;
            padding: 0.5em 1em;
            border: transparent;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
            background: red;
            color: white;
            border-radius: 4px;
        }

        .add-btn {
            font-size: 1rem;
            padding: 0.5em 1em;
            border: transparent;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
            background: var(--blue);
            color: white;
            border-radius: 4px;
        }

        /* location  update form */
        .Bus_Update {
            /* Existing styles */
            position: fixed;
            display: none;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /*background: rgba(0, 0, 0, 0.5);*/
            /*backdrop-filter: blur(5px);*/
            z-index: 9999;
            background-color: #ffffff;
        }

        .update_bus {
            position: fixed;
            display: none;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /*background: rgba(0, 0, 0, 0.5);*/
            /*backdrop-filter: blur(5px);*/
            z-index: 9999;
            background-color: #ffffff;
        }

        .row-1,
        .row-2,
        .row-3 {
            margin-bottom: 2rem;
        }

        #location,
        #route,
        #location_id {
            padding: 10px;
            border: 1px solid var(--dark-grey);
            /*border-bottom: 1px solid #611bf5;*/
        }

        #route {
            width: 100%;
            background-color: var(--light);
        }

        form input[type="text"]#location:focus,
        form input[type="number"]#route:focus {
            outline: none;
        }

        .container-form {
            border: 1px solid #cec3c381;
            padding: 2rem;
        }

        .btn-bus-update {
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

        svg {
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
                        <i class="bx bx-plus-circle add_bus"></i>

<<<<<<< HEAD
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
=======
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Bus Number</th>
                                <th>Driver Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            ?>
                            <?php
                            foreach ($results as $result) {
                                $count++;
                            ?>
                                <tr>
                                    <!-- <td> -->
>>>>>>> 5a8d9b7d49b3b0cb1d333161fe8a4a415dfedc97

                                    <!-- </td> -->
                                    <td>
                                        <?php echo $result['bus_num']  ?>
                                    </td>

                                    <td>
                                        <?php echo $result['driver_name']; ?>
                                        <?php ?>

                                    </td>

                                    <td>
                                
                                        <button type="button" class="edit-btn" id="data-busId" data-busId="<?php echo $result['bus_id']; ?>" >Update</button>

                                    </td>

                                    <td>
                                        <button class="delete-bus" data-busId="<?php echo $result['bus_id']; ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- start of the form container -->
                <div class="Bus_Update">
                    <form action="../controller/insert_bus.php" method="post" class="container-form">
                        <h1 style="margin-bottom: 1.5rem; text-align: center">Insert Bus Details </h1>
                        <p class="error-message"></p><br>
                        <div class="image wrong-location-form" style="text-align: right;position: relative;top: 0;right:0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: rotate(180deg);msFilter:progid:DXImageTransform.Microsoft.BasicImage(rotation=2);">
                                <path d="M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z"></path>
                                <path d="M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z"></path>
                            </svg>
                        </div>
                        <div class="row-1 bus-data">
                            <label for="location"></label>
                            <input type="text" name="bus_num" id="bus_num" placeholder="Enter Bus num" required>
                        </div>
                        <div class="row-2 driver_data">
                            <label for="route"></label>
                            <input type="text" name="driver_name" id="driver_name" placeholder="Enter Driver Name" required>
                        </div>
                        <div class="btn-container">
                            <button type="submit" class="btn-bus-update" name="submit">Update</button>
                        </div>
                    </form>
                </div>
                <!-- End of the form container  -->


                <!-- this is for the updation  -->

                <div class="update_bus">
                    <form action="" class="container-form">
                        <h1 style="margin-bottom: 1.5rem; text-align: center">Update Bus</h1>
                        <!-- <p class="error-message"></p><br> -->
                        <div class="image-wrong wrong-location-form" style="text-align: right;position: relative;top: 0;right:0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: rotate(180deg);msFilter:progid:DXImageTransform.Microsoft.BasicImage(rotation=2);">
                                <path d="M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z"></path>
                                <path d="M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z"></path>
                            </svg>
                        </div>
                        <div class="row-1 bus-data">
                            <label for="location">Bus Num</label>
                            <input type="text" name="bus_num" id="bus_num" placeholder="Enter Bus num" required>
                        </div>
                        <div class="row-2 driver_data">
                            <label for="route">Driver Name</label>
                            <input type="text" name="driver_name" id="driver_name" placeholder="Enter Driver Name" required>
                        </div>
                        <div class="btn-container">
                            <button type="submit" class="btn-bus-update" name="submit">Update</button>
                        </div>
                    </form>
                </div>


                <!-- this is for the deletion  -->


            </div>
        </main>
    </section>
</body>
<script>
    const delteBusInfo = document.querySelectorAll('.delete-bus');

    // this is for the deletion logic in the controller 

<<<<<<< HEAD
</main>
</section>

    <script>

        
    </script>

</body>
=======
    delteBusInfo.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            // e.preventDefault();
            var dataBusId = btn.getAttribute('data-busId');
            console.log(dataBusId);
            let confirmed = confirm("Are you sure you want to delete!");
            if (confirmed) {
                fetch('../controller/deletebus.php', {
                        method: 'POST',
                        body: JSON.stringify({
                            delete_id: dataBusId
                        }),
                    })
                    .then(function(response) {
                        if (response.ok) {
                            return response.text(); // Parse response as text
                        } else {
                            throw new Error('Invalid response ' + response.status);
                        }
                    })
                    .then(function(data) {
                        // alert("deleted");
                        console.log("Response:", data); // Debugging statement
                    })
                    .catch(function(error) {
                        // Display any errors
                        console.error(error);
                    });
            }
        })
    });

    // this is end of the deletion logic 

    const addButton = document.querySelector(".add_bus");
    const formDocument = document.querySelector(".Bus_Update");
    const wrongImage = document.querySelector(".image");
    const updateImageWrong = document.querySelector('.image-wrong');
    const updateBtnBus = document.querySelector('.edit-btn');
    const update_bus = document.querySelector('.update_bus');
    const edit_btn = document.querySelectorAll(".edit-btn");

    addButton.addEventListener('click', () => {
        formDocument.style.display = "flex";
    })


    wrongImage.addEventListener('click', () => {
        formDocument.style.display = "none";

    })

    updateImageWrong.addEventListener('click', () => {
        update_bus.style.display = "none";
    })

    // when submit to insert the new data

    edit_btn.forEach((btn) => {
        
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            // pop up the form 
            updateBtnBus.addEventListener('click', () => {
                update_bus.style.display = "flex";
            })



        })
    })
</script>
>>>>>>> 5a8d9b7d49b3b0cb1d333161fe8a4a415dfedc97
