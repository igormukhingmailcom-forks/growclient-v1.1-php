<?php

namespace Grow\Client\Test;

use Grow\Client\ApiClient\ApiClientFactory;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
abstract class ApiClientAwareTest extends BaseTest
{
    protected $apiClient;

    public function setUp()
    {
        parent::setUp();

        $this->apiClient = ApiClientFactory::getInstance()->getClient($this->username, $this->password, 'json');
    }
}
