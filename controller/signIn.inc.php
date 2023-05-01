<?php
//require_once "../views/sign_in.php";
if(isset($_POST["submit"])){

    // this is to take the data from the form
    $name = $_POST['person_name'];
    $parent_name = $_POST['parents_name'];
    $phone_no = $_POST['phone_no'];
    $relationship = $_POST['relationship'];
    $student_email = $_POST['student_email'];
    $roll_no = $_POST['roll_no'];
    $parent_no = $_POST['parent_no'];
    $address = $_POST['location'];

    // instantiate the signIn control classes

    // this is to help the database connection
    include "../models/Database_Connection.php";

    // this is to help to write query for the database
    include "sign_database_query.php";

    // this is to help to control validation and other things and set up the user
    include "SignIn_Control.php";
    $signup = new SignIn_Control($name,$parent_name,$phone_no,$relationship,$student_email,$roll_no,$parent_no,$address);
    // after all the validation it will finally sign up the user in the database
    $signup->signUpUser();
    // if the signUp is successfull redirect the user to redirect on the new page
    header("location: ../views/index.php");

}
