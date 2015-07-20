<?php

namespace Grow\Client\Model;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
interface JsonInstantiableModelInterface
{
    /**
     * Create new Entity from json.
     * Used in getXxx functions.
     *
     * @param  array $json
     * @return ModelInterface
     */
    public static function createFromJson($json);

    /**
     * @param  array $data
     * @return ModelInterface[]
     */
    public static function createArrayFromJson($data);
}
