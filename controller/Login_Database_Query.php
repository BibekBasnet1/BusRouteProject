<?php

// for starting the session
session_start();
require_once "../models/Database_Connection.php";

class Login_Database_Query extends \models\Database_Connection
{

    // public function getUser($email, $roll_id): void
    // {


    //     // check user in the admin table 
    //     $checUserAuthority = $this->db_connection()->prepare('SELECT staff_id FROM ADMIN WHERE $staff_id =  ?');
    //     $checUserAuthority->execute([$roll_id]);



    //     // First, fetch the user's verification status
    //     $checkUserAccess = $this->db_connection()->prepare("SELECT verification FROM STUDENT WHERE email = ?");
    //     $checkUserAccess->execute([$email]);
    //     $userVerificationStatus = $checkUserAccess->fetchColumn(); // Assuming 0 or 1 is returned

    //     if ($userVerificationStatus == 0) {
    //         header("Location: ../views/index.php?error=UserNotVerified");
    //         exit();
    //     }

    //     // Check if user exists in the database
    //     $query = $this->db_connection()->prepare("
    //         select roll_id,user_type from STUDENT WHERE email = ? and roll_id = ?
    //         UNION
    //         SELECT staff_id,user_type from ADMIN where email = ? and staff_id = ? 
    //     ");



    //     // if executing the statement fails
    //     if (!$query->execute([$email, $roll_id, $email, $roll_id])) {
    //         $query = null;
    //         header("Location: ../views/index.php?error=stmtFailed");
    //         exit();
    //     }

    //     // if there is no row with the value of the user
    //     if ($query->rowCount() == 0) {
    //         $query = null;
    //         header("Location: ../views/index.php?error=userNotFound");
    //         exit();
    //     }

    //     // fetches the data in associative array
    //     $user = $query->fetchAll(PDO::FETCH_ASSOC);


    //     // check if the user type is student or admin
    //     if ($user[0]["user_type"] == "student") {
    //         // check if the entered roll_id matches the roll_id in the database
    //         if ($user[0]["roll_id"] == $roll_id) {
    //             $_SESSION["roll_id"] = $roll_id;
    //             $_SESSION["user_type"] = "student";
    //             header("Location: ../views/dashboard.php");
    //             exit();
    //         } else {
    //             $query = null;
    //             header("Location: ../views/index.php?error=WrongPassword");
    //             exit();
    //         }
    //     } elseif ($user[0]["user_type"] == "admin") {
    //         // check if the entered roll_id matches the staff_id in the database
    //         if ($user[0]["staff_id"] == $roll_id) {
    //             $_SESSION["roll_id"] = $roll_id;
    //             $_SESSION["user_type"] = "admin";
    //             header("Location: ../views/admin_dashboard.php");
    //             exit();
    //         } elseif ($user[0]["roll_id"] == $roll_id) {
    //             $_SESSION["roll_id"] = $roll_id;
    //             $_SESSION["user_type"] = "admin_student";
    //             header("Location: ../views/admin_dashboard.php");
    //             exit();
    //         } else {
    //             $query = null;
    //             header("Location: ../views/index.php?error=WrongPassword");
    //             exit();
    //         }
    //     } else {
    //         $query = null;
    //         header("Location: ../views/index.php?error=WrongPassword");
    //         exit();
    //     }

    //     //        $query = null;
    // }

    public function getUser($email, $roll_id): void
    {

        // check if the student is registered in the user registeration table 

        $isRegistered = $this->checkUserInRegisteration($roll_id);

        // if the user is not registered redirect them to the home page 
        if(!$isRegistered){
            header("Location: ../views/index.php?error=User Not Registered");
            exit();
        }


        // Check if the user is an admin
        $isAdmin = $this->checkAdmin($roll_id);

        // Check if the user is a student
        $isStudent = $this->checkStudent($email, $roll_id);

        // Check if the user is an admin, student, or neither
        if ($isAdmin) {
            $_SESSION["roll_id"] = $roll_id;
            $_SESSION["user_type"] = "admin";
            header("Location: ../views/admin_dashboard.php");
            exit();
        } elseif ($isStudent) {
            $_SESSION["roll_id"] = $roll_id;
            $_SESSION["user_type"] = "student";
            header("Location: ../views/dashboard.php");
            exit();
        } else {
            header("Location: ../views/index.php?error=Unverified");
            exit();
        }
    }

    // Function to check if the user is an admin
    private function checkAdmin($roll_id): bool
    {
        $query = $this->db_connection()->prepare("SELECT staff_id FROM ADMIN WHERE staff_id = ?");
        $query->execute([$roll_id]);
        return $query->rowCount() > 0;
    }

    // Function to check if the user is a student
    private function checkStudent($email, $roll_id): bool
    {
        $query = $this->db_connection()->prepare("SELECT verification, roll_id, user_type FROM STUDENT WHERE email = ? and roll_id = ?");
        $query->execute([$email,$roll_id]);
        $userData = $query->fetch(PDO::FETCH_ASSOC);

        // if the user exists but the verification is 1 then only execute it 
        if ($userData && $userData["verification"] == 1 && $userData["roll_id"] == $roll_id) {
            return true;
        }

        // if the verification status is not 1 then  it will return false admin needs to verify it 
        return false;
    }


    private function checkUserInRegisteration($roll_id)
    {
        $query = $this->db_connection()->prepare("SELECT symbolNo from User_Registration where symbolNo = ?");
        $query->execute([$roll_id]);
        $userAuthenticity = $query->fetch(PDO::FETCH_ASSOC);
        if($userAuthenticity)
            return true;
        

    }

}
