<?php

class SignIn_Control
{
    private $name;
    private $parents_name;
    private $phone_no;
    private $relationship;
    private $email;
    private $roll_id;

    public function __construct($name,$parents_name,$phone_no,$relationship,$email,$roll_id){
        $this->name = $name;
        $this->email = $email;
        $this->parents_name = $parents_name;
        $this->relationship = $relationship;
        $this->phone_no = $phone_no;
        $this->roll_id = $roll_id;
    }

    // this helps to check for the empty field if the user has given some empty input
    private function emptyInput(): bool
    {
        // initially setting up the result as null to check whether the input is valid or not
        $result = null;
        if(empty($this->name) || empty($this->parents_name) || empty($this->phone_no) || empty($this->relationship)
            || empty($this->email) || empty($this->roll_id))
        {
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }

    // validation rule for the name,parents_name,relationship
    private function checkValidUser(): bool
    {
        // Regular expression pattern to match only letters and whitespace characters
        $pattern = '/^[a-zA-Z\s]+$/';
        $result = null;
        if (preg_match($pattern, $this->name) && preg_match($pattern, $this->parents_name) && preg_match($pattern, $this->relationship)) {
            // All input fields contain only letters and whitespace characters
            // Allow user to create account
            $result = true;
        } else {
            // At least one input field contains special symbols or numbers
            // Display error message to user
            $result = false;
        }
        return $result;
    }

    // for validation of the email address
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