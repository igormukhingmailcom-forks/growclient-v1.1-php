<?php

namespace Grow\Client\ApiClient;

use Grow\Client\HttpClient\HttpClientInterface;
use Grow\Client\Model\BaseModel;

/**
 * @author Cong Peijun <p.cong@linkorb.com>
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
abstract class BaseApiClient implements ApiClientInterface
{
    protected $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     * @param string              $username
     * @param string              $password
     */
    public function __construct(
        HttpClientInterface $httpClient
    ) {
        $this->httpClient = $httpClient;
    }

    /**
     * @return HttpClientInterface
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Build query url
     *
     * @param  string $uri
     * @param  mixed  $data
     *
     * @return string $url
     */
    public function buildQuery($uri, $data = null)
    {
        $url  = $uri;
        if ($data) {
            $url .= '?' . http_build_query($data);
        }

        return $url;
    }

    /**
     * Start request
     *
     * @param  string $url
     * @param  string $payload
     * @param  string $method
     * @return mixed
     */
    public function doRequest($url, $payload = null, $method = 'GET')
    {
        $response = $this->httpClient->httpRequest($url, $payload, $method);
        return $this->verifyResponse($response);
    }
}
