<?php
namespace Models;
use Resources;

class Validasi extends Resources\Validation {
    
    public function __construct()
    {
        parent::__construct();
        $this->db = new Resources\Database;
        $this->setRuleErrorMessages(
            array (
                'required' => '%label% tidak boleh kosong',
                'numeric' => '%label% harus berupa angka',
                'compare' => '%label% harus sama dengan %comparatorLabel%',
                'min' => '%label% harus lebih dari 5 karakter'
            )
        );
    }
    
    public function setRules()
    {
        return array (
            
            'id-posting' => array( //Validasi id posting
                'rules' => array(
                    'required'
                ),
                'label' => 'ID Posting',
                'filter' => array('trim')
            ),
            
            'judul' => array( //Validasi judul posting
                'rules' => array(
                    'required'
                ),
                'label' => 'Judul posting',
                'filter' => array('trim')
            ),
            
            'isi-posting' => array( //Validasi isi posting
                'rules' => array(
                    'required'
                ),
                'label' => 'Isi posting',
                'filter' => array('trim')
            ),
            
            'username' => array( //Validasi username
                'rules' => array(
                    'required'
                ),
                'label' => 'Username',
                'filter' => array('trim')
            ),
            
            /** Validasi ini digunakan untuk validasi password semua hak akses */
            'password' => array( //Validasi Password
                'rules' => array(
                    'required',
                    'min' => 5,
                    'regex' => '/^([-a-z0-9_-])+$/i',
                    'compare' => 'verifikasipass'
                ),
                'label' => 'Password',
                'filter' => array('trim')
            ),
            
            'verifikasipass' => array( //Validasi Verifikasi Password
                'rules' => array(
                    'required',
                    'min' => 5
                ),
                'label' => 'Verifikasi Password',
                'filter' => array('trim')
            )
        );
    }
    
//    public function ceknissiswa($field, $value)
//    {
//         $result = $this->db->row("SELECT NIS_SISWA FROM table_siswa WHERE NIS_SISWA='".$value."' ");
//         
//         if( $result == null)
//         return true;
//            
//         $this->setErrorMessage($field, 'NIS sudah ada');
//        
//         return false;
//    }
//    
//    public function cekusername_ortu($field, $value)
//    {
//         $result = $this->db->row("SELECT username FROM table_orang_tua WHERE username='".$value."' ");
//         
//         if( $result == null) {
//            return true;
//         }
//         else {
//            $this->setErrorMessage($field, 'Username sudah ada');
//            return false;
//         }
//    }
}
?>