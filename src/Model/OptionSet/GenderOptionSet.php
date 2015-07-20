<?php

namespace Grow\Client\Model\OptionSet;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class GenderOptionSet extends BaseOptionSet implements OptionSetInterface
{
    /**
     * {@inheritdoc}
     */
    public function getOptionClassName()
    {
        return 'Grow\Client\Model\Option\GenderOption';
    }
}
