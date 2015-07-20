<?php

namespace Grow\Client\HttpClient;

use Grow\Client\Exception\RuntimeException;

/**
 * HttpClientFactory
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 * @author Cong Peijun <p.cong@linkorb.com>
 */
class HttpClientFactory
{
    /**
     * Factory instance
     * @var HttpClientFactory
     */
    private static $instance = null;

    /**
     * @var HttpClientInterface[]
     */
    private static $httpClients = [];

    private $httpClientTypes = [
        'guzzle'
    ];

    /**
     * Deny instantiation
     */
    private function __construct()
    {
    }

    /**
     * Get HttpClientFactory instance
     *
     * @return HttpClientFactory
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param  string $username
     * @param  string $password
     * @param  string $httpClientType
     *
     * @return HttpClientInterface
     *
     * @throws RuntimeException
     */
    public function getClient(
        $username,
        $password,
        $httpClientType = 'guzzle',
        $gatewayUrl = null
    ) {
        if (!in_array(strtolower($httpClientType), $this->httpClientTypes)) {
            throw new RuntimeException('The HTTP client type "' . $httpClientType . '" is not supported.');
        }

        $clientId = sprintf(
            "%s-%s",
            strtolower($httpClientType),
            crc32($gatewayUrl)
        );

        if (!isset(self::$httpClients[$clientId])) {
            $httpClientClass = 'Grow\\Client\\HttpClient\\' . ucfirst(strtolower($httpClientType)) . 'HttpClient';
            self::$httpClients[$clientId] = new $httpClientClass($username, $password, $gatewayUrl);
        }

        return self::$httpClients[$clientId];
    }
}
