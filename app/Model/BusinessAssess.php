<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BusinessAssess extends Model
{

    protected $table = 'pa_business_assess';

    public $timestamps = false;

    protected $primaryKey = 'bid';

    public function member()
    {
        return $this->belongsTo('App\Model\Member','uid','uid');
    }
    public function business_sign()
    {
        return $this->hasOne('App\Model\BusinessSign','bid','bid');
    }
    public function business()
    {
        return $this->belongsTo('App\Model\Business','bid','bid');
    }
}
