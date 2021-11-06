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

    public function langPt() {
        setLanguage('pt_br');
    }

    public function langDefault() {
        setLanguage();
    }
}