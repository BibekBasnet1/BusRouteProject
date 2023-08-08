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
            <a href="admin_message.php">
                <i class='bx bxs-message-dots' ></i>
                <span class="text">Message</span>
            </a>
        </li>

        <li>
            <a href="profile_section.php">
                <i class='bx bxs-user'></i>
                <span class="text">Profile</span>
            </a>
        </li>

        <li>
            <a href="FileSendAdmin.php">
                <i class='bx bx-file-blank'></i>
                <span class="text">Files</span>
            </a>
        </li>
        <li>
            <a href="bus_section.php">
                <i class='bx bx-file-blank'></i>
                <span class="text">bus</span>
            </a>
        </li>
        <li>
            <a href="route.php">
                <i class='bx bx-file-blank'></i>
                <span class="text">Routes</span>
            </a>
        </li>
        <li>
            <a href="seatPlanning.php">
            <i class='bx bx-file-blank'></i>
            <span class="text">Seat Planning</span>
            </a>
        </li>

    </ul>
    <ul class="side-menu">
        <li>
            <a href="#">
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