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

// to fetch the route number from the database
$routeNumbers = $db_connection->db_connection()->prepare("SELECT * FROM ROUTES");
$routeNumbers->execute();

$routeResult = $routeNumbers->fetchAll(PDO::FETCH_ASSOC);

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

        .add-btn {
            font-size: 1rem;
            padding: 0.5em 1em;
            border: transparent;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
            background: var(--blue);
            color: white;
            border-radius: 4px;
        }

        .update_location {
            font-size: 1rem;
            padding: 0.5em 1em;
            border: transparent;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
            background: var(--blue);
            color: white;
            border-radius: 4px;
        }

        /* location  update form */
        .location_update_form_container {
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

        .update_location-form {
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

        .btn-location-update {
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
                <i class='bx bxs-bell'></i>
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
                        <h3>Locations</h3>
                        <!--                    <i class="bx bx-search"></i>-->
                        <i class='bx bx-plus-circle add-location'></i>
                        <i class='bx bx-filter' id="sort-icon"></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>location Id</th>
                                <th>Location Name</th>
                                <th>Route Id</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($results as $result) { ?>
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

                                        <!-- <button type="button" class="update_location" data-locationid="<?php echo $result['location_id']; ?>">Update</button> -->
                                    </td>
                                    <td>
                                        <button type="button" class="delete-btn" onclick="deleteRow(this)" data-locationid="<?php echo $result['location_id']; ?>">Delete</button>
                                    </td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Add location form -->
            <div class="location_update_form_container">

                <form action="../controller/process_location.php" method="post" class="container-form">
                    <h1 style="margin-bottom: 1.5rem; text-align: center">Add Address</h1>
                    <p class="error-message"></p><br>
                    <div class="image wrong-location-form" style="text-align: right;position: relative;top: 0;right:0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: rotate(180deg);msFilter:progid:DXImageTransform.Microsoft.BasicImage(rotation=2);">
                            <path d="M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z"></path>
                            <path d="M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z"></path>
                        </svg>
                    </div>
                    <div class="row-1 location-data">
                        <label for="location"></label>
                        <input type="text" name="location_data" id="location" placeholder="Enter Address" required>
                    </div>
                    <div class="row-2 route_data">
                        <label for="route"></label>

                        <select name="route_number" id="route">
                            <?php
                            foreach ($routeResult as $route) {
                            ?>
                                <option value="<?php echo $route['route_id']; ?>"><?php echo $route['route_name']; ?></option>
                            <?php } ?>
                        </select>

                        <!-- <input type="number" name="route_number" id="route" placeholder="Enter Route Number" required> -->
                    </div>
                    <div class="row-3">
                        <label for="location_id"></label>
                        <input type="number" name="location_number" id="location_id" placeholder="Enter location id" required>
                    </div>
                    <div class="btn-container">
                        <button type="submit" class="btn-location-update">Update</button>
                    </div>
                </form>
            </div>

            <!-- for the updation functionality  -->
            <div class="update_location-form">
                <form action="../controller/process_location.php" method="post" class="container-form">
                    <h1 style="margin-bottom: 1.5rem; text-align: center">Add Address</h1>
                    <p class="error-message"></p><br>
                    <div class="image wrong-location-form" style="text-align: right;position: relative;top: 0;right:0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: rotate(180deg);msFilter:progid:DXImageTransform.Microsoft.BasicImage(rotation=2);">
                            <path d="M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z"></path>
                            <path d="M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z"></path>
                        </svg>
                    </div>
                    <div class="row-1 location-data">
                        <label for="location"></label>
                        <input type="text" name="location_data" id="address" placeholder="Enter Address" required>
                    </div>
                    <div class="row-2 route_data">
                        <label for="route"></label>

                        <select name="route_number" id="route">
                            <?php
                            foreach ($routeResult as $route) {
                            ?>
                                <option value="<?php echo $route['route_id']; ?>"><?php echo $route['route_name']; ?></option>
                            <?php } ?>
                        </select>

                        <!-- <input type="number" name="route_number" id="route" placeholder="Enter Route Number" required> -->
                    </div>
                    <div class="row-3">
                        <label for="location_id"></label>
                        <input type="number" name="location_number" id="l_id" placeholder="Enter location id" required>
                    </div>
                    <div class="btn-container">
                        <button type="submit" class="btn-update-location" data-locationid="">Update</button>
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
    // selecting the icon for adding the locations
    const addLocation = document.querySelector('.add-location');
    const locationFormContainer = document.querySelector('.location_update_form_container');
    // const contentSection = document.querySelector('#content');

    addLocation.addEventListener('click', () => {
        locationFormContainer.style.display = 'flex';
        // contentSection.classList.add('blur');

    });

    const wrongImg = document.querySelector('.wrong-location-form');
    wrongImg.addEventListener('click', () => {
        locationFormContainer.style.display = "none";
    })

    // JavaScript code to handle the update button click and populate the form fields

    // Selecting the update buttons
    const updateButtons = document.querySelectorAll('.add-btn');
    // console.log(updateButtons);

    // Selecting the form fields
    const locationInput = document.querySelector('#location');
    const routeInput = document.querySelector('#route');
    const locationIdInput = document.querySelector('#location_id');


    // Function to handle update button click
    function handleUpdateButtonClick(event) {
        // Get the data from the button's data attributes
        const locationId = event.target.dataset.locationid;
        const locationName = event.target.dataset.locationname;
        const routeId = event.target.dataset.routeid;

        // Set the form fields' values with the retrieved data
        locationInput.value = locationName;
        routeInput.value = routeId;
        locationIdInput.value = locationId;

        // Show the update form
        locationFormContainer.style.display = 'flex';
    }

    // Adding event listeners to update buttons
    updateButtons.forEach(button => {
        button.addEventListener('click', handleUpdateButtonClick);
    });

    function deleteRow(button) {
        let locationId = button.getAttribute("data-locationid");
        // Confirm deletion
        if (confirm("Are you sure you want to delete this row?")) {
            // Send AJAX request to delete the row
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../controller/delete_location.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Refresh the page or update the table
                    location.reload();
                } else {
                    console.log("Error: " + xhr.status);
                }
            };
            // xhr.send("location_id=" + encodeURIComponent(locationId));
            // Include the location_id parameter in the request payload
            let params = "location_id=" + encodeURIComponent(locationId);
            xhr.send(params);
        }
    }

    document.getElementById("sort-icon").addEventListener("click", function() {
        // Send AJAX request
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "../controller/sort_locations.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Update the table with the sorted data
                document.getElementById("location-table").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    });

    const updateLocation = document.querySelector('.update_location-form');
    // console.log(updateLocation)

    // for the updation of the location 

    const updateBtn = document.querySelectorAll(".update_location");
    const makeChangeBtn = document.querySelector(".btn-update-location");

    makeChangeBtn.addEventListener('click', (e) => {
        e.preventDefault();
        // let btnAttribute = updateBtn.getAttribute('data-locationid');
        // console.log("clicked " + btnAttribute);


        const makeChangesData = {
            location_id: document.getElementById('address').value,
            location_name: document.getElementById('l_id').value,
            route_id: document.getElementById('route').value
        };

        // Make the fetch POST request
        fetch('../controller/location_update.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(makeChangesData),
            })
            .then((response) => response.json())
            .then((data) => {
                // Handle the response from the server (if needed)
                // console.log(data);
                if (data.success) {
                    // Fill the form with the received data
                    // document.getElementById('address').value = data.message.location_name;
                    // document.getElementById('route').value = data.message.route_name;
                    // document.getElementById('l_id').value = data.message.location_id;
                    console.log('deleted');
                } else {
                    console.error('something went wrong:', data.message);
                }
            })
            .catch((error) => {
                console.error('Error updating bus details:', error);
            });

    });

    updateBtn.forEach((updateBtn) => {
        updateBtn.addEventListener('click', (e) => {
            e.preventDefault();
            let btnAttribute = updateBtn.getAttribute('data-locationid');
            // console.log("clicked " + btnAttribute);

            updateLocation.style.display = "flex";
            // Create a data object with the updateId
            const data = {
                updateId: btnAttribute,
            };

            // Make the fetch POST request
            fetch('../controller/update_location_form.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data),
                })
                .then((response) => response.json())
                .then((data) => {
                    // Handle the response from the server (if needed)
                    // console.log(data);
                    if (data.success) {
                        // Fill the form with the received data
                        document.getElementById('address').value = data.message.location_name;
                        // document.getElementById('route').value = data.message.route_name;
                        document.getElementById('l_id').value = data.message.location_id;
                    } else {
                        console.error('Error fetching bus details:', data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error updating bus details:', error);
                });




        });
    });
</script>