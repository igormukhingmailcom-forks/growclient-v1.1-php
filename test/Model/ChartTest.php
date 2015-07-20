<?php

namespace Grow\Client\Test\Model;

use DateTime;

use Grow\Client\Model\Chart;
use Grow\Client\Model\Baby;
use Grow\Client\Model\Centile;
use Grow\Client\Model\Measurement;

use Grow\Client\Model\Config\PdfConfig;
use Grow\Client\Model\Config\ImageConfig;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class ChartTest extends BaseModelTest
{
    use JsonSerializableModelTestTrait;
    use JsonInstantiableModelTestTrait;
    use JsonUpdatableModelTestTrait;

    /**
     * {@inheritdoc}
     */
    public function jsonSerializationDataProvider()
    {
        $babies = array(
            Baby::createNew()
                ->setBirthOrderNumber(0)
                ->setBirthWeight(3550)
                ->setGender(1)
                ->setGestation(275)
                ->setName('Baby1')
                ->setUnknown(false)
            ,
            Baby::createNew()
                ->setBirthOrderNumber(2)
                ->setBirthWeight(3350)
                ->setGender(1)
                ->setGestation(280)
                ->setName('Baby3')
                ->setUnknown(false)
            ,
            Baby::createNew()
                ->setBirthOrderNumber(1)
                ->setBirthWeight(3450)
                ->setGender(1)
                ->setGestation(290)
                ->setName('Baby2')
                ->setUnknown(false)
            ,
            Baby::createNew()
                ->setBirthOrderNumber(3)
                ->setUnknown(true)
        );

        $imageConfig = ImageConfig::createNew()
            ->setGreyscale(false)
            ->setGridlinesByWeight(false)
            ->setScalePercent(200)
            ->setShowExtraCentiles(false)
        ;

        $pdfConfig = PdfConfig::createNew()
            ->setGreyscale(false)
            ->setGridlinesByWeight(false)
            ->setShowExtraCentiles(false)
        ;

        return array(
            array(
                'Grow\Client\Model\Chart',
                array(
                    'babies'=>$babies,
                    "dob" => new DateTime("1990-01-01 01:01:01"),
                    "edd" => new DateTime("2015-01-07 01:01:01"),
                    "ethnicity" => "Unclassified",
                    "firstname" => "SampleFN",
                    "lastname" => "SampleLN",
                    "motherRef" => "SampleMR",
                    "getPdf" => true,
                    "getImage" => true,
                    "height" => 163,
                    "imageConfig" => $imageConfig,
                    "pdfConfig" => $pdfConfig,
                    "weight" => 45
                ),
                '{
                    "babies":[{
                        "birthordernumber":0,
                        "birthweight":3550,
                        "gender":1,
                        "gestation":275,
                        "name":"Baby1",
                        "unknown":0
                    },{
                        "birthordernumber":2,
                        "birthweight":3350,
                        "gender":1,
                        "gestation":280,
                        "name":"Baby3",
                        "unknown":0
                    },{
                        "birthordernumber":1,
                        "birthweight":3450,
                        "gender":1,
                        "gestation":290,
                        "name":"Baby2",
                        "unknown":0
                    },{
                        "birthordernumber":3,
                        "unknown":1
                    }],
                    "dob":"1990-01-01",
                    "edd":"2015-01-07",
                    "ethnicity":"Unclassified",
                    "firstname":"SampleFN",
                    "lastname":"SampleLN",
                    "motherref":"SampleMR",
                    "getpdf": 1,
                    "getimage": 1,
                    "height":163,
                    "imageconfig":{
                        "greyscale":0,
                        "gridlinesbyweight":0,
                        "scalepercent":200,
                        "showextracentiles":0
                    },
                    "pdfconfig":{
                        "greyscale":0,
                        "gridlinesbyweight":0,
                        "showextracentiles":0
                    },
                    "weight":45
                }'
            ),
            array(
                'Grow\Client\Model\Chart',
                array(
                    "dob" => new DateTime("1990-01-01 01:01:01"),
                    "edd" => new DateTime("2015-01-07 01:01:01"),
                    "ethnicity" => "Unclassified",
                    "firstname" => "SampleFN",
                    "lastname" => "SampleLN",
                    "motherRef" => "",
                    "getPdf" => false,
                    "getImage" => false,
                    "height" => 163,
                    "weight" => 45
                ),
                '{
                    "dob":"1990-01-01",
                    "edd":"2015-01-07",
                    "ethnicity":"Unclassified",
                    "firstname":"SampleFN",
                    "lastname":"SampleLN",
                    "motherref":"",
                    "getpdf": 0,
                    "getimage": 0,
                    "height":163,
                    "weight":45
                }'
            )
        );
    }

    public function jsonInstantiationDataProvider()
    {
        return array(
            array(
                'Grow\Client\Model\Chart',
                array(
                    "ChartImage" => base64_encode('image'),
                    "BMI" => 16.9,
                    "TOW" => 3423,
                    "Ethnicity" => "Unclassified",
                    "Height" => 163,
                    "Weight" => 45,
                    "Parity" => 4,
                    "DateCreated" => '2015-01-26 10:12:16',
                    "EDD" => '2015-01-07',

                    "Centiles" => array(
                        array(
                            "CentileIdentifier" => 31095,
                            "BirthWeight" => 3450,
                            "Gender" => 1,
                            "DetectedSGA" => false,
                            "ReferralForSuspectedSGA" => false,
                            "Outcome" => 0,
                            "AntenatalCareUnit" => 2,
                            "Gestation" => 283,
                            "Centile" => 38.90,
                            "GestationFormatted" => "40 weeks 3 days",
                            "DateCreated" => "2015-01-26 10:44:46"
                        )
                    ),

                    "Measurements" => array(
                        array(
                            "MeasurementIdentifier" => 1018,
                            "Type" => 0,
                            "Value" => 32,
                            "DateCreated" => "2015-01-26 10:25:17",
                            "Date" => "2014-09-20"
                        )
                    )
                ),

                Chart::createNew()
                    ->setChartImage(base64_encode('image'))
                    ->setBmi(16.9)
                    ->setTow(3423)
                    ->setEthnicity("Unclassified")
                    ->setHeight(163)
                    ->setWeight(45)
                    ->setParity(4)
                    ->setDateCreated(new DateTime('2015-01-26 10:12:16'))
                    ->setEdd(new DateTime('2015-01-07'))

                    ->setCentiles(array(
                        Centile::createNew()
                            ->setCentileIdentifier(31095)
                            ->setBirthWeight(3450)
                            ->setGender(1)
                            ->setDetectedSga(false)
                            ->setReferralForSuspectedSga(false)
                            ->setOutcome(0)
                            ->setAntenatalCareUnit(2)
                            ->setGestation(283)
                            ->setCentile(38.90)
                            ->setGestationFormatted("40 weeks 3 days")
                            ->setDateCreated(new DateTime("2015-01-26 10:44:46"))
                    ))

                    ->setMeasurements(array(
                        Measurement::createNew()
                            ->setMeasurementIdentifier(1018)
                            ->setType(0)
                            ->setValue(32)
                            ->setDateCreated(new DateTime("2015-01-26 10:25:17"))
                            ->setDate(new DateTime("2014-09-20"))
                    ))
            )
        );
    }

    public function jsonUpdateDataProvider()
    {
        return array(
            array(
                'Grow\Client\Model\Chart',
                array(
                    "ChartIdentifier" => 1018,
                    "ChartImage" => base64_encode('image'),
                    "ChartPDF" => base64_encode('pdf'),
                    "BMI" => 16.9,
                    "TOW" => 3423,
                    'Babies' => array(
                        array(
                            'BirthOrderNumber'=>0,
                            'Centile'=>22.33
                        ),
                        array(
                            'BirthOrderNumber'=>1,
                            'Centile'=>22.34
                        )
                    )
                ),
                Chart::createNew()
                    ->setChartIdentifier(1018)
                    ->setChartImage(base64_encode('image'))
                    ->setChartPdf(base64_encode('pdf'))
                    ->setBmi(16.9)
                    ->setTow(3423)
                    ->setBabies(array(
                        Baby::createNew()
                            ->setBirthOrderNumber(0)
                            ->setCentile(22.33),
                        Baby::createNew()
                            ->setBirthOrderNumber(1)
                            ->setCentile(22.34)
                    ))
            )
        );
    }

    public function testSaveImage()
    {
        $expectedFileContent = 'image';
        $entity = Chart::createNew()
            ->setChartImage(base64_encode($expectedFileContent))
        ;
        $filename = sprintf("%s/jpg.%s", sys_get_temp_dir(), rand(1,9999999));
        $entity->saveImage($filename);
        $this->assertStringEqualsFile($filename, $expectedFileContent);
    }

    public function testSavePdf()
    {
        $expectedFileContent = 'pdf';
        $entity = Chart::createNew()
            ->setChartImage(base64_encode($expectedFileContent))
        ;
        $filename = sprintf("%s/pdf.%s", sys_get_temp_dir(), rand(1,9999999));
        $entity->saveImage($filename);
        $this->assertStringEqualsFile($filename, $expectedFileContent);
    }
}
