<?php

namespace Grow\Client\Exception;

use Grow\Client\Model\Error;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class InvalidInputException extends \UnexpectedValueException
{
    protected $errors;

    /**
     * @param string $message
     * @param Error[] $errors
     */
    public function __construct($message, $errors) {
        parent::__construct($message);

        $this->errors = $errors;
    }

    /**
     * @return string
     */
    public function __toString() {
        return sprintf(
            "%s: %s\nErrors list:\n%s",
            __CLASS__,
            $this->message,
            join("\n", array_map(function(Error $error){
                return sprintf(
                    "- %s: %s",
                    $error->getErrorItem(),
                    $error->getErrorMessage()
                );
            }, $this->errors))
        );
    }
}
