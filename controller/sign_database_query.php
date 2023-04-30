<?php

class sign_database_query extends \models\Database_Connection {

    protected function checkUserInDatabase($email,$roll_id){
        $stmt = $this->db_connection()->prepare("select name from ADMIN where email = ? or staff_id = ?;");

        // if the sql statement fails
        if(!$stmt->execute(array($email,$roll_id)))
        {
            // if it fails
            $stmt  = null;
            header("location: ../views/index.php?error=stm-failed");
            exit();
        }
        $resultCheck = null;
        if($stmt->rowCount() > 0){
            $resultCheck = false;
        }else{
            $resultCheck = true;
        }
    }

}