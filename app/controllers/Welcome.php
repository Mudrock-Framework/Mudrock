<?php
namespace app\controllers;
use system\core\Controller;

class Welcome extends Controller {

    public function __construct() {
        $this->load_language('Welcome');
        $this->load_model('Welcome_model');
    }

    public function index() {
        $this->view('welcome');
    }
}