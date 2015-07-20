<?php

namespace Grow\Client\Test\Model;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
trait JsonUpdatableModelTestTrait
{
    /**
     * Data provider for testJsonUpdate
     */
    abstract public function jsonUpdateDataProvider();

    /**
     * @dataProvider jsonUpdateDataProvider
     */
    public function testJsonUpdate($entityClass, $json, $expectedEntity)
    {
        $entity = $entityClass::createNew();
        $returnedEntity = $entity->updateFromJson($json);

        // Must return link to self
        $this->assertSame($entity, $returnedEntity);
        $this->assertEquals($entity, $expectedEntity);
    }
}
