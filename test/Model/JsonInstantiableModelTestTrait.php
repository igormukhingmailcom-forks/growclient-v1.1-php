<?php

namespace Grow\Client\Test\Model;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
trait JsonInstantiableModelTestTrait
{
    /**
     * Data provider for testJsonInstantiation
     */
    abstract public function jsonInstantiationDataProvider();

    /**
     * @dataProvider jsonInstantiationDataProvider
     */
    public function testJsonInstantiation($entityClass, $data, $expectedEntity)
    {
        $this->assertEquals($expectedEntity, $entityClass::createFromJson($data));
    }
}
