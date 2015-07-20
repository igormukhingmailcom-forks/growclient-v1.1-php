<?php

namespace Grow\Client\Model\OptionSet;

use Grow\Client\Model\BaseModel;
use Grow\Client\Model\Option\OptionInterface;

/**
 * @method OptionSetInterface setOptions(OptionInterface[] $options)
 * @method OptionInterface[] getOptions()
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
abstract class BaseOptionSet extends BaseModel implements OptionSetInterface, \Iterator
{
    protected $options;

    /**
     * @param Option[] $options
     */
    public function __construct(array $options = array())
    {
        $this->options = $options;
        $this->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromJson($json)
    {
        $set = self::createNew();
        foreach($json as $item) {
            $optionClassName = $set->getOptionClassName();
            $option = $optionClassName::createFromJson($item);
            $set->addItem($option);
        }
        // var_dump($set);
        return $set;
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(OptionInterface $item)
    {
        $this->options[] = $item;
    }

    /**
     * {@inheritdoc}
     */
    public function findById($id)
    {
        return $this->options[$id];
    }

    public function rewind()
    {
        reset($this->options);
    }

    public function current()
    {
        return current($this->options);
    }

    public function key()
    {
        return key($this->options);
    }

    public function next()
    {
        return next($this->options);
    }

    public function valid()
    {
        $key = key($this->options);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

}
