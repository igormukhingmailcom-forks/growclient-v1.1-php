<?php

namespace Grow\Client\Model;

/**
 * Error
 *
 * Object representing a Error for InvalidInputException
 *
 * @method string getErrorItem()
 * @method Error setErrorItem(string $errorItem)
 *
 * @method string getErrorMessage()
 * @method Error setErrorMessage(string $errorMessage)
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class Error extends BaseModel implements ModelInterface, JsonInstantiableModelInterface
{
    /**
     * @var string
     */
    protected $errorItem;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * {@inheritdoc}
     */
    public static function createFromJson($json)
    {
        return self::createNew()
            ->setErrorItem($json['ErrorItem'])
            ->setErrorMessage($json['ErrorMessage'])
        ;
    }

}
