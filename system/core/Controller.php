<?php
namespace system\core;

use stdClass;

class Controller {

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $language = [];

    /**
     * @var stdClass
     */
    public $model;

    /**
     * @var string
     */
    protected $model_name;

    /**
     * @var array
     */
    protected $inputs;

    /**
     * @param string|NULL $input_name
     * @return array|mixed
     */
    protected function request(string $input_name = NULL): array
    {
        if (empty($this->inputs)) {
            $json = file_get_contents('php://input');
            if (!empty($json)) {
                $final_inputs = array_merge_recursive((array) json_decode($json), $_REQUEST);
            } else {
                $final_inputs = $_REQUEST;
            }
            $this->inputs = $final_inputs;
        }

        if ($input_name) {
            return $this->inputs[$input_name];
        }

        return $this->inputs;
    }

    /**
     * @param String $view
     * @return bool
     */
    protected function view(String $view): bool
    {
        $file_view = '.././app/views/' . $view . '.php';

        if (file_exists($file_view)) {
            extract($this->data);
            include($file_view);
            if (BOOTSTRAP) {
                echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">';
                echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>';
            }

            return true;
        }

        $exception = new Exceptions();
        $exception->error('view_not_found', $view);

        return false;
    }

    /**
     * @param String $title
     * @return void
     */
    protected function title(String $title): void
    {
        echo '<title>'. $title .'</title>';
    }

    /**
     * @param $variable_name
     * @param $value
     * @return void
     */
    protected function var(string $variable_name, string $value): void
    {
        $this->data[$variable_name] = $value;
    }

    /**
     * @param string $type
     * @param array $params
     * @return void
     */
    protected function exception(string $type, array $params = []): void
    {
        $total_params = array_merge_recursive($params, $this->data);
        extract($total_params);
        include('.././system/core/src/message_'.$type.'.php');
    }

    /**
     * @param string $file
     * @return void
     */
    protected function load_language(string $file): void
    {
        $folder = (getSession('language')) ? getSession('language') : DEFAULT_LANGUAGE;
        $filename = '.././app/languages/'. $folder .'/'. $file .'.php';

        if(file_exists($filename)) {
            $this->language = include $filename;
            return;
        }

        $this->language = [];
    }

    /**
     * @param string $file
     * @return void
     */
    protected function load_model(string $file): void
    {
        $filename = '.././app/models/'. $file .'.php';

        if(file_exists($filename)) {
            $this->model_name = $file;
            include $filename;
            $final_file = "\system\core\\".$this->model_name;
            $this->model = new $final_file;
        }
    }

    /**
     * @param string $word
     * @return void
     */
    public function lang(string $word): void
    {
        try {
            echo $this->language[$word];
        } catch (\Throwable $th) {
            echo '';
        }
    }

    /**
     * @param array $data
     * @param string $type_request
     * @return bool
     */
    protected function validate(array $data, string $type_request): bool
    {
        $type_request = strtoupper($type_request);
        $errors = [];

        foreach ($data as $input) {
            switch ($type_request) {
                case 'POST':
                    (@$_POST[$input]) ? : array_push($errors, $input);
                    break;
                case 'GET':
                    (@$_GET[$input]) ? : array_push($errors, $input);
                    break;
            }
        }

        if (!empty($errors)) {
            if (count($errors) > 1) {
                $exception = new Exceptions();
                $exception->error('validate_inputs_fail', implode(', ', $errors));
                return false;
            }

            $exception = new Exceptions();
            $exception->error('validate_input_fail', $errors[0]);

            return false;
        }

        return true;
    }

    /**
     * @param array $array_username
     * @param array $array_password
     * @param string $table
     * @return bool
     */
    protected function do_login(array $array_username, array $array_password, string $table) {
        $model = new Model();

        return $model->do_login($array_username, $array_password, $table);
    }
}
