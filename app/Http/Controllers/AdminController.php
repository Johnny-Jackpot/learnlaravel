<?php

namespace App\Http\Controllers;

use App\Feedback;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showAdminPanel()
    {
        $freshFeedbacks = $this->getNewFeeds();

        return view('admin')->with('feeds', $freshFeedbacks);
    }

    /**
     * Get new feedbacks
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function getNewFeeds()
    {
        return Feedback::query()
            ->whereHas('status', function($query){
                $query->where('status','like', 'new');
            })
            ->with('author', 'website', 'rate')
            ->latest('date')
            ->get();
    }
}
