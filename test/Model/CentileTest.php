<?php

namespace Grow\Client\Test\Model;

use DateTime;

use Grow\Client\Model\Centile;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class CentileTest extends BaseModelTest
{
    use JsonSerializableModelTestTrait;
    use JsonInstantiableModelTestTrait;
    use JsonUpdatableModelTestTrait;

    public function jsonSerializationDataProvider()
    {
        return array(
            array(
                'Grow\Client\Model\Centile',
                array(
                    'antenatalCareUnit'=>2,
                    'babyDob'=>new DateTime('2015-01-10 01:01:01'),
                    'birthWeight'=>3450,
                    'detectedSga'=>false,
                    'edd'=>new DateTime('2015-01-07 01:01:01'),
                    'gender'=>1,
                    'outcome'=>0,
                    'referralForSuspectedSga'=>false
                ),
                '{
                    "antenatalcareunit":"2",
                    "babydob":"2015-01-10",
                    "birthweight":3450,
                    "detectedsga":0,
                    "edd":"2015-01-07",
                    "gender":1,
                    "outcome":0,
                    "referralforsuspectedsga":0
                }'
            )
        );
    }

    public function jsonInstantiationDataProvider()
    {
        return array(

            // With identifier
            array(
                'Grow\Client\Model\Centile',
                array(
                    "CentileIdentifier" => 1000,

                    "BirthWeight" => 3450,
                    "Gender" => 1,
                    "DetectedSGA" => false,
                    "ReferralForSuspectedSGA" => false,
                    "Outcome" => 0,
                    "AntenatalCareUnit" => 2,
                    "Gestation" => 283,
                    "GestationFormatted" => '40 weeks 3 days',
                    "Centile" => 38.90,
                    "DateCreated" => '2015-02-16 13:04:26',
                ),
                Centile::createNew()
                    ->setCentileIdentifier(1000)
                    ->setBirthWeight(3450)
                    ->setGender(1)
                    ->setDetectedSga(false)
                    ->setReferralForSuspectedSga(false)
                    ->setOutcome(0)
                    ->setAntenatalCareUnit(2)
                    ->setGestation(283)
                    ->setGestationFormatted('40 weeks 3 days')
                    ->setCentile(38.90)
                    ->setDateCreated(new DateTime('2015-02-16 13:04:26'))
            ),

            // Without identifier
            array(
                'Grow\Client\Model\Centile',
                array(
                    "BirthWeight" => 3450,
                    "Gender" => 1,
                    "DetectedSGA" => false,
                    "ReferralForSuspectedSGA" => false,
                    "Outcome" => 0,
                    "AntenatalCareUnit" => 2,
                    "Gestation" => 283,
                    "GestationFormatted" => '40 weeks 3 days',
                    "Centile" => 38.90,
                    "DateCreated" => '2015-02-16 13:04:26',
                ),
                Centile::createNew()
                    ->setBirthWeight(3450)
                    ->setGender(1)
                    ->setDetectedSga(false)
                    ->setReferralForSuspectedSga(false)
                    ->setOutcome(0)
                    ->setAntenatalCareUnit(2)
                    ->setGestation(283)
                    ->setGestationFormatted('40 weeks 3 days')
                    ->setCentile(38.90)
                    ->setDateCreated(new DateTime('2015-02-16 13:04:26'))
            )
        );
    }

    public function jsonUpdateDataProvider()
    {
        return array(
            array(
                'Grow\Client\Model\Centile',
                array(
                    "CentileIdentifier" => 1000,
                    "Centile" => 22.33,
                    "Gestation" => 14,
                    "GestationFormatted" => '2 weeks',
                ),
                Centile::createNew()
                    ->setCentileIdentifier(1000)
                    ->setCentile(22.33)
                    ->setGestation(14)
                    ->setGestationFormatted('2 weeks')
            )
        );
    }
}
