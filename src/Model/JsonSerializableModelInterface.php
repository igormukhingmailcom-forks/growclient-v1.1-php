<?php

namespace Grow\Client\Model;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
interface JsonSerializableModelInterface
{
    /**
     * Convert entity to array
     */
    public function toArray();

    /**
     * Convert entity to json string
     */
    public function toJson();
}
