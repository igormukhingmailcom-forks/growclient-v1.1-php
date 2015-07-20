<?php

namespace Grow\Client\Model;

use Grow\Client\Exception\BadMethodCallException;

use DateTime;

/**
 * BaseModel
 *
 * Base class for model objects
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
abstract class BaseModel implements ModelInterface
{
    const DATE_FORMAT = 'Y-m-d';

    /**
     * {@inheritdoc}
     */
    public static function createNew()
    {
        $class = get_called_class();
        return new $class();
    }

    /**
     * {@inheritdoc}
     */
    public static function createArrayFromJson($data)
    {
        return array_map(function($json){
            return self::createFromJson($json);
        }, $data);
    }

    /**
     * Magic getters/setters
     *
     * @param  mixed $name
     * @param  mixed $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (!preg_match('/^(get|set)(.+)$/', $name, $matchesArray)) {
            throw new BadMethodCallException(
                sprintf(
                    'Method "%s" does not exist on entity "%s"',
                    $name,
                    get_class($this)
                )
            );
        }

        $propertyName = $matchesArray[2];
        $propertyName = strtolower(substr($propertyName, 0, 1)). substr($propertyName, 1);

        if (!property_exists($this, $propertyName)) {
            throw new BadMethodCallException(
                sprintf(
                    'Entity %s does not have a property named %s',
                    get_class($this),
                    $propertyName
                )
            );
        }

        switch ($matchesArray[1]) {
            case 'set':
                $this->$propertyName = $arguments[0];
                return $this;

            case 'get':
                return $this->$propertyName;
        }
    }

}
