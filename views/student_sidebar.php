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
                <i class='bx bxs-message-dots' ></i>
                <span class="text">Message</span>
            </a>
        </li>

        <li>
            <a href="student_profile.php">
                <i class='bx bxs-user'></i>
                <span class="text">Profile</span>
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