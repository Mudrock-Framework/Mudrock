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

}