<?php

namespace Grow\Client\Model;

use DateTime;

use Grow\Client\Model\BaseModel;
use Grow\Client\Model\Config\ImageConfig;

/**
 * Measurement
 *
 * Object representing a Measurement
 *
 * @method integer getMeasurementIdentifier()
 * @method Measurement setMeasurementIdentifier(integer $measurementIdentifier)
 *
 * @method integer getType()
 * @method Measurement setType(integer $type)
 *
 * @method integer getValue()
 * @method Measurement setValue(integer $value)
 *
 * @method DateTime getDate()
 * @method Measurement setDate(DateTime $date)
 *
 * @method ImageConfig getImageConfig()
 * @method Measurement setImageConfig(ImageConfig $imageConfig)
 *
 * @method string getChartImage()
 * @method Measurement setChartImage(string $chartImage)
 *
 * @method DateCreated getDateCreated()
 * @method Centile setDateCreated(DateCreated $dateCreated)
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class Measurement extends BaseSerializableModel implements JsonSerializableModelInterface, JsonInstantiableModelInterface, JsonUpdatableModelInterface
{
    /**
     * @var integer
     */
    protected $measurementIdentifier;

    /**
     * Must be an identifier of MeasurementType.
     *
     * @var integer
     */
    protected $type;

    /**
     * @var integer
     */
    protected $value;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var DateTime
     */
    protected $dateCreated;

    /**
     * @var ImageConfig
     */
    protected $imageConfig;

    /**
     * @var string
     */
    protected $chartImage;

    /**
     * @param  string $filename Filename to save to
     */
    public function saveImage($filename)
    {
        if (!$this->getChartImage()) {
            throw new \Exception("You need to call addMeasurement or updateMeasurement first");
        }

        $content = base64_decode($this->getChartImage());
        return file_put_contents($filename, $content);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return array(
            'type' => (int) $this->getType(),
            'value' => (int) $this->getValue(),
            'date' => $this->getDate()->format(self::DATE_FORMAT),
            'imageconfig' => $this->getImageConfig()->toArray()
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromJson($json)
    {
        $measurement = self::createNew()
            ->setType($json['Type'])
            ->setValue($json['Value'])
            ->setDate(new DateTime($json['Date']))
            ->setDateCreated(new DateTime($json['DateCreated']))
        ;

        if (isset($json['MeasurementIdentifier'])) {
            $measurement
                ->setMeasurementIdentifier($json['MeasurementIdentifier'])
            ;
        }

        return $measurement;
    }

    /**
     * {@inheritdoc}
     */
    public function updateFromJson($json)
    {
        return $this
            ->setMeasurementIdentifier($json['MeasurementIdentifier'])
            ->setChartImage($json['ChartImage'])
        ;
    }
}
