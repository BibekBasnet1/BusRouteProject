<?php
require_once('sign_database_query.php');

class SignIn_Control extends sign_database_query
{
    private $name;
    private $parents_name;
    private $phone_no;
    private $relationship;
    private $email;
    private $roll_id;
    private $parent_no;
    private $address;

    public function __construct($name,$parents_name,$phone_no,$relationship,$email,$roll_id,$parent_no,$address){
        $this->name = $name;
        $this->email = $email;
        $this->parents_name = $parents_name;
        $this->relationship = $relationship;
        $this->phone_no = $phone_no;
        $this->roll_id = $roll_id;
        $this->parent_no = $parent_no;
        $this->address = $address;

    }

    // for all the validation

    /**
     * @throws Exception
     */
    public function signUpUser(): void
    {
        // this is to help if the input user has given is empty
        if(!$this->emptyInput()){
            header("Location: ../views/index.php?error=emptyInput");
//            echo "empty Input";
//            var_dump($this->email,$this->address,$this->relationship,$this->name,$this->phone_no,$this->parents_name,$this->roll_id,$this->parent_no);
            exit();
        }

        // this is to help if the email user has given is invalid
        if(!$this->checkInvalidEmail()){
            header("Location: ../views/index.php?error=invalidEmail");
            exit();
        }
        // this is to check if the username,parent's name,relationship is in proper format i.e all should be in string
        if(!$this->checkValidUser()){
            header("Location: ../views/index.php?error=invalidUser");
            exit();
        }
        // this is to check if the user that has given roll no the user has given is in integer format
        if(!$this->checkValidRollNo()){
            header("Location: ../views/index.php?error=invalidRollNo");
            exit();
        }

        $this->setUpUser($this->name,$this->parents_name,$this->phone_no,$this->relationship,$this->email,$this->roll_id,$this->parent_no,
            $this->address);



    }

    public function updateLocationId($address): void
    {
        $locationId = $this->getLocationIdByAddress($address);

        $sql = "UPDATE STUDENT SET location_id = :locationId WHERE address = :address";
        $stmt = $this->db_connection()->prepare($sql);
        $stmt->bindParam(':locationId', $locationId);
        $stmt->bindParam(':address', $address);
        $stmt->execute();
    }

    private function getLocationIdByAddress($address)
    {
        $sql = "SELECT location_id FROM LOCATIONS WHERE location_name = :address";
        $stmt = $this->db_connection()->prepare($sql);
        $stmt->bindParam(':address', $address);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result !== false) ? $result['location_id'] : null;
    }

    public function assignBusToStudent(): void
    {
        $sql = "UPDATE STUDENT s
            INNER JOIN LOCATIONS l ON s.location_id = l.location_id AND s.address = l.location_name
            INNER JOIN ROUTES r ON l.route_id = r.route_id
            INNER JOIN bus b ON r.bus_id = b.bus_id
            SET s.bus = b.bus_num";

        $stmt = $this->db_connection()->prepare($sql);
        $stmt->execute();
    }


    // this helps to check for the empty field if the user has given some empty input
    private function emptyInput(): bool
    {
        // initially setting up the result as null to check whether the input is valid or not
        $result = null;
        if(empty($this->name) || empty($this->parents_name) || empty($this->phone_no) || empty($this->relationship)
            || empty($this->email) || empty($this->roll_id) || empty($this->address) || empty($this->parent_no))
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