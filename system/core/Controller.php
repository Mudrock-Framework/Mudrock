<?php
namespace system\core;

class Controller {

    protected $data = [];

    protected function view(String $view, $params = []) {
        $twig = new \Twig\Environment(
            new \Twig\Loader\FilesystemLoader('.././app/views/')
        );        
        $total_params = array_merge_recursive($params, $this->data);
        echo $twig->render($view . '.mud.php', $total_params);
    }

    protected function title(String $title) {
        $twig = new \Twig\Environment(
            new \Twig\Loader\FilesystemLoader(getcwd().'/../system/core/')
        );
        echo $twig->render('Header.php', ['titulo' => $title]);
    }

    protected function exception(String $type, $params = []) {
        $twig = new \Twig\Environment(
            new \Twig\Loader\FilesystemLoader('.././system/core/src/')
        );
        $total_params = array_merge_recursive($params, $this->data);
        echo $twig->render('message_'.$type.'.mud.php', $total_params);
    }

    protected function language(String $file = NULL) {
        $folder = ($this->getSession('language')) ? $this->getSession('language') : DEFAULT_LANGUAGE;
        $filename = '.././app/languages/'. $folder .'/'. $file .'.php';
        if(file_exists($filename)) {
            $this->data['lang'] = include $filename;
        } else {
            $this->data['lang'] = [];
        }
    }

    protected function setLanguage(String $folder_language = NULL) {
        if ($folder_language) {
            $idiom = $folder_language;
        } else {
            $idiom = DEFAULT_LANGUAGE;
        }
        (new Session)->set('language', $idiom);
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