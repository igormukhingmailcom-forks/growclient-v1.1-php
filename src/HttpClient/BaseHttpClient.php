<?php

namespace Grow\Client\HttpClient;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 * @author Cong Peijun <p.cong@linkorb.com>
 */
abstract class BaseHttpClient implements HttpClientInterface
{
    const DEVELOPMENT_GATEWAY_URL = "https://developer.growservice.org/v1.1/NL";
    const PRODUCTION_GATEWAY_URL  = "https://api.growservice.org/v1.1/NL";

    protected $username;
    protected $password;
    protected $gatewayUrl;

    public function __construct($username, $password, $gatewayUrl = null) {

        if (!$gatewayUrl) {
            $gatewayUrl = self::DEVELOPMENT_GATEWAY_URL;
        }

        $this->username = $username;
        $this->password = $password;
        $this->gatewayUrl = $gatewayUrl;
    }

    public function getGatewayUrl() {
        return $this->gatewayUrl;
    }
}
