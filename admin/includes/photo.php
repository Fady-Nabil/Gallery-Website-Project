<?php


class Photo extends Db_object{

    //instance variables
    public $id;
    public $title;
    public $caption;
    public $description;
    public $filename;
    public $alternate_text;
    public $type;
    public $size;
    protected static $db_table = "photos";
    protected static $db_table_fields = array('id','title','caption','description','filename','alternate_text','type','size');

    public $tmp_path;
    public $upload_directory = "images";

    //this is passing $_FILES['uploaded_file'] as an argument
    public function set_file($file){
        if(empty($file) || !$file || !is_array($file)){
            $this->errors[] = "there was no file uploaded here";
            return false;
        }else if ($file['error'] != 0){
            $this->errors[] = $this->upload_errors_array[$file['error']];
        } else {
            $this->filename = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }//end function

    //function to provide us picture path
    public function picture_path(){
        return $this->upload_directory.DS.$this->filename;
    }

    //function to save uploaded file
    public function save() {
        if($this->id) {
            $this->update();
        } else {
            if(!empty($this->errors)){
                return false;
            }
            if(empty($this->filename) || empty($this->tmp_path)){
                $this->errors[] = "the file was not available";
                return false;
            }
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;
            if(file_exists($target_path)){
                $this->errors[] = "the file {$this->filename} already exists";
                return false;
            }
            if(move_uploaded_file($this->tmp_path, $target_path)){
                if($this->create()){
                    unset($this->tmp_path);
                    return true;
                }
            } else {
                $this->errors[] = "the file directory wasprobably doesn't have permission";
                return false;
            }
        }
    }

    //function to delete picture from the table (delete method in class will make that) and from the server
    public function delete_photo(){
        if($this->delete()){
            $target_path = SITE_ROOT .DS . 'admin' . DS . $this->picture_path();
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }
}//end class