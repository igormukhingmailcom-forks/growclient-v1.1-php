<?php

namespace Grow\Client\Model;

use DateTime;

/**
 * Centile
 *
 * Object representing a Centile
 *
 * @method integer getCentileIdentifier()
 * @method Centile setCentileIdentifier(integer $centileIdentifier)
 *
 * @method integer getAntenatalCareUnit()
 * @method Centile setAntenatalCareUnit(integer $antenatalCareUnit)
 *
 * @method DateTime getBabyDob()
 * @method Centile setBabyDob(DateTime $babyDob)
 *
 * @method integer getBirthWeight()
 * @method Centile setBirthWeight(integer $birthWeight)
 *
 * @method boolean getDetectedSga()
 * @method Centile setDetectedSga(boolean $detectedSga)
 *
 * @method DateTime getEdd()
 * @method Centile setEdd(DateTime $edd)
 *
 * @method integer getGender()
 * @method Centile setGender(integer $gender)
 *
 * @method integer getOutcome()
 * @method Centile setOutcome(integer $outcome)
 *
 * @method boolean getReferralForSuspectedSga()
 * @method Centile setReferralForSuspectedSga(boolean $referralForSuspectedSga)
 *
 * @method float getCentile()
 * @method Centile setCentile(float $centile)
 *
 * @method integer getGestation()
 * @method Centile setGestation(integer $gestation)
 *
 * @method string getGestationFormatted()
 * @method Centile setGestationFormatted(string $gestationFormatted)
 *
 * @method DateCreated getDateCreated()
 * @method Centile setDateCreated(DateCreated $dateCreated)
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class Centile extends BaseSerializableModel
    implements JsonSerializableModelInterface, JsonInstantiableModelInterface, JsonUpdatableModelInterface
{
    /**
     * @var integer
     */
    protected $centileIdentifier;

    /**
     * Must be an identifier of HospitalOption.
     *
     * @var integer
     */
    protected $antenatalCareUnit;

    /**
     * Baby Date of birth
     * Between -280 and 30 days from "EDD"
     *
     * Only year and month will be stored at server
     *
     * @var DateTime
     */
    protected $babyDob;

    /**
     * Birth weight in g (gramms)
     * Between 200 and 8000 (inclusive)
     *
     * @var integer
     */
    protected $birthWeight;

    /**
     * @var boolean
     */
    protected $detectedSga;

    /**
     * @var DateTime
     */
    protected $edd;

    /**
     * Must be an identifier of GenderOption.
     *
     * @var integer
     */
    protected $gender;

    /**
     * Must be an identifier of OutcomeOption.
     *
     * @var integer
     */
    protected $outcome;

    /**
     * @var boolean
     */
    protected $referralForSuspectedSga;

    /**
     * Gestation in days.
     *
     * @var integer
     */
    protected $gestation;

    /**
     * @var string
     */
    protected $gestationFormatted;

    /**
     * @var float
     */
    protected $centile;

    /**
     * @var DateTime
     */
    protected $dateCreated;

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return array(
            'antenatalcareunit' => (int) $this->getAntenatalCareUnit(),
            'babydob' => $this->getBabyDob()->format(self::DATE_FORMAT),
            'birthweight' => (int) $this->getBirthWeight(),
            'detectedsga' => (int) $this->getDetectedSga(),
            'edd' => $this->getEdd()->format(self::DATE_FORMAT),
            'gender' => (int) $this->getGender(),
            'outcome' => (int) $this->getOutcome(),
            'referralforsuspectedsga' => (int) $this->getReferralForSuspectedSga()
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromJson($json)
    {
        $centile = self::createNew()
            ->setBirthWeight($json['BirthWeight'])
            ->setGender($json['Gender'])
            ->setDetectedSga($json['DetectedSGA'])
            ->setReferralForSuspectedSga($json['ReferralForSuspectedSGA'])
            ->setOutcome($json['Outcome'])
            ->setAntenatalCareUnit($json['AntenatalCareUnit'])
            ->setGestation($json['Gestation'])
            ->setGestationFormatted($json['GestationFormatted'])
            ->setCentile($json['Centile'])
            ->setDateCreated(new DateTime($json['DateCreated']))
        ;

        if (isset($json['CentileIdentifier'])) {
            $centile
                ->setCentileIdentifier($json['CentileIdentifier'])
            ;
        }

        return $centile;
    }

    /**
     * {@inheritdoc}
     */
    public function updateFromJson($json)
    {
        if (!empty($json['CentileIdentifier'])) {
            $this
                ->setCentileIdentifier($json['CentileIdentifier'])
            ;
        }

        $this
            ->setCentile($json['Centile'])
            ->setGestation($json['Gestation'])
            ->setGestationFormatted($json['GestationFormatted'])
        ;
        return $this;
    }

}
