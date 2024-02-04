<?php

namespace App\Models\User;

use App\Models\BaseModel;

class UserModel extends BaseModel
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $userType;
}
