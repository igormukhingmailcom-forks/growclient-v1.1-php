<?php

namespace Grow\Client\Model\Option;

use Grow\Client\Model\BaseModel;

/**
 * @method OptionInterface setIdentifier(string $identifier)
 * @method string getIdentifier()
 *
 * @method OptionInterface setValue(string $value)
 * @method string getValue()
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
abstract class BaseOption extends BaseModel implements OptionInterface
{
    /**
     * @var integer
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $value;

    /**
     * @param integer $identifier
     * @param string  $value
     */
    public function __construct($identifier = null, $value = null)
    {
        $this->setIdentifier($identifier);
        $this->setValue($value);
    }

    public function __toString()
    {
        return (string) $this->getIdentifier();
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromJson($json)
    {
        return self::createNew()
            ->setIdentifier($json['Identifier'])
            ->setValue($json['Value'])
        ;
    }
}
