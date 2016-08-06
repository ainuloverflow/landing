<?php
namespace Models;
use Resources;
 
class Model_admin_posting {
    public function __construct(){
        $this->db = new Resources\Database;
    }
     public function loginadmin_konten($username, $password){
    	Return $result = $this->db->row("SELECT * FROM users_posting WHERE username = '$username' AND password = '$password' ");
    }
}