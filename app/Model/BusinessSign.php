<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BusinessSign extends Model
{

    protected $table = 'pa_business_sign';

    public $timestamps = false;

    protected $primaryKey = 'bid';

    public function member()
    {
        return $this->belongsTo('App\Model\Member','uid','uid');
    }
}
