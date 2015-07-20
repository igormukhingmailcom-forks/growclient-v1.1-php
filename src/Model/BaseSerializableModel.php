<?php

namespace Grow\Client\Model;

use Grow\Client\Exception\BadMethodCallException;

use DateTime;

/**
 * BaseSerializableModel
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
abstract class BaseSerializableModel extends BaseModel implements JsonSerializableModelInterface
{
    /**
     * {@inheritdoc}
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
