<?php

namespace Grow\Client\Test\Model;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
trait JsonSerializableModelTestTrait
{
    /**
     * Data provider for testJsonSerialization
     */
    abstract public function jsonSerializationDataProvider();

    /**
     * @dataProvider jsonSerializationDataProvider
     */
    public function testJsonSerialization($entityClass, $data, $expectedJsonString)
    {
        // Reformat json
        $expectedJson = json_encode(json_decode($expectedJsonString));

        $entity = $entityClass::createNew();
        foreach($data as $fieldName=>$fieldValue) {
            $setterName = sprintf('set%s', $fieldName);
            $returnedObject = $entity->$setterName($fieldValue);

            // Check setXxx == getXxx
            $getterName = sprintf('get%s', $fieldName);
            $this->assertSame($fieldValue, $entity->$getterName());

            // Check returned $this on each setter
            $this->assertInstanceOf($entityClass, $returnedObject);
        }

        // var_dump("entity=");
        // var_dump($entity->toJson());
        // // var_dump("expectedJsonString=");
        // // var_dump($expectedJsonString);
        // var_dump("expectedJson=");
        // var_dump($expectedJson);

        // Check toJson() returns expected json-string
        $this->assertJsonStringEqualsJsonString($entity->toJson(), $expectedJson);
    }
}
