<?php namespace Src\Controllers;

use \Core\BaseController;
use Core\Lib\Database;

class Welcome extends BaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        $data['title'] = 'Dev Core Php';
        return view('welcome', $data);
    }

    public function database()
    {
        $db = new Database;
        $db->newTable("users", [
            [
                'name'  => 'id',
                'type'  => 'int',
                'auto_increment' => true,
            ],
            [
                'name'    => 'first_name',
                'type'    => 'string',
                'null'    => true
            ],
            [
                'name'    => 'last_name',
                'type'    => 'string',
                'null'    => true
            ],
            [
                'name'    => 'email',
                'type'    => 'string',
                'null'    => true
            ],
            [
                'name'    => 'mobile',
                'type'    => 'string',
                'length'  => 20,
                'null'    => true
            ],
            [
                'name'    => 'dob',
                'type'    => 'timestamp',
                'null'    => true
            ],
            [
                'name'    => 'created_at',
                'type'    => 'timestamp',
                'null'    => true
            ],
            [
                'name'    => 'updated_at',
                'type'    => 'timestamp',
                'update'  => true
            ],
        ]);
    }
}