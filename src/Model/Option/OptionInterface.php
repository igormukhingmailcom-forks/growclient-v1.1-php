<?php

namespace Grow\Client\Model\Option;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
interface OptionInterface
{
    /**
     * Create entity from json array
     *
     * @param  array $json
     * @return OptionSetInterface
     */
    public static function createFromJson($json);
}
