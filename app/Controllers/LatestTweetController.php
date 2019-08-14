<?php

namespace App\Controllers;

use App\Services\TwitterApi;

class LatestTweetController
{
    /** @var TwitterApi */
    private $twitterApi;

    public function __construct(TwitterApi $twitterApi)
    {
        $this->twitterApi = $twitterApi;
    }

    public function index()
    {
        $latest = $this->twitterApi->latestTweets('MGMonge');

        return json_encode($latest);
    }
}