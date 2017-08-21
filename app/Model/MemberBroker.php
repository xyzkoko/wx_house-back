<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MemberBroker extends Model
{

    protected $table = 'pa_role_broker';

    public $timestamps = false;

    protected $primaryKey = 'uid';

    public function member()
    {
        return $this->belongsTo('App\Model\Member','uid','uid');
    }
}
