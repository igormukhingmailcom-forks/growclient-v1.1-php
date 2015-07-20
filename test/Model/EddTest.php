<?php

namespace Grow\Client\Test\Model;

use DateTime;
use Grow\Client\Model\Edd;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class EddTest extends BaseModelTest
{
    use JsonInstantiableModelTestTrait;

    public function jsonInstantiationDataProvider()
    {
        return array(
            array(
                'Grow\Client\Model\Edd',
                array(
                    "EDD" => '2015-03-06',
                    "DateCreated" => '2015-03-06 11:28:57'
                ),
                Edd::createNew()
                    ->setEdd(new DateTime('2015-03-06'))
                    ->setDateCreated(new DateTime('2015-03-06 11:28:57'))
            )
        );
    }

    public function testToStringReturnsOnlyYmd()
    {
        $edd = Edd::createNew()
            ->setEdd(new DateTime('2015-03-06 11:28:56'))
        ;

        $this->assertEquals('2015-03-06', (string) $edd);
    }
}
