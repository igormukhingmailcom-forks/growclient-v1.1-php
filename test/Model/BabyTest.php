<?php

namespace Grow\Client\Test\Model;

use DateTime;

use Grow\Client\Model\Baby;
use Grow\Client\Test\Model\JsonSerializableModelTestTrait;
use Grow\Client\Test\Model\JsonInstantiableModelTestTrait;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class BabyTest extends BaseModelTest
{
    use JsonSerializableModelTestTrait;
    use JsonUpdatableModelTestTrait;

    public function jsonSerializationDataProvider()
    {
        return array(
            array(
                'Grow\Client\Model\Baby',
                array(
                    'birthOrderNumber'=>0,
                    'birthWeight'=>3550,
                    'gender'=>1,
                    'gestation'=>275,
                    'name'=>'Baby1',
                    'unknown'=>false
                ),
                '{
                    "birthordernumber":0,
                    "birthweight":3550,
                    "gender":1,
                    "gestation":275,
                    "name":"Baby1",
                    "unknown":0
                }'
            )
            ,
            array(
                'Grow\Client\Model\Baby',
                array(
                    'birthOrderNumber'=>3,
                    'unknown'=>true
                ),
                '{
                    "birthordernumber":3,
                    "unknown":1
                }'
            )
        );
    }

    public function jsonUpdateDataProvider()
    {
        return array(
            array(
                'Grow\Client\Model\Baby',
                array(
                    "Centile" => 22.33
                ),
                Baby::createNew()
                    ->setCentile(22.33)
            )
        );
    }
}
