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

    public function changeLanguage() {
        /*
        Enter the language folder name as a parameter or leave it empty to use the default language.
        You can enter a default language in "DEFAULT_LANGUAGE" in the "app/config/config.php" file
        */
        setLanguage('pt_br');
    }
}