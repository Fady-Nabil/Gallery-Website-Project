<?php


class Session
{
    //instance variables
    private $signed_in = false;
    public $user_id;
    public $message;
    public $count;

    //constructor
    function __construct()
    {
        session_start();
        $this->check_the_login();
        $this->visitor_account();
        $this->check_message();
    }
    //function to count users in website
    public function visitor_account(){
        if(isset($_SESSION['count'])){
            return $this->count = $_SESSION['count']++;
        } else {
            return $_SESSION['count'] = 1;
        }
    }
    //function to check is user logged in or not
    public function is_signed_in(){
        return $this->signed_in;
    }
    //function to login
    public function login($user){
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }
    }

    //function to logout
    public function logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    //function to check if user logged in or not
    private function check_the_login(){
        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        } else {
            unset($this->user_id);
            $this->signed_in = false;
        }
    }

    //function to display messages to users
    public function message($msg=""){
        if(!empty($msg)){
            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    //function to check session
    private function check_message(){
        if(isset($_SESSION['message'])){
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }
}

//object
$session = new Session();