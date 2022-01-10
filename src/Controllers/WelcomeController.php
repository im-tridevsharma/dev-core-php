<?php namespace Src\Controllers;

use \Core\BaseController;

class WelcomeController extends BaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        $data['title'] = 'Core Dev Php';
        return view('welcome', $data);
    }
}