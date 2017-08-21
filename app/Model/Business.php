<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{

    protected $table = 'pa_business';

    public $timestamps = false;

    protected $primaryKey = 'bid';

    public function business_assess()
    {
        return $this->hasOne('App\Model\BusinessAssess','bid','bid');
    }

    public function business_sign()
    {
        return $this->hasOne('App\Model\BusinessSign','bid','bid');
    }

    public function member()
    {
        return $this->belongsTo('App\Model\Member','uid','uid');
    }
}
