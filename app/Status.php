<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Status extends Model
{
    const STATUS_NEW = 'new';
    const STATUS_PUBLISHED = 'published';
    const STATUS_REJECTED = 'rejected';

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'status';

    public $timestamps = false;

    public function feedbacks()
    {
        return $this->hasMany('App\Feedback');
    }

    public function getStatusNew()
    {
        return DB::table($this->table)
            ->select('*')
            ->where('status', 'like', self::STATUS_NEW)
            ->get();
    }
}
