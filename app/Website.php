<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Website extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'website';

    public $timestamps = false;

    public function feedbacks()
    {
        return $this->hasMany('App\Feedback', 'website_id');
    }

    public function getWebsite($site)
    {
        return DB::table($this->table)
            ->select('*')
            ->where('name', 'like', $site)
            ->get();
    }

    public function saveWebsite($site)
    {
        $this->name = $site;
        $this->save();

        return $this;
    }
}
