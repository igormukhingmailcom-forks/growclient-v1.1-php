<?php

namespace Grow\Client\Test\Model;

use DateTime;
use Grow\Client\Test\Model\BaseModelTest;
use Grow\Client\Test\Model\JsonSerializableModelTestTrait;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class PdfConfigTest extends BaseModelTest
{
    use JsonSerializableModelTestTrait;

    public function jsonSerializationDataProvider()
    {
        return array(
            array(
                'Grow\Client\Model\Config\PdfConfig',
                array(
                    'greyscale'=>false,
                    'gridlinesByWeight'=>false,
                    'showExtraCentiles'=>true
                ),
                '{
                    "greyscale":0,
                    "gridlinesbyweight":0,
                    "showextracentiles":1
                }'
            )
        );
    }
}
