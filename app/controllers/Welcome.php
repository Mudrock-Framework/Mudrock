<?php
namespace app\controllers;
use system\core\Controller;

class Welcome extends Controller {

    public function __construct()
    {
        $this->language('Welcome');
    }

    public function index() {
        $this->setSession('teste', 'Testando uma sessão');
        $this->data['version'] = getVersion();
        $this->title('My First Page');
        $this->view('welcome');
    }

    public function langPt() {
        $this->setLanguage('pt_br');
    }

    public function langDefault() {
        $this->setLanguage();
    }
}