<?php

//require "../models/Database_Connection.php";
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

$db_connection = new \models\Database_Connection();
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $stmt = $db_connection->db_connection()->prepare("SELECT * FROM STUDENT WHERE name LIKE :search OR email LIKE :search OR address LIKE :search OR latitude LIKE :search OR longitude LIKE :search OR phone_no LIKE :search OR bus LIKE :search");
    $stmt->bindValue(':search', '%' . $search . '%');
} else {
    $stmt = $db_connection->db_connection()->prepare("SELECT * FROM STUDENT");
    // $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>
<!DOCTYPE html>

<head>
    <html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
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

            <ul class="box-info">

                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <h3>Student Authority</h3>
                            <input type="text" id="searchInput" placeholder="Search...">
                            <i class="bx bx-search search-icon"></i>
                            <i class='bx bx-filter'></i>

                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Verification</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($results as $result) {

                                ?>
                                    <tr>
                                        <td>
                                            <p><?php echo $result['name']; ?></p>
                                        </td>
                                        <td>
                                            <?php echo $result['roll_id']; ?>
                                        </td>
                                        <td>
                                            <form>
                                                <input type="hidden" name="student_id" value="<?php echo $result['roll_id']; ?>">
                                                <label>
                                                    <input type="checkbox" name="verification" value="1" <?php echo ($result['verification'] == 1) ? 'checked' : ''; ?>>
                                                    Verified
                                                </label>
                                            </form>
                                        </td>
                                        
                                        <td>
                                            <button type="button" class="edit-btn" data-roll="<?php echo $result['roll_id'] ?>" data-usertype="<?php echo $result['user_type']; ?>">Update</button>

                                        </td>
                                        

                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </ul>

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="../resources/dash_code.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var editButtons = document.querySelectorAll(".edit-btn");

        editButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                var rollId = button.getAttribute("data-roll");
                var userType = button.getAttribute("data-usertype");
                var verificationCheckbox = button.parentNode.parentNode.querySelector("input[name='verification']");
                var verification = verificationCheckbox.checked ? 1 : 0;


                if(userType === 'admin')
                {
                    toastr.info("Cannot modify admin");
                    return;
                }

                // Construct the form data
                var formData = new FormData();
                formData.append("roll_id", rollId);
                formData.append("user_type", userType);
                formData.append("verification", verification);

                // Send the fetch request
                fetch("../controller/update_verification.php", {
                        method: "POST",

                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Handle the response data here (you can show a success message or update the UI)
                        if (data.success)
                        {
                            toastr.success("successfully updated");
                        }
                         else {
                            toastr.info("Coudn't Update the status");
                        }
                    })
                    .catch(error => {
                        console.error("Request failed:", error);
                    });
            });
        });
    });
</script>

</html>