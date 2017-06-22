<?php

namespace App\Http\Controllers;

use App\Feedback;
use Illuminate\Http\Request;


class FeedbackTableController extends Controller
{
    public function updateTable(Request $request)
    {
        $date = $this->adjustTimeZone($request->input('date'));
        $feedbackModel = new Feedback();
        $feedbacks = $feedbackModel->getNewPublishedFeedbacksSinceDate($date);

        return response()->json($feedbacks);
    }



}
