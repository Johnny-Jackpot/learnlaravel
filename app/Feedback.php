<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Feedback extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'feedback';

    public $timestamps = false;

    public function author()
    {
        return $this->belongsTo('App\Author');
    }

    public function website()
    {
        return $this->belongsTo('App\Website');
    }

    public function rate()
    {
        return $this->belongsTo('App\Rate');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function getAllPublishedFeedbacks()
    {
        return DB::table('feedback')
            ->join('author', 'feedback.author_id', '=', 'author.id')
            ->join('website', 'feedback.website_id', '=', 'website.id')
            ->join('rate', 'feedback.rate_id', '=', 'rate.id')
            ->join('status', 'feedback.status_id', '=', 'status.id')
            ->select('author.name as author',
                'feedback.date as date',
                'website.name as website',
                'feedback.feed as feedback',
                'rate.rate as rate')
            ->where('status.status', 'like', 'published')
            ->get();
    }

    public function getNewPublishedFeedbacksSinceDate($date)
    {
        $date = strtotime($date);
        $date = date('Y-m-d H:i:s', $date);

        return DB::table('feedback')
            ->join('author', 'feedback.author_id', '=', 'author.id')
            ->join('website', 'feedback.website_id', '=', 'website.id')
            ->join('rate', 'feedback.rate_id', '=', 'rate.id')
            ->join('status', 'feedback.status_id', '=', 'status.id')
            ->select('author.name as author',
                'feedback.date as date',
                'website.name as website',
                'feedback.feed as feedback',
                'rate.rate as rate')
            ->where('status.status', 'like', 'published')
            ->where('date', '>=', $date)
            ->get();
    }
}
