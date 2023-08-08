<?php
include_once ("../models/Database_Connection.php");

class sign_database_query extends \models\Database_Connection {

    /**
     * @throws Exception
     */
    protected function setUpUser($name, $parents_name, $phone_no, $relationship, $email, $roll_id, $parent_no, $address): void
    {
        if ($this->checkUserInDatabase($email, $roll_id)) {
            // user already exists
            header("Location: ../views/index.php?error=UserExist");
            exit();
        }

        $stmt = $this->db_connection()->prepare("INSERT INTO STUDENT (name, parents_name, phone_no, relationship, email, roll_id, parent_no, address,user_type) 
    VALUES(:name, :parents_name, :phone_no, :relationship, :email, :roll_id, :parent_no, :address,'student')");
        if(!$stmt->execute([
            ':name' => $name,
            ':parents_name' => $parents_name,
            ':phone_no' => $phone_no,
            ':relationship' => $relationship,
            ':email' => $email,
            ':roll_id' => $roll_id,
            ':parent_no' => $parent_no,
            ':address' => $address,

        ]))
        {
//           throw new Exception("Failed to set up user");
            echo "<p class='userSetUpFailed'>User Set Up Failed</p>";
            header("Location: ../views/index.php?error=UserSetUpFailed");
            exit();
        }

        $stmt = null;
    }


    protected function checkUserInDatabase($email, $roll_id): bool
    {
        $stmt = $this->db_connection()->prepare("SELECT name FROM STUDENT WHERE email = ? or roll_id = ?");
        $stmt->execute([$email, $roll_id]);
        $rowCount = $stmt->rowCount();
        $stmt = null;

        return $rowCount > 0;
    }

}
?>
<script>
    const userSetUp = document.querySelector(".userSetUpFailed");
    toastr.warning(userSetUp.textContent);

</script>
