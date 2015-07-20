<?php

namespace Grow\Client\ApiClient;

use DateTime;

use GuzzleHttp\Psr7\Response;

use Grow\Client\Model\Error;

use Grow\Client\Model\Chart;
use Grow\Client\Model\Centile;
use Grow\Client\Model\Measurement;
use Grow\Client\Model\Edd;
use Grow\Client\Model\ChartIdentifierPrefix;
use Grow\Client\Model\SGAFGRReferralAndDetection;

use Grow\Client\Model\Config\ImageConfig;
use Grow\Client\Model\Config\PdfConfig;

use Grow\Client\Model\OptionSet\EthnicityOptionSet;
use Grow\Client\Model\OptionSet\GenderOptionSet;
use Grow\Client\Model\OptionSet\HospitalOptionSet;
use Grow\Client\Model\OptionSet\MeasurementTypeOptionSet;
use Grow\Client\Model\OptionSet\OutcomeOptionSet;

use Grow\Client\Exception\InvalidResponseFormatException;
use Grow\Client\Exception\BadMethodCallException;
use Grow\Client\Exception\InvalidInputException;
use Grow\Client\Exception\AuthErrorException;
use Grow\Client\Exception\UnknownErrorException;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 * @author Cong Peijun <p.cong@linkorb.com>
 */
