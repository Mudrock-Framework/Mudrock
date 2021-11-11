
<?php

namespace app\controllers;
use system\core\Controller;

class Novo extends Controller {

    public function __construct() {
        $this->load_language('novo');
        $this->load_model('novo_model');
    }

    public function index() {
        $this->view('novo');
    }
}

?>