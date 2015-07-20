<?php

namespace Grow\Client\Test\Model;

use DateTime;

use Grow\Client\Test\Model\BaseModelTest;
use Grow\Client\Test\Model\JsonSerializableModelTestTrait;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class ImageConfigTest extends BaseModelTest
{
    use JsonSerializableModelTestTrait;

    public function jsonSerializationDataProvider()
    {
        return array(
            array(
                'Grow\Client\Model\Config\ImageConfig',
                array(
                    'greyscale'=>false,
                    'gridlinesByWeight'=>false,
                    'scalePercent'=>200,
                    'showExtraCentiles'=>false
                ),
                '{
                    "greyscale":0,
                    "gridlinesbyweight":0,
                    "scalepercent":200,
                    "showextracentiles":0
                }'
            )
        );
    }
}
