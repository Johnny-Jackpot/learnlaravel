<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedBackFormController extends Controller
{
    public function handleSubmission(Request $request)
    {
        $websiteAddress = $this->getWebsiteHost($request);
        if (empty($websiteAddress)) {
            return response('Website specified incorrectly.', 501);
        }

        $author = $this->getOrSaveAuthor($request);
        $rate = $this->getRate($request);
        $website = $this->getOrSaveWebsite($websiteAddress);
        $feedback = $this->saveFeedback($request, $author, $rate, $website);

        return response()->json($feedback);
    }

    /**
     * Get website host from submitted form
     *
     * @param Request $request
     * @return string
     */
    protected function getWebsiteHost(Request $request)
    {
        $address = $request->input('website');
        $parseUrl = parse_url(trim($address));

        if (isset($parseUrl['host']) && !empty($parseUrl['host'])) {
            return $parseUrl['host'];
        }

        if (isset($parseUrl['path']) && !empty($parseUrl['path'])) {
            $hostArr = explode('/', $parseUrl['path'], 2);
            $host = array_shift($hostArr);

            return preg_match('~.+\..+~', $host) ? $host : '';
        }

        return '';
    }
}
