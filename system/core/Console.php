<?php
namespace system\core;

class Console {

    public function generate(string $name_file) {
        $controller_name = ucfirst($name_file);
        $model_name = ucfirst($name_file) . '_model';
        $table_example = strtolower($name_file);

        $content_controller = "
            <?php
            
            namespace app\controllers;
            use system\core\Controller;
            
            class $controller_name extends Controller {
            
                public function __construct() {
                    \$this->load_language('$name_file');
                    \$this->load_model('$model_name');
                }
            
                public function index() {
                    \$this->view('$name_file');
                }
            }
            
            ?>";

        $content_model = "
            <?php
            
            namespace system\core;
            
            class $model_name extends Model {
            
                public function example_select() {
                    \$this->table('$table_example');
                    return \$this->result();
                }
            
            }
            
            ?>";

        file_put_contents('./app/controllers/' . $name_file . '.php', $content_controller);
        file_put_contents('./app/models/' . $model_name . '.php', $content_model);
    }

}