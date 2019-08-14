<?php

namespace App\Services;

use GuzzleHttp\Client;

class TwitterApi
{
    /**
     * @var Client
     */
    private $client;

    protected $accessToken = null;

    public function __construct(Client $client)
    {
        $this->client      = $client;
        $this->accessToken = $_SESSION['twitter_access_token'] ?? null;
    }

    public function latestTweets(string $username, int $limit = 10)
    {
        return $this->get('/statuses/user_timeline.json', ['screen_name' => $username, 'count' => $limit]);
    }

    public function basicToken()
    {
        $key    = urlencode(getenv('TWITTER_API_KEY'));
        $secret = urlencode(getenv('TWITTER_API_SECRET'));

        return base64_encode(sprintf('%s:%s', $key, $secret));
    }

    public function accessToken()
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        $this->accessToken = $this->requestAccessToken();

        $_SESSION['twitter_access_token'] = $this->accessToken;

        return $this->accessToken;
    }

    public function requestAccessToken()
    {
        $token = $this->basicToken();

        $response = $this->request('POST', 'https://api.twitter.com/oauth2/token', 'form_params', [
            'grant_type' => 'client_credentials',
        ], [
            'Authorization' => 'Basic ' . $token,
            'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8',
        ]);

        return $response['access_token'];
    }

    private function get(string $uri, array $params = [])
    {
        return $this->request('GET', 'https://api.twitter.com/1.1/' . trim($uri, '/'), 'query', $params, [
            'Authorization' => 'Bearer ' . $this->accessToken(),
        ]);
    }

    private function request($method, $url, $key, array $data = [], array $headers = [])
    {
        $response = $this->client->request($method, $url, [
            'headers' => $headers,
            $key      => $data,
        ]);

        return json_decode($response->getBody(), true);
    }
}