class JsonApiClient extends BaseApiClient
{
    /**
     * {@inheritdoc}
     */
    public function addChart(Chart $chart)
    {
        if ($chart->getChartIdentifier()) {
            throw new BadMethodCallException(sprintf(
                "This chart already added with ID %s. Use updateChart to update.",
                $chart->getChartIdentifier()
            ));
        }

        $url = '/api/Storage/Chart';

        $data = $this->doRequest($url, $chart->toJson(), 'POST');
        return $chart->updateFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function updateChart($chartIdentifier, Chart $chart)
    {
        if (!$chart->getChartIdentifier()) {
            throw new BadMethodCallException(sprintf(
                "This chart has not been saved before. Use addChart to add.",
                $chart->getChartIdentifier()
            ));
        }

        $url = $this->buildQuery(
            sprintf('/api/Storage/Chart/%s/', $chartIdentifier)
        );
        $data = $this->doRequest($url, $chart->toJson(), 'PUT');
        return $chart->updateFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getChart($chartIdentifier, DateTime $edd, ImageConfig $imageConfig)
    {
        $url = $this->buildQuery(
            sprintf('/api/Storage/Chart/%s/', $chartIdentifier),
            array(
                'EDD'=>$edd->format('Y-m-d'),
                'ImageConfig'=>array(
                    'Greyscale'=>$imageConfig->getGreyscale() ? 'true' : 'false',
                    'ShowExtraCentiles'=>$imageConfig->getShowExtraCentiles() ? 'true' : 'false',
                    'GridlinesByWeight'=>$imageConfig->getGridlinesByWeight() ? 'true' : 'false',
                    'ScalePercent'=>(int)$imageConfig->getScalePercent()
                )
            )
        );

        $data = $this->doRequest($url);
        return Chart::createFromJson($data)
            // ->setImageConfig($imageConfig)
            ->setChartIdentifier($chartIdentifier)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function removeChart($chartIdentifier)
    {
        $url = sprintf(
            '/api/Storage/Chart/%s',
            $chartIdentifier
        );

        return $this->doRequest($url, null, 'DELETE');
    }

    /**
     * {@inheritdoc}
     */
    public function getEdd($chartIdentifier)
    {
        $url = sprintf(
            '/api/Storage/Chart/%s/EDD',
            $chartIdentifier
        );

        $data = $this->doRequest($url);
        return Edd::createFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getChartIdentifierPrefix($chartIdentifier)
    {
        $url = sprintf(
            '/api/Storage/Chart/%s/IdentifierPrefix',
            $chartIdentifier
        );

        $data = $this->doRequest($url);
        return ChartIdentifierPrefix::createFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function addMeasurement($chartIdentifier, Measurement $measurement)
    {
        if ($measurement->getMeasurementIdentifier()) {
            throw new BadMethodCallException(sprintf(
                "This measurement already added with ID %s. Use updateMeasurement to update.",
                $measurement->getMeasurementIdentifier()
            ));
        }

        $url = sprintf(
            '/api/Storage/Chart/%s/Measurement',
            $chartIdentifier
        );

        $data = $this->doRequest($url, $measurement->toJson(), 'POST');
        return $measurement->updateFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function updateMeasurement($chartIdentifier, Measurement $measurement)
    {
        if (!$measurement->getMeasurementIdentifier()) {
            throw new BadMethodCallException(sprintf(
                "This measurement has not been saved before. Use addMeasurement to add.",
                $measurement->getMeasurementIdentifier()
            ));
        }

        $url = sprintf(
            '/api/Storage/Chart/%s/Measurement/%s',
            $chartIdentifier,
            $measurement->getMeasurementIdentifier()
        );

        $data = $this->doRequest($url, $measurement->toJson(), 'PUT');
        return $measurement->updateFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getMeasurement($chartIdentifier, $measurementIdentifier)
    {
        $url = sprintf(
            '/api/Storage/Chart/%s/Measurement/%s',
            $chartIdentifier,
            $measurementIdentifier
        );

        $data = $this->doRequest($url);

        return Measurement::createFromJson($data)
            // We need to add this manually because MeasurementIdentifier
            // don't returned in response
            ->setMeasurementIdentifier($measurementIdentifier)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getMeasurements($chartIdentifier)
    {
        $url = sprintf(
            '/api/Storage/Chart/%s/Measurements',
            $chartIdentifier
        );

        $data = $this->doRequest($url);
        return Measurement::createArrayFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function removeMeasurement($chartIdentifier, $measurementIdentifier)
    {
        $url = sprintf(
            '/api/Storage/Chart/%s/Measurement/%s',
            $chartIdentifier,
            $measurementIdentifier
        );

        return $this->doRequest($url, null, 'DELETE');
    }

    /**
     * {@inheritdoc}
     */
    public function addCentile($chartIdentifier, Centile $centile)
    {
        if ($centile->getCentileIdentifier()) {
            throw new BadMethodCallException(sprintf(
                "This centile already added with ID %s. Use updateCentile to update.",
                $centile->getCentileIdentifier()
            ));
        }

        $url = sprintf(
            '/api/Storage/Chart/%s/Centile',
            $chartIdentifier
        );

        $data = $this->doRequest($url, $centile->toJson(), 'POST');
        return $centile->updateFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function updateCentile($chartIdentifier, Centile $centile)
    {
        if (!$centile->getCentileIdentifier()) {
            throw new BadMethodCallException(sprintf(
                "This measurement has not been saved before. Use addMeasurement to add.",
                $centile->getCentileIdentifier()
            ));
        }

        $url = sprintf(
            '/api/Storage/Chart/%s/Centile/%s',
            $chartIdentifier,
            $centile->getCentileIdentifier()
        );

        $data = $this->doRequest($url, $centile->toJson(), 'PUT');
        return $centile->updateFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getCentile($chartIdentifier, $centileIdentifier)
    {
        $url = sprintf(
            '/api/Storage/Chart/%s/Centile/%s',
            $chartIdentifier,
            $centileIdentifier
        );

        $data = $this->doRequest($url);

        return Centile::createFromJson($data)
            // We need to add this manually because CentileIdentifier
            // don't returned in response
            ->setCentileIdentifier($centileIdentifier)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getCentiles($chartIdentifier)
    {
        $url = sprintf(
            '/api/Storage/Chart/%s/Centiles',
            $chartIdentifier
        );

        $data = $this->doRequest($url);
        return Centile::createArrayFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    function removeCentile($chartIdentifier, $centileIdentifier, DateTime $edd)
    {
        $url = $this->buildQuery(
            sprintf(
                '/api/Storage/Chart/%s/Centile/%s',
                $chartIdentifier,
                $centileIdentifier
            ), array(
                'EDD'=>$edd->format('Y-m-d')
            )
        );

        return $this->doRequest($url, null, 'DELETE');
    }

    /**
     * {@inheritdoc}
     */
    public function getEthnicities()
    {
        $data = $this->doRequest('/api/OptionSet/Ethnicities');
        return EthnicityOptionSet::createFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getEthnicitiesByChartIdentifier($chartIdentifier)
    {
        $url = sprintf(
            '/api/OptionSet/Ethnicities/%s',
            $chartIdentifier
        );
        $data = $this->doRequest($url);
        return EthnicityOptionSet::createFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getEthnicitiesByCoefficient($coefficient)
    {
        $url = sprintf(
            '/api/OptionSet/Ethnicities/%s',
            $coefficient
        );
        $data = $this->doRequest($url);
        return EthnicityOptionSet::createFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getGenders()
    {
        $data = $this->doRequest('/api/OptionSet/Genders');
        return GenderOptionSet::createFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getHospitals()
    {
        $data = $this->doRequest('/api/OptionSet/Hospitals');
        return HospitalOptionSet::createFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getMeasurementTypes()
    {
        $data = $this->doRequest('/api/OptionSet/MeasurementTypes');
        return MeasurementTypeOptionSet::createFromJson($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getOutcomes()
    {
        $data = $this->doRequest('/api/OptionSet/Outcomes');
        return OutcomeOptionSet::createFromJson($data);
    }

    /**
     * As response in this function is not JSON,
     * but binary PDF - have some extraordinary
     * response processing.
     *
     * {@inheritdoc}
     */
    function getSGAFGRReferralAndDetection($year)
    {
        $url = $this->buildQuery(
            '/api/Storage/Reports/SGAFGRReferralAndDetection',
            array(
                'year'=>$year
            )
        );

        try {
            $data = $this->doRequest($url);
        } catch (InvalidResponseFormatException $e) {
            return SGAFGRReferralAndDetection::createNew()
                ->setPdfData($e->getResponseBody())
            ;
        }
    }

    /**
     * @param  Response $response
     * @return array|boolean
     */
    public function verifyResponse(Response $response)
    {
        $responseBody = (string) $response->getBody();

        if (empty($responseBody)) {
            return true;
        }

        $json = json_decode($responseBody, true);
        if (is_null($json)) {
            throw new InvalidResponseFormatException("Invalid json in Response Body", $responseBody);
        }

        switch($response->getStatusCode())
        {
            case 400:
                throw new InvalidInputException($json['ExceptionDescription'], Error::createArrayFromJson($json['Errors']));

            case 401:
                throw new AuthErrorException($json['ExceptionDescription']);

            case 500:
                throw new UnknownErrorException($json['ExceptionDescription']);
        }

        return $json;
    }

}
