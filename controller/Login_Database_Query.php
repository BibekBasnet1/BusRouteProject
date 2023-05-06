<?php

// for starting the session
session_start();
require_once "../models/Database_Connection.php";

class Login_Database_Query extends \models\Database_Connection
{

    public function getUser($email, $roll_id): void
    {
        // Check if user exists in the database
        $query = $this->db_connection()->prepare("
            select roll_id,user_type from STUDENT WHERE email = ? or roll_id = ?
            UNION
            SELECT staff_id,user_type from ADMIN where email = ? or staff_id = ? 
        ");

        // if executing the statement fails
        if (!$query->execute([$email, $roll_id, $email, $roll_id])) {
            $query = null;
            header("Location: ../views/index.php?error=stmtFailed");
            exit();
        }

        // if there is no row with the value of the user
        if ($query->rowCount() == 0) {
            $query = null;
            header("Location: ../views/index.php?error=userNotFound");
            exit();
        }

        // fetches the data in associative array
        $user = $query->fetchAll(PDO::FETCH_ASSOC);


        // check if the user type is student or admin
        if ($user[0]["user_type"] == "student") {
            // check if the entered roll_id matches the roll_id in the database
            if ($user[0]["roll_id"] == $roll_id) {
                $_SESSION["roll_id"] = $roll_id;
                $_SESSION["user_type"] = "student";
                header("Location: ../views/dashboard.php");
                exit();
            } else {
                $query = null;
                header("Location: ../views/index.php?error=WrongPassword");
                exit();
            }
        } elseif ($user[0]["user_type"] == "admin") {
        // check if the entered roll_id matches the staff_id in the database
            if ($user[0]["staff_id"] == $roll_id) {
                $_SESSION["roll_id"] = $roll_id;
                $_SESSION["user_type"] = "admin";
                header("Location: ../views/admin_dashboard.php");
                exit();
            } elseif ($user[0]["roll_id"] == $roll_id) {
                $_SESSION["roll_id"] = $roll_id;
                $_SESSION["user_type"] = "admin_student";
                header("Location: ../views/admin_dashboard.php");
                exit();
            } else {
                $query = null;
                header("Location: ../views/index.php?error=WrongPassword");
                exit();
            }
        } else {
        $query = null;
        header("Location: ../views/index.php?error=WrongPassword");
        exit();
    }

//        $query = null;
    }
}

