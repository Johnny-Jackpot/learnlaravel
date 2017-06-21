<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedBackFormController extends Controller
{
    public function handleSubmission(Request $request)
    {
        $author = $this->getOrSaveAuthor($request);
        $rate = $this->getRate($request);
        $website = $this->getOrSaveWebsite($request);
        $feedback = $this->saveFeedback($request, $author, $rate, $website);

        return response()->json($feedback);
    }
}
