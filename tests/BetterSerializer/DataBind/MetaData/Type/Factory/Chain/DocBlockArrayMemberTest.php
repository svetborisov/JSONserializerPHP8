<?php
declare(strict_types=1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\MetaData\Type\Factory\Chain;

use BetterSerializer\DataBind\MetaData\Type\ArrayType;
use BetterSerializer\DataBind\MetaData\Type\Factory\TypeFactoryInterface;
use BetterSerializer\DataBind\MetaData\Type\StringFormType\StringFormTypeInterface;
use BetterSerializer\DataBind\MetaData\Type\TypeEnum;
use BetterSerializer\DataBind\MetaData\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class DocBlockArrayMemberTest
 * @author mfris
 * @package BetterSerializer\DataBind\MetaData\Type\Factory\Chain
 */
class DocBlockArrayMemberTest extends TestCase
{

    /**
     *
     */
    public function testGetTypeWithSimpleSubType(): void
    {
        $stringTypeString = 'string[]';

        $stringTypeInstance = $this->getMockBuilder(TypeInterface::class)->getMock();

        $typeFactory = $this->getMockBuilder(TypeFactoryInterface::class)->getMock();
        $typeFactory->expects(self::once())
            ->method('getType')
            ->willReturn($stringTypeInstance);
        /* @var $typeFactory TypeFactoryInterface */

        $stringType = $this->getMockBuilder(StringFormTypeInterface::class)->getMock();
        $stringType->expects(self::once())
            ->method('getStringType')
            ->willReturn($stringTypeString);
        $stringType->expects(self::once())
            ->method('getNamespace')
            ->willReturn('test');
        /* @var $stringType StringFormTypeInterface */

        $arrayMember = new DocBlockArrayMember($typeFactory);
        /* @var $arrayType ArrayType */
        $arrayType = $arrayMember->getType($stringType);

        self::assertInstanceOf(ArrayType::class, $arrayType);
        self::assertSame($arrayType->getNestedType(), $stringTypeInstance);
    }

    /**
     *
     */
    public function testGetTypeWithObjectSubType(): void
    {
        $stringTypeString = 'Car[]';
        $objectTypeInstance = $this->getMockBuilder(TypeInterface::class)->getMock();

        $typeFactory = $this->getMockBuilder(TypeFactoryInterface::class)->getMock();
        $typeFactory->expects(self::once())
            ->method('getType')
            ->willReturn($objectTypeInstance);
        /* @var $typeFactory TypeFactoryInterface */

        $stringType = $this->getMockBuilder(StringFormTypeInterface::class)->getMock();
        $stringType->expects(self::once())
            ->method('getStringType')
            ->willReturn($stringTypeString);
        $stringType->expects(self::once())
            ->method('getNamespace')
            ->willReturn('test');
        /* @var $stringType StringFormTypeInterface */

        $arrayMember = new DocBlockArrayMember($typeFactory);
        /* @var $arrayType ArrayType */
        $arrayType = $arrayMember->getType($stringType);

        self::assertInstanceOf(ArrayType::class, $arrayType);
        self::assertSame($arrayType->getNestedType(), $objectTypeInstance);
    }

    /**
     *
     */
    public function testGetTypeReturnsNull(): void
    {
        $typeFactory = $this->getMockBuilder(TypeFactoryInterface::class)->getMock();
        /* @var $typeFactory TypeFactoryInterface */

        $stringType = $this->getMockBuilder(StringFormTypeInterface::class)->getMock();
        $stringType->expects(self::once())
            ->method('getStringType')
            ->willReturn(TypeEnum::STRING);
        /* @var $stringType StringFormTypeInterface */

        $arrayMember = new DocBlockArrayMember($typeFactory);
        $shouldBeNull = $arrayMember->getType($stringType);

        self::assertNull($shouldBeNull);
    }
}