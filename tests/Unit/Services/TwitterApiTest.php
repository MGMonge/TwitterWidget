<?php

namespace Tests\Unit\Services;

use App\Services\TwitterApi;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Tests\TestCase;

class TwitterApiTest extends TestCase
{
    /**
     * @var Container
     */
    protected $SUT;
    /**
     * @var Client|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    protected $mockedClient;

    /**
     *  This is the example from the twitter api documentation
     */
    const EXPECTED_BASIC_TOKEN = 'eHZ6MWV2RlM0d0VFUFRHRUZQSEJvZzpMOHFxOVBaeVJnNmllS0dFS2hab2xHQzB2SldMdzhpRUo4OERSZHlPZw==';

    function _before()
    {
        global $_SESSION;
        $_SESSION = [];

        $this->mockedClient = Mockery::mock(Client::class);
        $this->SUT          = new TwitterApi($this->mockedClient);

        // Load environment with the keys used on the twitter api documentation
        // @see https://developer.twitter.com/en/docs/basics/authentication/overview/application-only
        $env = Dotenv::create(__DIR__, 'documentation-twitter-keys.env');
        $env->load();
    }

    /** @test */
    function it_generates_the_correct_basic_token()
    {
        $this->assertEquals(static::EXPECTED_BASIC_TOKEN, $this->SUT->basicToken());
    }

    /** @test */
    function it_requests_the_correct_endpoint_to_get_the_access_token()
    {
        $this->mockedClient->shouldReceive('request')
                           ->with('POST', 'https://api.twitter.com/oauth2/token', [
                               'headers'     => [
                                   'Authorization' => 'Basic ' . static::EXPECTED_BASIC_TOKEN,
                                   'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8',
                               ],
                               'form_params' => ['grant_type' => 'client_credentials'],
                           ])
                           ->once()
                           ->andReturn(new Response(200, [], '{"token_type":"bearer","access_token":"ABC123"}'));

        $actual = $this->SUT->requestAccessToken();

        $this->assertEquals('ABC123', $actual);
    }

    /** @test */
    function it_stores_the_access_token_in_session()
    {
        $this->assertArrayNotHasKey('twitter_access_token', $_SESSION);
        $this->mockedClient->shouldReceive('request')->andReturn(new Response(200, [], '{"token_type":"bearer","access_token":"ABC123"}'));

        $this->SUT->accessToken();

        $this->assertEquals('ABC123', $_SESSION['twitter_access_token']);
    }

    /** @test */
    function fetching_user_latest_tweets()
    {
        $this->mockedClient->shouldReceive('request')
                           ->with('POST', 'https://api.twitter.com/oauth2/token', [
                               'headers'     => [
                                   'Authorization' => 'Basic ' . static::EXPECTED_BASIC_TOKEN,
                                   'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8',
                               ],
                               'form_params' => ['grant_type' => 'client_credentials'],
                           ])
                           ->once()
                           ->andReturn(new Response(200, [], '{"token_type":"bearer","access_token":"ABC123"}'));

        $this->mockedClient->shouldReceive('request')
                           ->with('GET', 'https://api.twitter.com/1.1/statuses/user_timeline.json', [
                               'headers' => [
                                   'Authorization' => 'Bearer ABC123',
                               ],
                               'query'   => ['screen_name' => 'MGMonge', 'count' => 999],
                           ])
                           ->once()
                           ->andReturn(new Response(200, [], '[]'));

        $actual = $this->SUT->latestTweets('MGMonge', 999);

        $this->assertEquals([], $actual);
    }

    /** @test */
    function it_does_not_request_the_access_token_when_is_in_the_session()
    {
        $_SESSION = ['twitter_access_token' => 'ABC123'];

        $this->SUT = new TwitterApi($this->mockedClient);

        $this->mockedClient->shouldReceive('request')
                           ->with('POST', 'https://api.twitter.com/oauth2/token', [
                               'headers'     => [
                                   'Authorization' => 'Basic ' . static::EXPECTED_BASIC_TOKEN,
                                   'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8',
                               ],
                               'form_params' => ['grant_type' => 'client_credentials'],
                           ])
                           ->never();

        $this->mockedClient->shouldReceive('request')
                           ->with('GET', 'https://api.twitter.com/1.1/statuses/user_timeline.json', [
                               'headers' => [
                                   'Authorization' => 'Bearer ABC123',
                               ],
                               'query'   => ['screen_name' => 'MGMonge', 'count' => 999],
                           ])
                           ->once()
                           ->andReturn(new Response(200, [], '[]'));

        $actual = $this->SUT->latestTweets('MGMonge', 999);

        $this->assertEquals([], $actual);
    }
}