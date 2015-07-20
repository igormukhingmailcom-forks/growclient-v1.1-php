<?php

namespace Grow\Client\HttpClient;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
interface HttpClientInterface
{
    /**
     * HTTP request
     *
     * @param  string $uri
     * @param  string $payload
     * @param  string $method
     * @return string
     */
    public function httpRequest($uri, $payload = null, $method = 'GET');
}
