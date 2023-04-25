<?php

namespace models;
class Database_Connection
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    // a class that helps to define
    public function __construct($servername,$username,$password,$dbname){
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    // a function that returns the database connection
    public function connectdb(){
        $conn = mysqli_connect($this->servername,$this->username,$this->password,$this->dbname);
        if(!$conn){
            die("Connection failed " . $conn->connect_error);
        }
        return $conn;
    }

    // a function that will execute query
    public function execute_query($sql): \mysqli_result|bool
    {
        // this will set up the connection we need
        $conn = $this->connectdb();
        // it will help to execute the query
        $query = mysqli_query($conn,$sql);
        mysqli_close($conn);
        return $query;
    }

}