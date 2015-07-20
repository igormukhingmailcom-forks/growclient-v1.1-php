<?php

namespace Grow\Client\Test\ApiClient;

use Grow\Client\Test\ApiClientAwareTest;

use DateTime;

use Grow\Client\Model\Chart;
use Grow\Client\Model\Baby;
use Grow\Client\Model\Option\GenderOption;
use Grow\Client\Model\Option\EthnicityOption;
use Grow\Client\Model\Config\PdfConfig;
use Grow\Client\Model\Config\ImageConfig;

/**
 * Test for JsonApiClient.
 *
 * @todo Api calls tests
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class JsonApiClientTest extends ApiClientAwareTest
{
    public function optionsSetsProvider()
    {
        return array(
            array('getEthnicities'        , 'Grow\Client\Model\OptionSet\EthnicityOptionSet'         , 'Grow\Client\Model\Option\EthnicityOption'),
            array('getGenders'            , 'Grow\Client\Model\OptionSet\GenderOptionSet'            , 'Grow\Client\Model\Option\GenderOption'),
            array('getHospitals'          , 'Grow\Client\Model\OptionSet\HospitalOptionSet'          , 'Grow\Client\Model\Option\HospitalOption'),
            array('getMeasurementTypes'   , 'Grow\Client\Model\OptionSet\MeasurementTypeOptionSet'   , 'Grow\Client\Model\Option\MeasurementTypeOption'),
            array('getOutcomes'           , 'Grow\Client\Model\OptionSet\OutcomeOptionSet'           , 'Grow\Client\Model\Option\OutcomeOption'),
        );
    }

    /**
     * @dataProvider optionsSetsProvider
     */
    public function testSimpleOptionsSet($method, $optionSetClass, $optionClass)
    {
        $optionSet = $this->apiClient->$method();
        $this->assertInstanceOf($optionSetClass, $optionSet);
        $this->assertInstanceOf('Grow\Client\Model\OptionSet\OptionSetInterface', $optionSet);
        $this->assertTrue(count($optionSet) >= 1);
        $this->assertInstanceOf($optionClass, $optionSet->current());
    }
}
