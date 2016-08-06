<?php
namespace Controllers;
use Resources, Models;

class Admin extends Resources\Controller
{
    public function __construct(){
        parent::__construct();
        $this->model_admin = new Models\Model_admin;
        $this->model_admin_post = new Models\Model_admin_posting;
        $this->post = new Resources\Request;
        $this->session = new Resources\Session;
        $this->validasi = new Models\Validasi;
    }
    
    public function cek_administrator(){
        if($this->session->getValue('level') == 1) {
            return true;
        }
        else {
            header("Location:./login-admin");
            return false;
        }
    }
    
    public function cek_administrator_konten(){
        if($this->session->getValue('level') == 2) {
            return true;
        }
        else {
            header("Location:./login-admin");
            return false;
        }
    }
    
    public function index() {
        $this->cek_administrator();
        $data = array(
            'titlename' => 'Administrator',
            'headername' => 'Administrator',
            'username' => $this->session->getValue('username'),
            'whois' => 'Administrator',
            'url' => $this->uri->baseUri,
            'total_posting' => $this->model_admin->total_posting(),
            'total_users_posting' => $this->model_admin->total_users_posting()
        );
        $this->output('admin-views/header-backend-administrator', $data);
        $this->output('admin-views/sidebar-backend-administrator', $data);
        $this->output('admin-views/main-konten-backend-administrator', $data);
        $this->output('admin-views/copyright-backend-administrator', $data);
        $this->output('admin-views/controlpanel-gear-backend-administrator', $data);
        $this->output('admin-views/footer-backend-administrator', $data);
    }
    
    public function list_posting_as_admin($page = 1){
        $this->cek_administrator();
        $page = (int) $page;
        $limit = 10;
        
        $data = array(
            'baca_posting' =>$this->model_admin->read_list_posting($page, $limit),
            'titlename' => 'Administrator',
            'username' => $this->session->getValue('username'),
            'whois' => 'Administrator',
            'headername' => 'Administrator',
            'url' => $this->uri->baseUri
        );
        $this->output('admin-views/list-posting-backend-administrator', $data);
    }
    
