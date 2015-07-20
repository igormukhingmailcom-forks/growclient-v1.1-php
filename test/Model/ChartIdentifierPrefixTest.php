<?php

namespace Grow\Client\Test\Model;

use DateTime;

use Grow\Client\Model\ChartIdentifierPrefix;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class ChartIdentifierPrefixTest extends BaseModelTest
{
    use JsonInstantiableModelTestTrait;

    public function jsonInstantiationDataProvider()
    {
        return array(
            array(
                'Grow\Client\Model\ChartIdentifierPrefix',
                array(
                    "ChartIdentifierPrefix" => 'FL',
                    "DateCreated" => '2015-03-06 11:28:57'
                ),
                ChartIdentifierPrefix::createNew()
                    ->setChartIdentifierPrefix('FL')
                    ->setDateCreated(new DateTime('2015-03-06 11:28:57'))
            )
        );
    }

    public function testToStringReturnsOnlyPrefix()
    {
        $prefix = ChartIdentifierPrefix::createNew()
            ->setChartIdentifierPrefix('FL')
        ;

        $this->assertEquals('FL', (string) $prefix);
    }
}
