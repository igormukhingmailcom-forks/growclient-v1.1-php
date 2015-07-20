<?php

namespace Grow\Client\ApiClient;

use Grow\Client\Exception\RuntimeException;
use Grow\Client\HttpClient\HttpClientFactory;

/**
 * ApiClientFactory
 *
 * @author Cong Peijun <p.cong@linkorb.com>
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class ApiClientFactory
{
    /**
     * Factory instance
     * @var ApiClientFactory
     */
    private static $instance = null;

    /**
     * @var ApiClientInterface[]
     */
    private static $apiClients = [];

    private $apiClientTypes = [
        'json'
    ];

    /**
     * Deny instantiation
     */
    private function __construct()
    {
    }

    /**
     * Get ApiClientFactory instance
     *
     * @return ApiClientFactory
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
     * @param  string $apiClientType
     * @param  string $httpClientType
     *
     * @return ApiClientInterface
     *
     * @throws RuntimeException
     */
    public function getClient(
        $username,
        $password,
        $apiClientType = 'json',
        $httpClientType = 'guzzle',
        $gatewayUrl = null
    ) {
        if (!in_array(strtolower($apiClientType), $this->apiClientTypes)) {
            throw new RuntimeException('The API client type "' . $apiClientType . '" is not supported.');
        }

        $clientId = sprintf(
            "%s-%s-%s",
            strtolower($apiClientType),
            strtolower($httpClientType),
            crc32($gatewayUrl)
        );

        if (!isset(self::$apiClients[$clientId])) {
            $httpClient = HttpClientFactory::getInstance()->getClient($username, $password, $httpClientType, $gatewayUrl);

            $apiClientClass = 'Grow\\Client\\ApiClient\\' . ucfirst(strtolower($apiClientType)) . 'ApiClient';
            self::$apiClients[$clientId] = new $apiClientClass($httpClient);
        }

        return self::$apiClients[$clientId];
    }
}
