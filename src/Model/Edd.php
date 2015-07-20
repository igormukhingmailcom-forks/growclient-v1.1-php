<?php

namespace Grow\Client\Model;

use DateTime;

/**
 * Edd
 *
 * Object representing a Edd
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class Edd extends BaseModel implements JsonInstantiableModelInterface
{
    /**
     * @var DateTime
     */
    protected $edd;

    /**
     * @var DateTime
     */
    protected $dateCreated;

    /**
     * {@inheritdoc}
     */
    public static function createFromJson($json)
    {
        $response = self::createNew();
        $response
            ->setEdd(new DateTime($json['EDD']))
            ->setDateCreated(new DateTime($json['DateCreated']))
        ;
        return $response;
    }

    /**
     * String representation of this object
     */
    public function __toString()
    {
        return $this->getEdd()->format('Y-m-d');
    }
}

