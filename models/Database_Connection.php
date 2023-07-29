<?php

namespace models;
use PDO;
use PDOException;

class Database_Connection
{
    public function db_connection(){
        try {
//            $servername = "localhost";
            $username = "bibek";
            $password = "bibek";
//            $db_name = "bus_route";
            return new PDO('mysql:host=localhost;dbname=bus_route',$username,$password);
        }
        catch(PDOException $e){
            print "Error!" . $e->getMessage() . "<br>";
            // making sure the db connection is closed
            die();
        }
    }

}