    public function tambah_posting_as_admin(){
        $this->cek_administrator();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->validasi->validate()) {
                $values = array (
                    'judul' => $this->post->POST('judul',FILTER_SANITIZE_MAGIC_QUOTES),
                    'isi' => $this->post->POST('isi-posting',FILTER_SANITIZE_MAGIC_QUOTES),
                    'creator_konten' => $this->session->getValue('username')
                );
                $this->exec_insert_posts($values);
            }
        }
        $data = array (
            'validasi' => $this->validasi,
            'username' => $this->session->getValue('username'),
            'whois' => 'Administrator',
            'bodytitle' => 'Tambah Posting',
            'titlename' => 'Administrator',
            'headername' => 'Administrator',
            'nama' => $this->session->getValue('username'),
            'url' => $this->uri->baseUri
        );
        $this->output('admin-views/tambah-konten-backend-administrator', $data);
    }
    
    public function edit_posting_as_admin(){
        $this->cek_administrator();
        $param_url = addslashes($this->resource->uri->path(1));
        
        $data = array(
            'edit' => $this->model_admin->get_id_edit_posting($param_url),
            'titlename' => 'Administrator',
            'bodytitle' => 'Edit Posting',
            'username' => $this->session->getValue('username'),
            'whois' => 'Administrator',
            'headername' => 'Administrator',
            'url' => $this->uri->baseUri
        );
        $this->output('admin-views/edit-konten-backend-administrator', $data);
        
    }
    
    public function validasi_posting_as_admin(){
        $this->cek_administrator();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->validasi->validate()) {
                $values = array (
                    'judul' => $this->post->POST('judul',FILTER_SANITIZE_MAGIC_QUOTES),
                    'isi' => $this->post->POST('isi-posting',FILTER_SANITIZE_MAGIC_QUOTES),
                    'creator_konten' => $this->session->getValue('username')
                );
                $where = array(
                    'id_posting' => $this->post->POST('id_posting', FILTER_SANITIZE_NUMBER_INT)
                );              
                //Passing ke fungsi query edit
                $this->exec_edit_posts($values, $where);
            }
        }
        $data =array(
            'validasi' => $this->validasi,
            'titlename' => 'Administrator',
            'bodytitle' => 'Validasi Posting',
            'username' => $this->session->getValue('username'),
            'whois' => 'Administrator',
            'headername' => 'Administrator',
            'url' => $this->uri->baseUri
        );
        $this->output('admin-views/validasi-konten-backend-administrator', $data);
    }
    
    //Admin isi konten (Non administrator mode)
    public function admin_isi_konten(){
        $this->cek_administrator_konten();
        $data = array(
            'titlename' => 'Administrator konten',
            'headername' => 'Administrator konten',
            'url' => $this->uri->baseUri,
            'total_posting' => $this->model_admin->total_posting(),
        );
        $this->output('admin-konten-views/header-backend-administrator-konten', $data);
        $this->output('admin-konten-views/sidebar-backend-administrator-konten', $data);
        $this->output('admin-konten-views/main-tambah-posting-backend-administrator-konten', $data);
        $this->output('admin-konten-views/copyright-backend-administrator-konten', $data);
        $this->output('admin-konten-views/controlpanel-gear-backend-administrator-konten', $data);
        $this->output('admin-konten-views/footer-backend-administrator-konten', $data);
    }
    
    public function login() {
        if($this->session->getValue('level') == 1 ){
            $this->redirect('administrator-home');
        }
        else if($this->session->getValue('level') == 2 ){
            $this->redirect('administrator-konten-home');
        }
        else {
            $salah = '';
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $this->post->POST('username', FILTER_SANITIZE_MAGIC_QUOTES);
            $password = md5($this->post->POST('password', FILTER_SANITIZE_MAGIC_QUOTES));

            $admin = $this->model_admin->loginadmin($username, $password);
            $adminkonten = $this->model_admin_post->loginadmin_konten($username, $password);

            if(empty($username) OR empty($password)) {
                $salah = "Maaf username dan password tidak boleh kosong !!";
            }
                if($salah == '') {
                    if($admin) {
                        $data = array(
                            'isLogin' => true,
                            'username' => $admin->username,
                            'level' => $admin->level
                        );
                        $this->session->setValue($data);
                        header("Location:./administrator-home");
                    }

                    else if($adminkonten) {
                        $data = array(
                            'isLogin' => true,
                            'username' => $adminkonten->username,
                            'level' => $adminkonten->level
                        );
                        $this->session->setValue($data);
                        header("Location:./administrator-konten-home");
                    }
                    else {
                        $salah = "Maaf username dan password anda tidak terdaftar !!";
                    }
                }
                    echo "<script>alert('$salah'); window.location = 'login-admin' </script>";			
            }
            $data = array (
                'title' => 'Login',
                'title_whois' => 'Administrator',
                'main' => 'Login',
                'title_main' => 'Administrator',
                'url' => $this->uri->baseUri
            );
            $this->output('view_loginadmin', $data);
        }
    }
    
    public function exec_edit_posts($values, $where){
        $this->cek_administrator();
        $results = $this->model_admin->edit_posting($values, $where);
        if($results > 0){
            echo "<script>alert('Data berhasil diperbarui'); window.location = 'list-posting-admin' </script>";
            return true;
        }
        else{
            echo "<script>alert('Data gagal diperbarui'); window.location = 'list-posting-admin' </script>";
            return false;
        } 
    }
    
    public function exec_insert_posts($values){
        $results = $this->model_admin->add_posting($values);
        if($results > 0) {
            echo "<script>alert('Data berhasil dimasukan'); window.location = 'list-posting-admin' </script>";
            return true;
        }
        else {
            echo "<script>alert('Data gagal dimasukan'); window.location = 'list-posting-admin' </script>";
            return false;
        }
    }
    
    public function logout(){
        $this->session->destroy();
        $this->redirect('login-admin');
    }
}