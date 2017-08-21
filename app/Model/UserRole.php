<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{

    protected $table = 'la_users_role';

    public $timestamps = false;

    protected $primaryKey = 'roleid';
}
