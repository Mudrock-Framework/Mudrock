<?php
namespace system\core;

class Exceptions extends Controller {

    public function __construct() {
        //
    }

    /**
     * @param string $error
     * @param string|NULL $description
     * @return void
     */
    public function error(string $error, string $description = NULL): void
    {
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

            case 'view_not_found':
                $this->callControllerMessage(404, 'View file not found', 'The view file was not found in the "app/views/" folder:', $description);
                break;

            case 'validate_input_fail':
                $this->callControllerMessage(404, 'Required field not entered', 'The following field are required:', $description);
                break;

            case 'validate_inputs_fail':
                $this->callControllerMessage(404, 'Required fields not entered', 'The following fields are required:', $description);
                break;
            
            default:
                break;
        }
    }

    /**
     * @param int $code
     * @param string $title
     * @param string $message
     * @param string $description
     * @return void
     */
    private function callControllerMessage(int $code, string $title, string $message, string $description): void
    {
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
