<?php
require_once("new_config.php");

class Database
{
    //instance variables
    public $connection;

    //constructor
    function __construct(){
        $this->open_db_connection();
    }

    //function to connect with database
    public function open_db_connection(){
        //$this->connection = mysqli_connect(DB_HOST,DB_USER, DB_PASS, DB_NAME);
        $this->connection = new mysqli(DB_HOST,DB_USER, DB_PASS, DB_NAME);
        if($this->connection->connect_errno) {
            die ("Failed" . $this->connection->connect_errno);
        }
    }

    //function to make queries
    public function query($sql){
        $result = $this->connection->query($sql);
        $this->confirm_query($result);
        return $result;
    }

    //function to check my queries
    private function confirm_query($result){
        if(!$result){
            die ("Query Failed" . $this->connection->error);
        }
    }

    //function to escape strings to secure my database
    public function escape_string($string){
       //$escaped_string =  mysqli_real_escape_string($this->connection,$string);
        $escaped_string =  $this->connection->real_escape_string($string);
       return $escaped_string;
    }

    //function to get the last id inserted in database
    public function the_insert_id(){
        return mysqli_insert_id($this->connection);
    }

}//class end

//object from Database class
$database = new Database();
