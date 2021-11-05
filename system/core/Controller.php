<?php
namespace system\core;

class Controller {

    protected $data = [];
    public $language = [];

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

    protected function language(String $file) {
        $folder = ($this->getSession('language')) ? $this->getSession('language') : DEFAULT_LANGUAGE;
        $filename = '.././app/languages/'. $folder .'/'. $file .'.php';
        if(file_exists($filename)) {
            $this->language = include $filename;
        } else {
            $this->language = [];
        }
    }

    public function lang(String $word) {
        try {
            echo $this->language[$word];
        } catch (\Throwable $th) {
            echo '';
        }
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