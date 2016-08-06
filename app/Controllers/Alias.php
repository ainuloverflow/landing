<?php
namespace Controllers;
use Resources;

class Alias
{
    public function index() {
    
    $args = func_get_args();

    $route = [
        
        'administrator-home' => [
            'class' => '\\Controllers\Admin',
            'method' => 'index'
        ],
        
        'administrator-konten-home' => [
            'class' => '\\Controllers\Admin',
            'method' => 'admin_isi_konten'
        ],
        
        'list-posting-admin' => [
            'class' => '\\Controllers\Admin',
            'method' => 'list_posting_as_admin'
        ],
                           
        'add-posting-admin' => [
            'class' => '\\Controllers\Admin',
            'method' => 'tambah_posting_as_admin'
        ],
              
        'edit-posting-admin' => [
            'class' => '\\Controllers\Admin',
            'method' => 'edit_posting_as_admin'
        ],
        
        'validasi-posting-admin' => [
            'class' => '\\Controllers\Admin',
            'method' => 'validasi_posting_as_admin'
        ],
        
        'delete-posting-admin' => [
            'class' => '\\Controllers\Admin',
            'method' => 'delete_posting_as_admin'
        ],
        
        'login-admin' => [
            'class' => '\\Controllers\Admin',
            'method' => 'login'
        ],
        
        'logout' => [
            'class' => '\\Controllers\Admin',
            'method' => 'logout'
        ]
    ];

    if( in_array($args[0], ['administrator-home', 'list-posting-admin', 'administrator-konten-home', 'add-posting-admin', 'edit-posting-admin', 'validasi-posting-admin', 'delete-posting-admin', 'login-admin', 'logout'])) {

        try {
            $route[$args[0]]['class'] = new $route[$args[0]]['class'];

            call_user_func_array(
                array_values($route[$args[0]]),
                array_slice($args, 1)
            );
        }
        catch(\Exception $e) {
        throw new HttpException('Page not found!');
        
        }
    }
    }
}