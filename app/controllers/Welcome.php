<?php
namespace app\controllers;
use system\core\Controller;

class Welcome extends Controller {

    public function index() {
        $this->data['version'] = getVersion();        
        $this->title('My First Page');
        $this->view('welcome');
    }
}