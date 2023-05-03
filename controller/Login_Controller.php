<?php
//session_start();
require_once "Login_Database_Query.php";

class Login_Controller extends Login_Database_Query
{

    private $email;
    private $roll_id;

    public function __construct($email,$roll_id){
        $this->email = $email;
        $this->roll_id = $roll_id;
    }

    public function loginUser(): void
    {
        if(!$this->checkInvalidEmail() || !$this->checkValidRollNo() || !$this->checkEmptyInput()){
            header("Location: ../views/index.php?error=invalidEmailOrRollNoOrEmptyInput");
            exit();
        }
        $this->getUser($this->email,$this->roll_id);

    }


    // check if the user is trying to submit without entering values in the input fields
    public function checkEmptyInput() : bool{
        $stmt = null;
        if(empty($this->email) || empty($this->roll_id)){
            $stmt = false;
        }else{
            $stmt = true;
        }
        return $stmt;
    }

    // for the email validation
    private function checkInvalidEmail():bool
    {
        $result = null;
        if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    // for the roll no validation
    private function checkValidRollNo():bool{
        $pattern = '/^\d+$/';
        $result = null;
        if(preg_match($pattern,$this->roll_id)){
            $result = true;
        }else{
            $result = false;
        }
        return $result;
    }
}