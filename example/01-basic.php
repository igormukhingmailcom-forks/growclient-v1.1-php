<?php

include_once 'vendor/autoload.php';
include_once 'credentials.php';

use Grow\Client\ApiClient\ApiClientFactory;
use Grow\Client\Model\Baby;
use Grow\Client\Model\Chart;
use Grow\Client\Model\Centile;
use Grow\Client\Model\Measurement;
use Grow\Client\Model\Config\ImageConfig;
use Grow\Client\Model\Config\PdfConfig;
use Grow\Client\Model\Option\GenderOption;
use Grow\Client\Model\Option\EthnicityOption;

$apiClient = ApiClientFactory::getInstance()->getClient(GROW_API_USERNAME, GROW_API_PASSWORD);

$edd = new DateTime("-1 day");

$ethnicities = $apiClient->getEthnicities();
$genders = $apiClient->getGenders();
$outcomes = $apiClient->getOutcomes();
$measurementTypes = $apiClient->getMeasurementTypes();
$hospitals = $apiClient->getHospitals();

$babies = array(
    Baby::createNew()
        ->setBirthOrderNumber(0)
        ->setBirthWeight(3550)
        ->setGender($genders->current()->getIdentifier())
        ->setGestation(275)
        ->setName('Baby1')
        ->setUnknown(false)
    ,
    Baby::createNew()
        ->setBirthOrderNumber(1)
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

$chart = Chart::createNew()
    ->setBabies($babies)
    ->setDob(new DateTime("1990-01-01 01:01:01"))
    ->setEdd($edd)
    ->setEthnicity($ethnicities->current()->getIdentifier())
    ->setFirstname("SampleFN")
    ->setLastname("SampleLN")
    ->setMotherRef("SampleMR")
    ->setGetPdf(true)
    ->setGetImage(true)
    ->setHeight(163)
    ->setImageConfig($imageConfig)
    ->setPdfConfig($pdfConfig)
    ->setWeight(45)
;

$chartResponse = $apiClient->addChart($chart);
$chartIdentifier = $chart->getChartIdentifier();
$chartIdentifierPrefix = $apiClient->getChartIdentifierPrefix($chartIdentifier);

$prefixedChartIdentifier = sprintf(
    "%s%s",
    (string) $chartIdentifierPrefix,
    $chartIdentifier
);

echo sprintf(
    "Chart #%s added.\n",
    $chartIdentifier
);

$imageFilename = sprintf(
    "/tmp/%s.jpg",
    $chartIdentifier
);
$chartResponse->saveImage($imageFilename);

echo sprintf(
    "Chart's image saved as '%s'.\n",
    $imageFilename
);

$pdfFilename = sprintf(
    "/tmp/%s.pdf",
    $chartIdentifier
);
$chartResponse->savePdf($pdfFilename);

echo sprintf(
    "Chart's pdf saved as '%s'.\n",
    $pdfFilename
);

// getChart($chartIdentifier, DateTime $edd, ImageConfig $imageConfig);

// Measurement - Add
$measurement = Measurement::createNew()
    ->setDate(new DateTime())
    ->setType($measurementTypes->current()->getIdentifier())
    ->setValue(32)
    ->setImageConfig($imageConfig)
;
$measurement = $apiClient->addMeasurement($prefixedChartIdentifier, $measurement);

$measurementIdentifier = $measurement->getMeasurementIdentifier();
echo sprintf(
    "Measurement #%s added to chart #%s.\n",
    $measurementIdentifier,
    $chartIdentifier
);

$measurementImageFilename = sprintf(
    "/tmp/%s.%s.jpg",
    $chartIdentifier,
    $measurementIdentifier
);
$measurement->saveImage($measurementImageFilename);

echo sprintf(
    "Measurement's image saved as '%s'. You can see x-mark with value of 32 on it.\n",
    $measurementImageFilename
);

// Centile - Add
$centile = Centile::createNew()
    ->setAntenatalCareUnit($hospitals->current()->getIdentifier())
    ->setBabyDob($edd)
    ->setBirthWeight(3450)
    ->setDetectedSga(false)
    ->setEdd($edd)
    ->setGender($genders->current()->getIdentifier())
    ->setOutcome($outcomes->current()->getIdentifier())
    ->setReferralForSuspectedSga(false)
;

$centile = $apiClient->addCentile($prefixedChartIdentifier, $centile);
$centileIdentifier = $centile->getCentileIdentifier();

echo sprintf(
    "Centile #%s added.\nGestation: %s\n",
    $centileIdentifier,
    $centile->getGestationFormatted()
);
