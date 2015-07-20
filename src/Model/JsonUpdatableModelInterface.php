<?php

namespace Grow\Client\Model;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
interface JsonUpdatableModelInterface
{
    /**
     * Update Entity from json.
     * Used in addXxx and updateXxx functions.
     *
     * @param  array $json
     * @return ModelInterface
     */
    public function updateFromJson($json);
}
