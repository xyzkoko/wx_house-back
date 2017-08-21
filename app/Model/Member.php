<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $table = 'pa_user';

    public $timestamps = false;

    protected $primaryKey = 'uid';
}
