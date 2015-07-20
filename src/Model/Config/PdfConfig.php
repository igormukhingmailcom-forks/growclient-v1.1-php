<?php

namespace Grow\Client\Model\Config;

use Grow\Client\Model\BaseSerializableModel;

/**
 * PdfConfig
 *
 * Object representing a PdfConfig
 *
 * @method boolean getGreyscale()
 * @method ImageConfig setGreyscale(boolean $greyscale)
 *
 * @method boolean getGridlinesByWeight()
 * @method ImageConfig setGridlinesByWeight(boolean $gridlinesByWeight)
 *
 * @method boolean getShowExtraCentiles()
 * @method ImageConfig setShowExtraCentiles(boolean $showExtraCentiles)
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class PdfConfig extends BaseSerializableModel
{
    /**
     * @var boolean
     */
    protected $greyscale;

    /**
     * @var boolean
     */
    protected $gridlinesByWeight;

    /**
     * @var boolean
     */
    protected $showExtraCentiles;

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return array(
            'greyscale' => (int) $this->getGreyscale(),
            'gridlinesbyweight' => (int) $this->getGridlinesByWeight(),
            'showextracentiles' => (int) $this->getShowExtraCentiles()
        );
    }

}
