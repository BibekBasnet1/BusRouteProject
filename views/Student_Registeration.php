<?php

//require "../models/Database_Connection.php";
session_start();
include "ToastrNotification.php";
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

$db_connection = new \models\Database_Connection();
try {
    $stmt = $db_connection->db_connection()->prepare("SELECT ur.symbolNo, s.name, s.user_type
    FROM User_Registration ur
    LEFT JOIN STUDENT s ON ur.symbolNo = s.roll_id;
    ");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $e;
}


?>
<!DOCTYPE html>

<head>
    <html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="../resources/dash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

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

        /* New styles for your form container */
        .form-formContainer {
            position: fixed;
            display: none;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 99;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid black;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 40%;
            /* Adjust the width as needed */
            max-width: 400px;
            /* Set a maximum width */
        }


        .forms-container h1 {
            font-size: 1rem;
            margin-bottom: 20px;

        }

        .forms-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;

        }

        .forms-container input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            margin-bottom: 15px;

        }

        .btn-addStudent
        {

            margin-top: 20px;
            padding: 10px 10px 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #611BF5;
            color: #fff;
            cursor: pointer;
            width: 100%;
        }

        svg {}

        .form-container .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>

</head>

<body>

    <?php
    include_once "sidebar.php";
    ?>

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <!--        <a href="#" class="nav-link">Categories</a>-->
            <form action="../controller/Update_Search.php" method="POST">
                <div class="form-input">
                    <input type="search" name="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
        </nav>
        <!-- NAVBAR -->
        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1></h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Admin Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- this is the form that will help to add In student registeration  -->



            <!-- this is the end of the form-container -->

            <ul class="box-info">
                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <h3>Student Registeration</h3>
                            <!-- <input type="text" id="searchInput" placeholder="Search..."> -->
                            <!-- <i class="bx bx-search search-icon"></i> -->
                            <i class='bx bx-plus-circle addNewLocation'></i>
                            <!-- <i class='bx bx-filter'></i> -->

                        </div>
                        <table>
                            <thead>
                                <tr>

                                    <th>Symbol No</th>
                                    <th>Name</th>
                                    <th>User</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($results as $result) {

                                ?>
                                    <tr>

                                        <td>

                                            <p><?php echo $result['symbolNo']; ?></p>

                                        </td>
                                        <td>
                                            <p><?php echo $result['name']; ?></p>
                                        </td>

                                        <td>
                                            <p><?php echo $result['user_type']; ?></p>
                                        </td>

                                        <!-- <td>
                                            <button type="button" class="edit-btn" data-rollid="<?php echo $result['symbolNo']; ?>" data-usertype="<?php echo $result['user_type']; ?>">Update</button>
                                        </td> -->

                                        <td>
                                            <button type="submit" class="delete-btn" name="delete_id" data-rollid="<?php echo $result['symbolNo']; ?>" data-usertype="<?php echo $result['user_type']; ?>">Delete</button>
                                        </td>


                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </ul>


            <div class="form-formContainer">

                <form action="" method="post" class="forms-container">

                    <h1>Add Student</h1>

                    <div class="image wrong-location-form" style="text-align: right;position: relative;top: 0;right:0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: rotate(180deg);msFilter:progid:DXImageTransform.Microsoft.BasicImage(rotation=2);">
                            <path d="M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z"></path>
                            <path d="M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z"></path>
                        </svg>
                    </div>

                    <div class="SymbolNo">

                        <label for="location">Symbol No</label>
                        <input type="text" name="symbolNo" id="symbolNO" placeholder="Enter symbolNo" required>

                    </div>
                    <div class="btn-container">
                        <button class="btn-addStudent">Add Student</button>
                    </div>

                </form>

            </div>


        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="../resources/dash_code.js"></script>

    <script>
        const addStudent = document.querySelector(".addNewLocation");
        const addNewStudent = document.querySelector('.btn-addStudent');
        const formElement = document.querySelector('.forms-container');
        const form = document.querySelector(".form-formContainer ");



        addStudent.addEventListener("click", (e) => {
            e.preventDefault();
            form.style.display = 'block';


            addNewStudent.addEventListener('click', (e) => {
                e.preventDefault();
                formData = new FormData(formElement);

                fetch('../controller/new_registeration.php', {
                        method: 'POST',
                        body: formData // Assuming 'formData' contains your form data
                    })
                    .then(response => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Display a success message with Toastr
                            toastr.success(data.message); // Assuming 'data.message' contains the server response message
                        } else {
                            // Display an error message with Toastr
                            toastr.error(data.message); // Assuming 'data.message' contains the server response message
                        }
                    })
                    .catch((error) => {
                        // Display any errors
                        console.error(error);
                    });
            });




        });

        const deleteBtn = document.querySelectorAll(".delete-btn");
        deleteBtn.forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                let symbolId = btn.getAttribute('data-rollid');
                let userType = btn.getAttribute('data-usertype');
                // console.log(userType);

                // ajax fetch request 
                fetch('../controller/deleteRegisteration.php', {
                        method: 'POST',
                        body: JSON.stringify({
                            delete_id: symbolId,
                            userType: userType,
                        }),
                    })
                    .then((response) => {
                        console.log(response);
                    })
                    .then((data) => {
                        console.log(data.success);
                        if (data.success) {
                            toastr.success("Deleted successfully");

                        } else {
                            toastr.error("Cannot delete admin");
                        }
                    })
                    .catch((error) => {
                        // Display any errors
                        console.error(error);
                    });


            })
        })
    </script>
</body>


</html>