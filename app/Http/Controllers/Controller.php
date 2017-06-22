<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Author;
use App\Feedback;
use App\Website;
use App\Rate;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * If Author exist in db fetch it, else - save it
     *
     * @param Request $request
     * @return Author
     */
    protected function getOrSaveAuthor (Request $request)
    {
        $name = $request->input('author');
        $email = $request->input('email');

        $author = $this->getAuthor($name, $email);

        if ($author->isNotEmpty()) {
            return $author->first();
        }

        return $this->saveAuthor($name, $email);
    }

    /**
     * Fetch Collection of Author
     *
     * @param string $name
     * @param string $email
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function getAuthor ($name, $email)
    {
        return Author::query()
            ->where('name', 'like', $name)
            ->where('email', 'like', $email)
            ->get();
    }

    /**
     * Persist author to db
     *
     * @param string $name
     * @param string $email
     * @return Author
     */
    protected function saveAuthor($name, $email)
    {
        $newAuthor = new Author();
        $newAuthor->name = $name;
        $newAuthor->email = $email;
        $newAuthor->save();

        return $newAuthor;
    }

    /**
     * Fetch Rate from db
     *
     * @param Request $request
     * @return Rate
     */
    protected function getRate (Request $request)
    {
        $rateId = $request->input('rate');

        return Rate::query()
            ->where('id', '=', $rateId)
            ->first();
    }

    /**
     * If Website exist in db fetch it, else - save it
     *
     * @param string $address
     * @return Website
     */
    protected function getOrSaveWebsite ($address)
    {
        $website = $this->getWebsite($address);

        if ($website->isNotEmpty()) {
            return $website->first();
        }

        return $this->saveWebsite($address);
    }

    /**
     * Fetch Collection of Website from db
     *
     * @param string $address
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function getWebsite ($address)
    {
        return Website::query()
            ->where('name', 'like', $address)
            ->get();
    }

    /**
     * Persist Website to DB
     *
     * @param string $address
     * @return Website
     */
    protected function saveWebsite ($address)
    {
        $website = new Website();
        $website->name = $address;
        $website->save();

        return $website;
    }

    /**
     * Persist Feedback to DB
     *
     * @param Request $request
     * @param Author $author
     * @param Rate $rate
     * @param Website $website
     * @return Feedback
     */
    protected function saveFeedback (
        Request $request,
        Author $author,
        Rate $rate,
        Website $website
    ) {
        $feedback = new Feedback();
        $feedback->author()->associate($author);
        $feedback->rate()->associate($rate);
        $feedback->feed = $request->input('feedback');
        $feedback->website()->associate($website);
        $feedback->save();

        return $feedback;
    }

    /**
     * @param string $datetime
     * @return string
     */
    protected function adjustTimeZone($datetime)
    {
        $adjusted = new \DateTime($datetime);
        $timezone = new \DateTimeZone('Europe/Kiev');
        $adjusted->setTimezone($timezone);

        return $adjusted->format('Y-m-d H:i:s');
    }
}
