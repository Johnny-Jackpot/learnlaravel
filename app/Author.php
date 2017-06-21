<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Author extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'author';

    public $timestamps = false;

    public function feedbacks()
    {
        return $this->hasMany('App\Feedback', 'author_id');
    }

    public function fetchOrPersistAuthor(Request $request)
    {
        $author = \App\Author::query()
            ->where('name', 'like', $request->input('author'))
            ->where('email', 'like', $request->input('email'))
            ->get();

        if ($author->isNotEmpty()) {
            return $author;
        }


    }
}
