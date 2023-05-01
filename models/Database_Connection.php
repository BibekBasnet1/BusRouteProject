<?php

namespace models;
use PDO;
use PDOException;

class Database_Connection
{
    protected function db_connection(){
        try {
//            $servername = "localhost";
            $username = "bus_route_project_admin";
            $password = "ruby";
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