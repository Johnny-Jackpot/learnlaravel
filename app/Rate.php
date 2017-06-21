<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'rate';

    public $timestamps = false;

    public function feedbacks()
    {
        return $this->hasMany('App\Feedback', 'rate_id');
    }
}
