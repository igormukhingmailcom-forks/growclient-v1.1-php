<?php

namespace Grow\Client\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class GuzzleHttpClient extends BaseHttpClient implements HttpClientInterface
{
    /**
     * @var Client Guzzle http client
     */
    protected $client;

    /**
     * @param string      $username
     * @param string      $password
     * @param Client|null $client
     */
    public function __construct($username, $password, Client $client = null) {
        parent::__construct($username, $password);

        if (is_null($client)) {
            $client = new Client;
        }

        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function httpRequest($uri, $payload = null, $method = 'GET')
    {
        $url  = rtrim($this->getGatewayUrl(), '/') . $uri;

        $stream = \GuzzleHttp\Psr7\stream_for($payload);

        $response = $this->client->$method($url, [
            // 'debug' => true,
            'exceptions' => false,
            'auth' => [$this->username, $this->password],
            'body' => $stream,
            'headers' => [
                'Content-Type' => 'application/json',
                'Content-Length' => strlen($payload)
            ]
        ]);

        return $response;
    }
}
