<?php

namespace Grow\Client\ApiClient;

use DateTime;

use Grow\Client\Model\Chart;
use Grow\Client\Model\Centile;
use Grow\Client\Model\Measurement;

use Grow\Client\Model\Config\ImageConfig;
use Grow\Client\Model\Config\PdfConfig;

use Grow\Client\Model\OptionSet;
use Grow\Client\Model\OptionSet\EthnicityOptionSet;
use Grow\Client\Model\OptionSet\MeasurementTypeOptionSet;
use Grow\Client\Model\OptionSet\GenderOptionSet;
use Grow\Client\Model\OptionSet\OutcomeOptionSet;
use Grow\Client\Model\OptionSet\HospitalOptionSet;

use Grow\Client\Model\Response\ChartIdentifierPrefixResponse;
use Grow\Client\Model\Response\EddResponse;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
interface ApiClientInterface
{
    /**
     * @param  Chart $chart
     * @return Chart
     */
    public function addChart(Chart $chart);

    /**
     * @param  Chart $chart
     * @return Chart
     */
    public function updateChart($chartIdentifier, Chart $chart);

    /**
     * @param  integer     $chartIdentifier
     * @param  DateTime    $edd             Must match the EDD value (if it has not been deleted) stored on the chart
     * @param  ImageConfig $imageConfig
     * @return Chart
     */
    public function getChart($chartIdentifier, DateTime $edd, ImageConfig $imageConfig);

    /**
     * @param  integer $chartIdentifier
     * @return boolean
     */
    public function removeChart($chartIdentifier);

    /**
     * @param  integer $chartIdentifier
     * @return EddResponse
     */
    public function getEdd($chartIdentifier);

    /**
     * @param  integer $chartIdentifier
     * @return ChartIdentifierPrefixResponse
     */
    public function getChartIdentifierPrefix($chartIdentifier);

    /**
     * @param  integer     $chartIdentifier
     * @param  Measurement $measurement
     * @return Measurement
     */
    public function addMeasurement($chartIdentifier, Measurement $measurement);

    /**
     * @param  integer     $chartIdentifier
     * @param  Measurement $measurement
     * @return Measurement
     */
    public function updateMeasurement($chartIdentifier, Measurement $measurement);

    /**
     * @param  integer $chartIdentifier
     * @param  integer $measurementIdentifier
     * @return Measurement
     */
    public function getMeasurement($chartIdentifier, $measurementIdentifier);

    /**
     * @param  integer $chartIdentifier
     * @return Measurement[]
     */
    public function getMeasurements($chartIdentifier);

    /**
     * @param  integer $chartIdentifier
     * @param  integer $measurementIdentifier
     * @return boolean
     */
    public function removeMeasurement($chartIdentifier, $measurementIdentifier);

    /**
     * @param  integer  $chartIdentifier
     * @param  Centile  $centile
     * @return Centile
     */
    public function addCentile($chartIdentifier, Centile $centile);

    /**
     * @param  integer  $chartIdentifier
     * @param  Centile  $centile
     * @return Centile
     */
    public function updateCentile($chartIdentifier, Centile $centile);

    /**
     * @param  integer $chartIdentifier
     * @param  integer $centileIdentifier
     * @return Centile
     */
    public function getCentile($chartIdentifier, $centileIdentifier);

    /**
     * @param  integer $chartIdentifier
     * @return Centile[]
     */
    public function getCentiles($chartIdentifier);

    /**
     * @param  integer   $chartIdentifier
     * @param  integer   $centileIdentifier
     * @param  DateTime  $edd
     * @return boolean
     */
    public function removeCentile($chartIdentifier, $centileIdentifier, DateTime $edd);

    /**
     * @return EthnicityOptionSet
     */
    public function getEthnicities();

    /**
     * @param  integer $chartIdentifier
     * @return EthnicityOptionSet
     */
    public function getEthnicitiesByChartIdentifier($chartIdentifier);

    /**
     * @param  string $coefficient
     * @return EthnicityOptionSet
     */
    public function getEthnicitiesByCoefficient($coefficient);

    /**
     * @return MeasurementTypeOptionSet
     */
    public function getMeasurementTypes();

    /**
     * @return GenderOptionSet
     */
    public function getGenders();

    /**
     * @return OutcomeOptionSet
     */
    public function getOutcomes();

    /**
     * @return HospitalOptionSet
     */
    public function getHospitals();

    /**
     * @param  integer $year
     */
    public function getSGAFGRReferralAndDetection($year);
}
