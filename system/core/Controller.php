<?php
namespace system\core;

class Controller {

    protected $data = [];
    protected $language = [];
    public $model;
    protected $model_name;

    protected function view(String $view) {
        $file_view = '.././app/views/' . $view . '.php';
        if (file_exists($file_view)) {
            extract($this->data);
            include($file_view);
        } else {
            $exception = new Exceptions();
            $exception->error('view_not_found', $view);
        }
    }

    protected function title(String $title) {
        echo '<title>'. $title .'</title>';
    }

    protected function var($variable_name, $value) {
        $this->data[$variable_name] = $value;
    }

    protected function exception(String $type, $params = []) {
        $total_params = array_merge_recursive($params, $this->data);
        extract($total_params);
        include('.././system/core/src/message_'.$type.'.php');
    }

    protected function load_language(String $file) {
        $folder = ($this->getSession('language')) ? $this->getSession('language') : DEFAULT_LANGUAGE;
        $filename = '.././app/languages/'. $folder .'/'. $file .'.php';
        if(file_exists($filename)) {
            $this->language = include $filename;
        } else {
            $this->language = [];
        }
    }

    protected function load_model(String $file) {
        $filename = '.././app/models/'. $file .'.php';
        if(file_exists($filename)) {
            $this->model_name = $file;
            include $filename;
            $final_file = "\system\core\\".$this->model_name;
            $this->model = new $final_file;
        }
    }

    public function lang(String $word) {
        try {
            echo $this->language[$word];
        } catch (\Throwable $th) {
            echo '';
        }
    }

    protected function validate(Array $data, String $type_request) {
        $type_request = strtoupper($type_request);
        $dados = ['name', 'email', 'pass'];
        $errors = [];
        foreach ($data as $input) {
            if ($type_request == 'POST') {
                (@$_POST[$input]) ? : array_push($errors, $input);
            }
            else if ($type_request == 'GET') {
                (@$_GET[$input]) ? : array_push($errors, $input);
            }
        }
        if (!empty($errors)) {
            if (count($errors) > 1) {
                $exception = new Exceptions();
                $exception->error('validate_inputs_fail', implode(', ', $errors));
                return FALSE;
            } else {
                $exception = new Exceptions();
                $exception->error('validate_input_fail', $errors[0]);
                return FALSE;
            }
        }
        return TRUE;
    }

    protected function setSession(string $column, string $value) {
        (new Session)->set($column, $value);
    }

    protected function getSession(string $column) {
        return (new Session)->get($column);
    }

    public function destroySession(string $column = NULL) {
        (new Session)->destroy($column);
    }
}