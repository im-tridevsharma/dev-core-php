<?php

class App
{

    public function __construct()
    {
        /**
         * load required things
         */
        require_once __DIR__ . '/helpers.php';
    }

    protected function setInitials()
    {
        $connection = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $app_url = $connection . $_SERVER['HTTP_HOST'] . '/' . basename(_BASE_DIR_);
        edit_env('APP_URL', $app_url);
        edit_env('DB_HOST', $_SERVER['HTTP_HOST']);
        edit_env('DB_USERNAME', 'root');
    }

    /**
     * start the applications
     */
    public function start()
    {
        $this->setInitials();
        define('_VIEW_DIR_', _BASE_DIR_ . '/' . env('SOURCE_DIR', 'src') . '/' . env('VIEW_DIR', 'Views'));
        //load config
        $config = require _BASE_DIR_ . '/config.php';

        //load base model
        require_once __DIR__ . '/BaseModel.php';

        //load base controller
        require_once __DIR__ . '/BaseController.php';

        //load default controller
        $d_controller = $config['default_controller'];
        $method = $config['default_call'];
        $controller = basename($d_controller);

        $request = $_REQUEST;
        if(isset($request['path'])){
            $_r = explode("/", $request['path']);
            $_rcontroller = ucfirst($_r[0]) ?? ucfirst($controller);
            $_rmethod = $_r[1] ?? 'index';

            $this->handleRequest("Src\Controllers\\".$_rcontroller, $_rcontroller, $_rmethod);
        }else{
            $this->handleRequest($d_controller, $controller, $method);
        }
    }

    //handle request
    protected function handleRequest($d_controller, $controller, $method)
    {
        $_controller = new $d_controller();
        if(method_exists($_controller, $method)){
            $_controller->$method();
        }else{
            die("Method '{$method}' not found in class '{$d_controller}'");
        }
    }
}
