<?php
declare(strict_types=1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\MetaData;

use PHPUnit\Framework\TestCase;
use Mockery;

/**
 * Class MetaDataTest
 * @author mfris
 * @package BetterSerializer\DataBind\MetaData
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class MetaDataTest extends TestCase
{

    /**
     *
     */
    public function testInstantiation(): void
    {
        $classMetadata = Mockery::mock(ClassMetaDataInterface::class);
        $propertiesMetaData = [
            Mockery::mock(PropertyMetaDataInterface::class),
            Mockery::mock(PropertyMetaDataInterface::class),
        ];

        /* @var $classMetadata ClassMetaDataInterface */
        $metaData = new MetaData($classMetadata, $propertiesMetaData);

        self::assertInstanceOf(ClassMetaDataInterface::class, $metaData->getClassMetadata());
        self::assertSame($classMetadata, $metaData->getClassMetadata());
        self::assertInternalType('array', $metaData->getPropertiesMetadata());
        self::assertCount(2, $metaData->getPropertiesMetadata());

        foreach ($metaData->getPropertiesMetadata() as $propertyMetaData) {
            self::assertInstanceOf(PropertyMetaDataInterface::class, $propertyMetaData);
        }
    }
}
