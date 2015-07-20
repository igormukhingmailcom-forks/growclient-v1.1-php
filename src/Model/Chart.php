<?php

namespace Grow\Client\Model;

use DateTime;

use Grow\Client\Model\Baby;
use Grow\Client\Model\Centile;
use Grow\Client\Model\Measurement;

use Grow\Client\Model\Config\PdfConfig;
use Grow\Client\Model\Config\ImageConfig;

/**
 * Chart
 *
 * Object representing a Chart
 *
 * @method integer getChartIdentifier()
 * @method Chart setChartIdentifier(integer $chartIdentifier)
 *
 * @method Baby[] getBabies()
 * @method Chart setBabies(Baby[] $babies)
 *
 * @method DateTime getDob()
 * @method Chart setDob(DateTime $dob)
 *
 * @method DateTime getEdd()
 * @method Chart setEdd(DateTime $edd)
 *
 * @method string getEthnicity()
 * @method Chart setEthnicity(string $ethnicity)
 *
 * @method string getFirstname()
 * @method Chart setFirstname(string $firstname)
 *
 * @method string getLastname()
 * @method Chart setLastname(string $lastname)
 *
 * @method string getMotherRef()
 * @method Chart setMotherRef(string $motherRef)
 *
 * @method integer getHeight()
 * @method Chart setHeight(integer $height)
 *
 * @method integer getWeight()
 * @method Chart setWeight(integer $weight)
 *
 * @method integer getGetImage()
 * @method Chart setGetImage(boolean $getImage)
 *
 * @method ImageConfig getImageConfig()
 * @method Chart setImageConfig(ImageConfig $imageConfig)
 *
 * @method integer getGetPdf()
 * @method Chart setGetPdf(boolean $getPdf)
 *
 * @method ImageConfig getPdfConfig()
 * @method Chart setPdfConfig(ImageConfig $pdfConfig)
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class Chart extends BaseSerializableModel implements JsonSerializableModelInterface, JsonInstantiableModelInterface, JsonUpdatableModelInterface
{
    /**
     * @var integer
     */
    protected $chartIdentifier;

    /**
     * @var Baby[]
     */
    protected $babies = array();

    /**
     * Date of birth
     * Required if "GetPdf" is true
     *
     * @var DateTime
     */
    protected $dob;

    /**
     * Estimated Delivery Date
     *
     * @var DateTime
     */
    protected $edd;

    /**
     * Must be an identifier of EthnicityOption.
     *
     * @var string
     */
    protected $ethnicity;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    /**
     * Required if "GetPdf" is true
     *
     * @var string
     */
    protected $motherRef;

    /**
     * Maternal height in cm
     *
     * @var integer
     */
    protected $height;

    /**
     * Maternal weight in kg
     *
     * @var integer
     */
    protected $weight;

    /**
     * @var boolean
     */
    protected $getImage;

    /**
     * Required if "getImage" is true
     *
     * @var ImageConfig
     */
    protected $imageConfig;

    /**
     * @var boolean
     */
    protected $getPdf;

    /**
     * Required if "getPdf" is true
     *
     * @var PdfConfig
     */
    protected $pdfConfig;

    /**
     * Base64 encoded image.
     *
     * @var string
     */
    protected $chartImage;

    /**
     * Base64 encoded PDF document.
     *
     * @var string
     */
    protected $chartPdf;

    /**
     * @var float
     */
    protected $bmi;

    /**
     * @var integer
     */
    protected $tow;

    /**
     * @var integer
     */
    protected $parity;

    /**
     * @var DateTime
     */
    protected $dateCreated;

    /**
     * @var Centile[]
     */
    protected $centiles;

    /**
     * @var Measurement[]
     */
    protected $measurements;

    /**
     * @param Baby $baby
     */
    public function addBaby(Baby $baby)
    {
        $this->babies[] = $baby;

        return $this;
    }

    /**
     * @param  integer $birthOrderNumber
     * @return Baby
     */
    public function getBaby($birthOrderNumber)
    {
        foreach ($this->getBabies() as $baby) {
            if ($baby->getBirthOrderNumber($birthOrderNumber)) {
                return $baby;
            }
        }

        $baby = Baby::createNew()
            ->setBirthOrderNumber($birthOrderNumber)
        ;
        $this->addBaby($baby);
        return $baby;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $result = array(
            'dob' => $this->getDob()->format(self::DATE_FORMAT),
            'edd' => $this->getEdd()->format(self::DATE_FORMAT),
            'ethnicity' => (string) $this->getEthnicity(),
            'firstname' => $this->getFirstname(),
            'lastname' => $this->getLastname(),
            'motherref' => $this->getMotherRef(),
            'height' => (int) $this->getHeight(),
            'weight' => (int) $this->getWeight(),
            'getimage' => (int) $this->getGetImage(),
            'getpdf' => (int) $this->getGetPdf(),
        );

        if ($this->getGetImage()) {
            $result['imageconfig'] = $this->getImageConfig()->toArray();
        }

        if ($this->getGetPdf()) {
            $result['pdfconfig'] = $this->getPdfConfig()->toArray();
        }

        foreach ($this->getBabies() as $baby) {
            $result['babies'][] = $baby->toArray();
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromJson($json)
    {
        $chart = self::createNew();

        // if ($json['ChartIdentifier']) {
        //     $chart->setChartIdentifier($json['ChartIdentifier']);
        // }

        return $chart
            ->setChartImage($json['ChartImage'])
            ->setBmi($json['BMI'])
            ->setTow($json['TOW'])
            ->setEthnicity($json['Ethnicity'])
            ->setHeight($json['Height'])
            ->setWeight($json['Weight'])
            ->setParity($json['Parity'])
            ->setDateCreated(new DateTime($json['DateCreated']))
            ->setEdd(new DateTime($json['EDD']))
            ->setCentiles(Centile::createArrayFromJson($json['Centiles']))
            ->setMeasurements(Measurement::createArrayFromJson($json['Measurements']))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function updateFromJson($json)
    {
        if (isset($json['ChartIdentifier'])) {
            $this->setChartIdentifier($json['ChartIdentifier']);
        }

        $this
            ->setChartImage($json['ChartImage'])
            ->setChartPdf($json['ChartPDF'])
            ->setBmi($json['BMI'])
            ->setTow($json['TOW'])
        ;

        foreach ($json['Babies'] as $babyJson) {
            $baby = $this->getBaby($babyJson['BirthOrderNumber']);
            $baby->updateFromJson($babyJson);
        }

        return $this;
    }

    /**
     * @param  string $filename Filename to save to
     */
    public function saveImage($filename)
    {
        $content = base64_decode($this->getChartImage());
        return file_put_contents($filename, $content);
    }

    /**
     * @param  string $filename Filename to save to
     */
    public function savePdf($filename)
    {
        $content = base64_decode($this->getChartPdf());
        return file_put_contents($filename, $content);
    }
}
