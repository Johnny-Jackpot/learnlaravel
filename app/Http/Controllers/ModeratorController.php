<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Status;
use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    public function publishComment(Request $request)
    {
        $id = $request->input('commentId');
        $feedback = $this->changeStatusOfFeedback(Status::STATUS_PUBLISHED, $id);

        return response()->json($feedback);
    }

    public function rejectComment(Request $request)
    {
        $id = $request->input('commentId');
        $feedback = $this->changeStatusOfFeedback(Status::STATUS_REJECTED, $id);

        return response()->json($feedback);
    }

    /**
     * @param string $status
     * @param int $id
     * @return Feedback
     */
    protected function changeStatusOfFeedback($status, $id)
    {
        $statusObj = Status::query()
            ->where('status', 'like', $status)
            ->first();
        $feedback = Feedback::query()
            ->where('id', '=', $id)
            ->first();
        $feedback->status()->associate($statusObj);
        $feedback->save();

        return $feedback;
    }

    public function getRecentFeeds(Request $request)
    {
        return response()->json($request->all());

        $date = $request->input('date');


        return Feedback::query()
            ->whereHas('status', function($query){
                $query->where('status','like', 'new');
            })
            ->with('author', 'website', 'rate')
            ->latest('date')
            ->where('date', '>=', $date)
            ->get();
    }
}
