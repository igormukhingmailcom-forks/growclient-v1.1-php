<?php

namespace Grow\Client\Test\ApiClient;

use Grow\Client\Test\BaseTest;

use Grow\Client\HttpClient\HttpClientFactory;

/**
 * Test for HttpClientFactory.
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class HttpClientFactoryTest extends BaseTest
{
    public function httpClientOptionsProvider()
    {
        return array(
          array('guzzle', 'Grow\Client\HttpClient\GuzzleHttpClient')
        );
    }

    /**
     * @dataProvider httpClientOptionsProvider
     */
    public function testApiClientFactory($httpClientType, $httpClientClassName)
    {
        $httpClient = HttpClientFactory::getInstance()->getClient($this->username, $this->password, $httpClientType);

        $this->assertInstanceOf('Grow\Client\HttpClient\HttpClientInterface', $httpClient);
        $this->assertInstanceOf($httpClientClassName, $httpClient);
    }

}
