<?php
namespace app\controllers;
use system\core\Controller;

class Welcome extends Controller {

    public function __construct() {
        $this->load_language('Welcome');
        $this->load_model('Welcome_model');
    }

    public function index() {
        $this->var('users', $this->model->getUsers('users'));
        $this->title('My First Page');
        $this->view('welcome');
    }

    public function login() {
        /* ---------------------------------------------------------------------------------------------------
           | To use the "$this->login( )" method, which validates that the login and password are correct, |
           |      you will need to create two arrays (one for the login data and one for the password),      |
           |      the name of the database table and whether the password is encrypted in the database       |
           ---------------------------------------------------------------------------------------------------
            Example:

            $array_login = [
                "column_name_login" => "login sent by user (input)"
            ];

            $array_password = [
                "column_name_password" => "user-sent password (input)"
            ];

            $user_table_name = "users";
         ------------------------------------------------------------------------------------------------------- */

        $username_data = [
            'email' => $this->request('email')
        ];

        $password_data = [
            'password' => $this->request('password')
        ];

        if ($this->do_login($username_data, $password_data, 'users') == TRUE) {
            echo 'Login successful!';
        } else {
            echo 'Incorrect data!';
        }

    }

    public function changeLanguage() {
        /*
            Enter the language folder name as a parameter or leave it empty to use the default language.
            You can enter a default language in "DEFAULT_LANGUAGE" in the "app/config/config.php" file
        */
        setLanguage('pt_br');
    }
}