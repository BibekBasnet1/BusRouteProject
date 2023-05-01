<?php
require_once('/var/www/html/busRouteProject/models/Database_Connection.php');

class sign_database_query extends \models\Database_Connection {

    protected function setUpUser($name, $parents_name, $phone_no, $relationship, $email, $roll_id, $parent_no, $address): void
    {
        $stmt = $this->db_connection()->prepare("INSERT INTO STUDENT (name, parents_name, phone_no, relationship, email, roll_id, parent_no, address) 
    VALUES(:name, :parents_name, :phone_no, :relationship, :email, :roll_id, :parent_no, :address)");
        if(!$stmt->execute([
            ':name' => $name,
            ':parents_name' => $parents_name,
            ':phone_no' => $phone_no,
            ':relationship' => $relationship,
            ':email' => $email,
            ':roll_id' => $roll_id,
            ':parent_no' => $parent_no,
            ':address' => $address
        ])){
//            throw new Exception("Failed to set up user");
            header("Location: ../views/index.php/error=UserSetUpFailed");
            exit();
        }
        $stmt = null;
    }

    protected function checkUserInDatabase($email,$roll_id): bool
    {
        $stmt = $this->db_connection()->prepare("SELECT name FROM STUDENT WHERE email = ? OR roll_id = ?");
        if(!$stmt->execute([$email, $roll_id])){
            $stmt  = null;
            header("location: ../views/index.php?error=stm-failed");
            exit();
        }
        return $stmt->rowCount() == 0;
    }

}