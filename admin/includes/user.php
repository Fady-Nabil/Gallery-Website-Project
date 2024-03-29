<?php


class User extends Db_object
{
    //instance variables
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $user_image;
    public $upload_directory = "images";
    public $image_placeholder = "http://plcehold.it/400x400&text=image";

    protected static $db_table = "users";
    protected static $db_table_fields = array('username','password','first_name','last_name','user_image');



    //function to verify user
    public static function verify_user($username,$password){
        global $database;

        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql  = "SELECT * FROM "  . static::$db_table . " users WHERE    ";
        $sql .= "username = '{$username}'     ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";

        $the_result_array = static::find_by_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array): false;
    }

    //function to get user image
    public function image_path_and_placeholder(){
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS .$this->user_image ;
    }

    //this is passing $_FILES['uploaded_file'] as an argument
    public function set_file($file){
        if(empty($file) || !$file || !is_array($file)){
            $this->errors[] = "there was no file uploaded here";
            return false;
        }else if ($file['error'] != 0){
            $this->errors[] = $this->upload_errors_array[$file['error']];
        } else {
            $this->user_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }//end function

    //function to save uploaded file
    public function upload_photo() {

            if(!empty($this->errors)){
                return false;
            }
            if(empty($this->user_image) || empty($this->tmp_path)){
                $this->errors[] = "the file was not available";
                return false;
            }
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;
            if(file_exists($target_path)){
                $this->errors[] = "the file {$this->user_image} already exists";
                return false;
            }
            if(move_uploaded_file($this->tmp_path, $target_path)){
                    unset($this->tmp_path);
                    return true;
            } else {
                $this->errors[] = "the file directory wasprobably doesn't have permission";
                return false;
            }
    }

}//end user class