<?php

namespace Src\Models;

use Core\BaseModel;

class UserModel extends BaseModel{

    protected $table = "users";

    public function index()
    {
        return $this->table;
    }
}