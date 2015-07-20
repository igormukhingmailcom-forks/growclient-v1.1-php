<?php

namespace Grow\Client\Model;

use DateTime;

/**
 * ChartIdentifierPrefixResponse
 *
 * Object representing a ChartIdentifierPrefixResponse
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class ChartIdentifierPrefix extends BaseModel implements JsonInstantiableModelInterface
{
    /**
     * @var string
     */
    protected $chartIdentifierPrefix;

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
            ->setChartIdentifierPrefix($json['ChartIdentifierPrefix'])
            ->setDateCreated(new DateTime($json['DateCreated']))
        ;
        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getChartIdentifierPrefix();
    }
}

