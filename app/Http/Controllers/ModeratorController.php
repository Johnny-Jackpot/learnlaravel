<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Mail\FeedbackRejected;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


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
        $author = $feedback->author()->getResults();
        $emailAddress = $author->email;


        if (!isset($emailAddress) || empty($emailAddress)) {
            return response()->json(['mailWasSended' => false]);
        }

        $authorName = $author->name;
        $reason = $request->input('reason');
        $mail = new FeedbackRejected($feedback, $authorName, $reason);

        Mail::to($emailAddress)->queue($mail);

        return response()->json();
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
        $date = $this->adjustTimeZone($request->input('date'));

        $feedbacks = Feedback::query()
            ->whereHas('status', function($query){
                $query->where('status','like', 'new');
            })
            ->with('author', 'website', 'rate')
            ->latest('date')
            ->where('date', '>=', $date)
            ->get();

        if ($feedbacks->isEmpty()) {
            return '';
        }

        return view('recentFeedback')->with('feeds', $feedbacks);
    }
}
