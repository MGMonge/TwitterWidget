<?php

namespace Tests\Unit\Controllers;

use App\Controllers\LatestTweetController;
use App\Services\TwitterApi;
use Mockery;
use Tests\TestCase;

class LatestTweetControllerTest extends TestCase
{
    /** @test */
    function it_returns_the_latest_tweets()
    {
        $mockedTwitterApi = Mockery::mock(TwitterApi::class);
        $SUT              = new LatestTweetController($mockedTwitterApi);

        $mockedTwitterApi->shouldReceive('latestTweets')
                         ->with('MGMonge')
                         ->once()
                         ->andReturn(['foo' => 'bar']);

        $actual = $SUT->index();

        $this->assertEquals(json_encode(['foo' => 'bar']), $actual);
    }
}