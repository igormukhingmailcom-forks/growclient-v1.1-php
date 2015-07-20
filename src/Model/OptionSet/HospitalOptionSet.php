<?php

namespace Grow\Client\Model\OptionSet;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class HospitalOptionSet extends BaseOptionSet implements OptionSetInterface
{
    /**
     * {@inheritdoc}
     */
    public function getOptionClassName()
    {
        return 'Grow\Client\Model\Option\HospitalOption';
    }
}
