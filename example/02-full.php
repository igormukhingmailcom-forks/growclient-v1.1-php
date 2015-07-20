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
$basePath = "/tmp/grow-example-02-full";
exec("rm -Rf $basePath");
mkdir($basePath);

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
    "Chart #%s added.\n- Height: %s\n- Weight: %s\n",
    $chartIdentifier,
    $chart->getHeight(),
    $chart->getWeight()
);

$imageFilename = sprintf(
    "%s/%s.jpg",
    $basePath,
    $chartIdentifier
);
$chartResponse->saveImage($imageFilename);

echo sprintf(
    "- Chart's image saved as '%s'.\n",
    $imageFilename
);

$pdfFilename = sprintf(
    "%s/%s.pdf",
    $basePath,
    $chartIdentifier
);
$chartResponse->savePdf($pdfFilename);

echo sprintf(
    "- Chart's pdf saved as '%s'.\n",
    $pdfFilename
);

// Measurement - Add
$measurement = Measurement::createNew()
    ->setDate(new DateTime("-1 week"))
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
    "%s/%s.1-%s.jpg",
    $basePath,
    $chartIdentifier,
    $measurementIdentifier
);
$measurement->saveImage($measurementImageFilename);

echo sprintf(
    "- Measurement's image saved as '%s'. You can see x-mark with value of 32 on it.\n",
    $measurementImageFilename
);

// Measurement - Add one more
$measurement2 = Measurement::createNew()
    ->setDate(new DateTime())
    ->setType($measurementTypes->current()->getIdentifier())
    ->setValue(30)
    ->setImageConfig($imageConfig)
;
$apiClient->addMeasurement($prefixedChartIdentifier, $measurement2);

$measurement2Identifier = $measurement2->getMeasurementIdentifier();
echo sprintf(
    "Measurement #%s added to chart #%s.\n",
    $measurement2Identifier,
    $chartIdentifier
);

$measurement2ImageFilename = sprintf(
    "%s/%s.2-%s.jpg",
    $basePath,
    $chartIdentifier,
    $measurement2Identifier
);
$measurement2->saveImage($measurement2ImageFilename);

echo sprintf(
    "- Measurement's image saved as '%s'. You can see 2 x-marks with values 30 and 32 on it.\n",
    $measurement2ImageFilename
);

// Measurement - get one by id
$measurement2reloaded = $apiClient->getMeasurement($prefixedChartIdentifier, $measurement2Identifier);

echo sprintf(
    "Retrieved information about measurement #%s:\n- Value: %s\n- Measurement Type: %s (%s)\n- Measurement date: %s\n- Date created: %s\n",
    $measurement2reloaded->getMeasurementIdentifier(),
    $measurement2reloaded->getValue(),
    $measurement2reloaded->getType(),
    $measurementTypes->findById($measurement2reloaded->getType())->getValue(),
    $measurement2reloaded->getDate()->format('Y-m-d'),
    $measurement2reloaded->getDateCreated()->format('Y-m-d H:i:s')
);

// Measurement - Change latest
$measurement2reloaded
    ->setValue(31)
    ->setImageConfig($imageConfig)
;
$measurement2updated = $apiClient->updateMeasurement($prefixedChartIdentifier, $measurement2reloaded);

echo sprintf(
    "Measurement #%s changed.\n",
    $measurement2Identifier
);

$measurement2ImageFilename = sprintf(
    "%s/%s.2-%s-changed.jpg",
    $basePath,
    $chartIdentifier,
    $measurement2Identifier
);
$measurement2updated->saveImage($measurement2ImageFilename);

echo sprintf(
    "- Measurement's image saved as '%s'. You can see x-marks with values 31 and 32 on it.\n",
    $measurement2ImageFilename
);

// Measurement - Remove latest
$apiClient->removeMeasurement($prefixedChartIdentifier, $measurement2Identifier);

echo sprintf(
    "Measurement #%s removed.\n",
    $measurement2Identifier
);

// Measurement - Get all
$measurements = $apiClient->getMeasurements($prefixedChartIdentifier);
echo sprintf(
    "All measurements fetched. Only %s measurement leave after deletion.\n",
    count($measurements)
);

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

$apiClient->addCentile($prefixedChartIdentifier, $centile);
$centileIdentifier = $centile->getCentileIdentifier();

echo sprintf(
    "Centile #%s added.\n- Gestation: %s (%s)\n- Birth weight: %s\n",
    $centileIdentifier,
    $centile->getGestation(),
    $centile->getGestationFormatted(),
    $centile->getBirthWeight()
);

// Centile - change
$centile
    ->setBirthWeight(3000)
;
$apiClient->updateCentile($prefixedChartIdentifier, $centile);

echo sprintf(
    "Centile #%s updated.\n- New birth weight: %s\n",
    $centileIdentifier,
    $centile->getBirthWeight()
);

// Centile - get one by ID
$centile = $apiClient->getCentile($prefixedChartIdentifier, $centileIdentifier);
echo sprintf(
    "Centile #%s retrieved.\n- Gestation: %s (%s)\n- Birth weight: %s\n",
    $centileIdentifier,
    $centile->getGestation(),
    $centile->getGestationFormatted(),
    $centile->getBirthWeight()
);

// Centile - delete
$apiClient->removeCentile($prefixedChartIdentifier, $centileIdentifier, $edd);

echo sprintf(
    "Centile #%s deleted.\n",
    $centileIdentifier
);

// Chart - change
$chart
    ->setHeight(170)
    ->setWeight(55)
;
$apiClient->updateChart($prefixedChartIdentifier, $chart);

echo sprintf(
    "Chart #%s updated.\n- New height: %s\n- New weight: %s\n",
    $chartIdentifier,
    $chart->getHeight(),
    $chart->getWeight()
);

// Centile - create again
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

$apiClient->addCentile($prefixedChartIdentifier, $centile);
$centileIdentifier = $centile->getCentileIdentifier();

echo sprintf(
    "Centile #%s added.\n- Gestation: %s (%s)\n- Birth weight: %s\n",
    $centileIdentifier,
    $centile->getGestation(),
    $centile->getGestationFormatted(),
    $centile->getBirthWeight()
);

// Centile - get all
$centiles = $apiClient->getCentiles($prefixedChartIdentifier);

echo sprintf(
    "Now we have %s centiles.\n",
    count($centiles)
);

// Edd - get
$storedEdd = $apiClient->getEdd($prefixedChartIdentifier);

echo sprintf(
    "Stored EDD is %s.\n",
    (string) $storedEdd
);

// Chart - get one
$chart = $apiClient->getChart($prefixedChartIdentifier, $storedEdd->getEdd(), $imageConfig);

echo sprintf(
    "Chart #%s retrieved.\n- Measurements: %s\n- Centiles: %s\n- Height: %s\n- Weight: %s\n",
    $chartIdentifier,
    count($chart->getMeasurements()),
    count($chart->getCentiles()),
    $chart->getHeight(),
    $chart->getWeight()
);

$imageFilename = sprintf(
    "%s/%s-final.jpg",
    $basePath,
    $chartIdentifier
);
$chartResponse->saveImage($imageFilename);

echo sprintf(
    "- Final chart's image saved as '%s'.\n",
    $imageFilename
);

// Chart - remove
$apiClient->removeChart($prefixedChartIdentifier);

echo sprintf(
    "Chart #%s removed.\n",
    $chartIdentifier
);
