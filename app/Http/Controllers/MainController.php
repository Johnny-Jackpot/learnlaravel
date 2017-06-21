<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function showFeedbacks(Request $request)
    {
        $feedbackModel = new Feedback();
        $feedbacks = $feedbackModel->getAllPublishedFeedbacks();

        $rates = Rate::all();

        return view('main')
            ->with('feedbacks', $feedbacks)
            ->with('rates', $rates);
    }
}
