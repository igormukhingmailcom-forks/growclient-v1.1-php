<?php

namespace Grow\Client\Exception;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class InvalidResponseFormatException extends \RuntimeException
{
    protected $responseBody;

    /**
     * @param string $message
     * @param Error[] $responseBody
     */
    public function __construct($message, $responseBody) {
        parent::__construct($message);

        $this->responseBody = $responseBody;
    }

    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * @return string
     */
    public function __toString() {
        return sprintf(
            "%s: %s\nResponse body:\n%s",
            __CLASS__,
            $this->message,
            $this->responseBody
        );
    }
}

