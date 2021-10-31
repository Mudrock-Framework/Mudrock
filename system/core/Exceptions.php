<?php
namespace system\core;
use system\core\Controller;

class Exceptions extends Controller {

    public function error(String $error, String $description = NULL) {
        switch ($error) {

            case 'undefined_route':
                $this->callControllerMessage(404, 'Undefined Route', 'The route informed has no method defined:', $description);
                break;

            case 'route_not_found':
                $this->callControllerMessage(404, 'Route not found', 'The route informed was not found:', $description);
                break;

            case 'controller_not_found':
                $this->callControllerMessage(404, 'Controller not found', 'The Controller informed was not found:', $description);
                break;

            case 'method_not_found':
                $this->callControllerMessage(404, 'Method not found', 'The Method informed was not found:', $description);
                break;

            case 'request_not_allowed':
                $this->callControllerMessage(404, 'Request type not allowed', 'This type of request is not allowed for this route:', $description);
                break;
            
            case 'request_method_not_allowed':
                $this->callControllerMessage(404, 'Request method type not allowed', 'This type of request method is not allowed:', $description);
                break;
            
            default:
                break;
        }
    }


    private function callControllerMessage(Int $code, String $title, String $message, String $description) {
        http_response_code($code);
        $this->title($title);
        $this->exception('error', [
            'base_url' => BASE_URL,
            'message' => $message,
            'description' => $description,
            'code' => $code
        ]);
    }

}