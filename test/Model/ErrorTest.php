<?php

namespace Grow\Client\Test\Model;

use Grow\Client\Model\Error;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class ErrorTest extends BaseModelTest
{
    use JsonInstantiableModelTestTrait;

    /**
     * {@inheritdoc}
     */
    public function jsonInstantiationDataProvider()
    {
        return array(
            array(
                'Grow\Client\Model\Error',
                array(
                    "ErrorItem" => 'item',
                    "ErrorMessage" => 'message'
                ),
                Error::createNew()
                    ->setErrorItem('item')
                    ->setErrorMessage('message')
            )
        );
    }
}
