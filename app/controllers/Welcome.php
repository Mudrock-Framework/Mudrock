<?php
namespace app\controllers;
use system\core\Controller;

class Welcome extends Controller {

    public function __construct()
    {
        $this->language('Welcome');
    }

    public function index() {
        $this->var('teste', 'teste');
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