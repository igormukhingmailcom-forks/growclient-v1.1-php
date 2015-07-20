<?php

namespace Grow\Client\Model;

/**
 * Baby
 *
 * Object representing a Baby
 *
 * @method integer getBirthOrderNumber()
 * @method Baby setBirthOrderNumber(integer $birthOrderNumber)
 *
 * @method integer getBirthWeight()
 * @method Baby setBirthWeight(integer $birthWeight)
 *
 * @method integer getGender()
 * @method Baby setGender(integer $gender)
 *
 * @method integer getGestation()
 * @method Baby setGestation(integer $gestation)
 *
 * @method string getName()
 * @method Baby setName(string $name)
 *
 * @method boolean getUnknown()
 * @method Baby setUnknown(boolean $unknown)
 *
 * @method float getCentile()
 * @method Baby setCentile(float $centile)
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class Baby extends BaseSerializableModel implements JsonSerializableModelInterface, JsonUpdatableModelInterface
{
    /**
     * @var integer
     */
    protected $birthOrderNumber;

    /**
     * Birth weight in g (gramms)
     *
     * @var integer
     */
    protected $birthWeight;

    /**
     * Must be an identifier of GenderOption.
     *
     * @var integer
     */
    protected $gender;

    /**
     * @var integer
     */
    protected $gestation;

    /**
     * Baby name.
     * Optional.
     *
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected $unknown;

    /**
     * @var float
     */
    protected $centile;

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $result = array(
            "birthordernumber" => (int) $this->getBirthOrderNumber(),
            "unknown" => (int) $this->getUnknown()
        );

        if (!$this->getUnknown()) {
            $result += array(
                "birthweight" => (int) $this->getBirthWeight(),
                "gender" => (int) $this->getGender(),
                "gestation" => (int) $this->getGestation(),
                "name" => $this->getName()
            );
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function updateFromJson($json)
    {
        return $this
            ->setCentile($json['Centile'])
        ;
    }

}
