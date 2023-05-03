<?php

// if the user press submit button for login
if(isset($_POST['Login'])){
    $email = $_POST['email'];
    $roll_id = $_POST['pwd'];
    // this is for database connection
    include_once "../models/Database_Connection.php";
// this is for the getting user from the database and logging in
    include_once "Login_Database_Query.php";
// this is for the login validation
    include_once "Login_Controller.php";

    $login = new Login_Controller($email,$roll_id);
    $login->LoginUser();

    header("Location: ../views/dashboard.php");
//    exit();
}

