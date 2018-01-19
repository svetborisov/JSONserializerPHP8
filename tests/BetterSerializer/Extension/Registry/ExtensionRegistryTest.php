<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\Extension\Registry;

use BetterSerializer\Dto\Car;
use BetterSerializer\Extension\Registry\Registrator\ExtensionRegistratorInterface;
use BetterSerializer\Helper\ExtensionMockFactory;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 *
 */
class ExtensionRegistryTest extends TestCase
{

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testRegisterExtensionOnInstantiation(): void
    {
        $typeString = 'test';
        $extension = ExtensionMockFactory::createTypeExcensionMock($typeString);
        $extensionClass = get_class($extension);

        $extensionsCollection = $this->createMock(ExtensionsCollectionInterface::class);
        $extensionsCollection->expects(self::once())
            ->method('registerExtension')
            ->with($extensionClass);
        $extensionsCollection->expects(self::once())
            ->method('hasType')
            ->with($typeString)
            ->willReturn(true);

        $registrator = $this->createMock(ExtensionRegistratorInterface::class);
        $registrator->expects(self::once())
            ->method('register')
            ->willReturn(true);

        $registry = new ExtensionRegistry($extensionsCollection, [$registrator], [$extensionClass]);

        self::assertTrue($registry->hasType($typeString));
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testRegisterExtension(): void
    {
        $typeString = 'test';
        $extension = ExtensionMockFactory::createTypeExcensionMock($typeString);
        $extensionClass = get_class($extension);

        $extensionsCollection = $this->createMock(ExtensionsCollectionInterface::class);
        $extensionsCollection->expects(self::once())
            ->method('registerExtension')
            ->with($extensionClass);
        $extensionsCollection->expects(self::once())
            ->method('hasType')
            ->with($typeString)
            ->willReturn(true);

        $registrator = $this->createMock(ExtensionRegistratorInterface::class);
        $registrator->expects(self::once())
            ->method('register')
            ->willReturn(true);

        $registry = new ExtensionRegistry($extensionsCollection, [$registrator]);
        $registry->registerExtension($extensionClass);

        self::assertTrue($registry->hasType($typeString));
    }

    /**
     * @expectedException RuntimeException
     */
    public function testRegisterExtensionThrowsException(): void
    {
        $this->expectExceptionMessageRegExp(
            "/Class '[A-za-z0-9_]+', doesn't implement any of these configured extension interfaces: [A-za-z0-9_, ]+/"
        );

        $extensionsCollection = $this->createMock(ExtensionsCollectionInterface::class);

        $registrator = $this->createMock(ExtensionRegistratorInterface::class);
        $registrator->expects(self::once())
            ->method('register')
            ->willReturn(false);
        $registrator->expects(self::once())
            ->method('getExtTypeInterface')
            ->willReturn('TestExtensionInterface');

        $registry = new ExtensionRegistry($extensionsCollection, [$registrator]);
        $registry->registerExtension(Car::class);
    }
}
