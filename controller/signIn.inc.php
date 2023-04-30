<?php

if(isset($_POST["submit"])){
    $name = $_POST['person_name'];
    $parent_name = $_POST['parents_name'];
    $phone_no = $_POST['phone_no'];
    $relationship = $_POST['relationship'];
    $student_email = $_POST['student_email'];
    $roll_no = $_POST['roll_no'];

    // instantiate the signIn control classes
    include "SignIn_Control.php";
    $signup = new SignIn_Control($name,$parent_name,$phone_no,$relationship,$student_email,$roll_no);

}
