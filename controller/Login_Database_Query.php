<?php

// for starting the session
session_start();
require_once "../models/Database_Connection.php";

class Login_Database_Query extends \models\Database_Connection
{

//    private string $query = "SELECT roll_id, email FROM STUDENT WHERE email = ? OR roll_id = ?;";

    public function getUser($email, $roll_id): void
    {
        // Check if user exists in the database
        $stmt = $this->db_connection()->prepare("select * from STUDENT where email = ? or roll_id = ?");

        // if executing the statement fails
        if(!$stmt->execute(array($email,$roll_id))){
            $stmt = null;
            header("Location: ../views/index.php?error=stmtFailed");
            exit();
        }

        // if there is no row with the value of the user
        if($stmt->rowCount() == 0){
            $stmt = null;
            header("Location: ../views/index.php?error=userNotFound");
            exit();
        }

        // fetches the data in associative array
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        var_dump($user);
//        echo $user;
        if(empty($user[0]["roll_id"])){
            $stmt = null;
            header("Location: ../views/index.php?error=WrongPassword");
            exit();
        }
//        print_r($user[0]["roll_id"]);

        // this compares the password with the roll_id from the database and user_input
        if(($user[0]["roll_id"]) !== $roll_id){
            $stmt = null;
            header("Location: ../views/index.php?error=WrongPasswordHash");
            exit();
        }

        $_SESSION["roll_id"] = $user[0]["roll_id"];
//        $_SESSION["email"] = $user[0]["email"];
//        $_SESSION["name"] = $user[0]["name"];
//        $_SESSION["lat"] = $user[0]["latitude"];
//        $_SESSION["long"] = $user[0]["longitude"];
//        $_SESSION["address"] = $user[0]["address"];
//        $_SESSION["phone_no"] = $user[0]["phone_no"];
        $stmt = null;
    }
}

