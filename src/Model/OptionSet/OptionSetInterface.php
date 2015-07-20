<?php

namespace Grow\Client\Model\OptionSet;

use Grow\Client\Model\Option\OptionInterface;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
interface OptionSetInterface
{
    /**
     * @return string Option class name contained in this OptionSet
     */
    public function getOptionClassName();

    /**
     * Create entity from json array
     *
     * @param  array $json
     * @return OptionSetInterface
     */
    public static function createFromJson($json);

    /**
     * @param  OptionInterface $item
     * @return OptionSetInterface
     */
    public function addItem(OptionInterface $item);

    /**
     * @param  integer         $id  Option id
     * @return OptionInterface      Option
     */
    public function findById($id);
}
