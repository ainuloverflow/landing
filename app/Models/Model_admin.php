<?php
namespace Models;
use Resources;
 
class Model_admin {
    public function __construct(){
        $this->db = new Resources\Database;
    }
    
    public function loginadmin($username, $password){
    	Return $result = $this->db->row("SELECT * FROM users WHERE username = '$username' AND password = '$password' ");
    }
    
    public function total_posting() {
        Return $this->db->getVar("SELECT COUNT(id_posting) FROM posting");
    }
    
    public function total_users_posting() {
        Return $this->db->getVar("SELECT COUNT(id) FROM users_posting");
    }
    
    public function read_list_posting($page = 1, $limit = 10){
        $offset = ($limit * $page) - $limit;
        Return $this->db->results("SELECT * FROM posting ORDER BY id_posting ASC LIMIT $offset, $limit"); 
    }
    
    public function loginadmin_konten($username, $password){
    	Return $result = $this->db->row("SELECT * FROM users_posting WHERE username = '$username' AND password = '$password' ");
    }
    
    public function add_posting($data){
        Return $this->db->insert('posting', $data);
    }
    
    public function get_id_edit_posting($data){
        Return $this->db->row("SELECT * FROM posting WHERE id_posting = '$data'");
    }
    
    public function check_double_posts($value){
        Return $this->db->row("SELECT judul FROM posting WHERE judul = '$value'");
    }
    
    public function edit_posting($value, $where){
        Return $this->db->update('posting', $value, $where);
    }
}