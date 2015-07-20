<?php

namespace Grow\Client\Model\Config;

use Grow\Client\Model\BaseSerializableModel;

/**
 * ImageConfig
 *
 * Object representing a ImageConfig
 *
 * @method boolean getGreyscale()
 * @method ImageConfig setGreyscale(boolean $greyscale)
 *
 * @method boolean getGridlinesByWeight()
 * @method ImageConfig setGridlinesByWeight(boolean $gridlinesByWeight)
 *
 * @method integer getScalePercent()
 * @method ImageConfig setScalePercent(integer $scalePercent)
 *
 * @method boolean getShowExtraCentiles()
 * @method ImageConfig setShowExtraCentiles(boolean $showExtraCentiles)
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class ImageConfig extends BaseSerializableModel
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
     * @var integer
     */
    protected $scalePercent;

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
            'scalepercent' => (int) $this->getScalePercent(),
            'showextracentiles' => (int) $this->getShowExtraCentiles()
        );
    }

}
