<?php

namespace Grow\Client\Test;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    protected $username;
    protected $password;

    public function setUp()
    {
        $this->username = getenv('GROW_API_USERNAME');
        $this->password = getenv('GROW_API_PASSWORD');
    }
}
