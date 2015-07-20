<?php

namespace Grow\Client\Test\Model;

use DateTime;

use Grow\Client\Model\Measurement;
use Grow\Client\Model\Config\ImageConfig;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class MeasurementTest extends BaseModelTest
{
    use JsonSerializableModelTestTrait;
    use JsonInstantiableModelTestTrait;
    use JsonUpdatableModelTestTrait;

    /**
     * {@inheritdoc}
     */
    public function jsonSerializationDataProvider()
    {
        $imageConfig = ImageConfig::createNew()
            ->setGreyscale(false)
            ->setGridlinesByWeight(false)
            ->setScalePercent(200)
            ->setShowExtraCentiles(false)
        ;

        return array(
            array(
                'Grow\Client\Model\Measurement',
                array(
                    'date'=>new DateTime('2014-09-20 01:01:01'),
                    'imageConfig'=>$imageConfig,
                    'type'=>0,
                    'value'=>32
                ),
                '{
                    "date":"2014-09-20",
                    "imageconfig":{
                        "greyscale":0,
                        "gridlinesbyweight":0,
                        "scalepercent":200,
                        "showextracentiles":0
                    },
                    "type":0,
                    "value":32
                }'
            )
        );
    }

    public function jsonInstantiationDataProvider()
    {
        return array(
            // With identifier
            array(
                'Grow\Client\Model\Measurement',
                array(
                    "MeasurementIdentifier" => 1018,

                    "Type" => 0,
                    "Value" => 42,
                    "Date" => '2014-10-20',
                    "DateCreated" => '2015-01-26 10:25:27',
                ),
                Measurement::createNew()
                    ->setMeasurementIdentifier(1018)
                    ->setType(0)
                    ->setValue(42)
                    ->setDate(new DateTime('2014-10-20'))
                    ->setDateCreated(new DateTime('2015-01-26 10:25:27'))
            ),

            // Without identifier
            array(
                'Grow\Client\Model\Measurement',
                array(
                    "Type" => 0,
                    "Value" => 42,
                    "Date" => '2014-10-20',
                    "DateCreated" => '2015-01-26 10:25:27'
                ),
                Measurement::createNew()
                    ->setType(0)
                    ->setValue(42)
                    ->setDate(new DateTime('2014-10-20'))
                    ->setDateCreated(new DateTime('2015-01-26 10:25:27'))
            )
        );
    }

    public function jsonUpdateDataProvider()
    {
        return array(
            array(
                'Grow\Client\Model\Measurement',
                array(
                    "MeasurementIdentifier" => 1018,
                    "ChartImage" => base64_encode('image')
                ),
                Measurement::createNew()
                    ->setMeasurementIdentifier(1018)
                    ->setChartImage(base64_encode('image'))
            )
        );
    }

    public function testSaveImage()
    {
        $expectedFileContent = 'image';
        $entity = Measurement::createNew()
            ->setChartImage(base64_encode($expectedFileContent))
        ;
        $filename = sprintf("%s/jpg.%s", sys_get_temp_dir(), rand(1,9999999));
        $entity->saveImage($filename);
        $this->assertStringEqualsFile($filename, $expectedFileContent);
    }
}
