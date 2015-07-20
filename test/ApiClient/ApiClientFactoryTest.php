<?php

namespace Grow\Client\Test\ApiClient;

use Grow\Client\Test\BaseTest;

use Grow\Client\ApiClient\ApiClientFactory;

/**
 * Test for ApiClientFactory.
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class ApiClientFactoryTest extends BaseTest
{
    public function apiClientOptionsProvider()
    {
        return array(
          array('json', 'Grow\Client\ApiClient\JsonApiClient')
        );
    }

    /**
     * @dataProvider apiClientOptionsProvider
     */
    public function testApiClientFactory($apiClientType, $apiClientClassName)
    {
        $apiClient = ApiClientFactory::getInstance()->getClient($this->username, $this->password, $apiClientType);

        $this->assertInstanceOf('\Grow\Client\ApiClient\ApiClientInterface', $apiClient);
        $this->assertInstanceOf($apiClientClassName, $apiClient);
    }

}
