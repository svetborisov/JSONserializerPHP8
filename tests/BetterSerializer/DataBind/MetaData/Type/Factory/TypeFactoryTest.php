<?php
declare(strict_types=1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\MetaData\Type\Factory;

use BetterSerializer\DataBind\MetaData\Type\Factory\Chain\ChainMemberInterface;
use BetterSerializer\DataBind\MetaData\Type\TypeEnum;
use BetterSerializer\DataBind\MetaData\Type\TypeInterface;
use PHPUnit\Framework\TestCase;
use LogicException;

/**
 * Class ChainTest
 * @author mfris
 * @package BetterSerializer\DataBind\MetaData\Type\Factory\Chain
 */
class TypeFactoryTest extends TestCase
{

    /**
     *
     */
    public function testGetType(): void
    {
        $stringType = TypeEnum::STRING;

        $type = $this->getMockBuilder(TypeInterface::class)->getMock();

        $chainMember = $this->getMockBuilder(ChainMemberInterface::class)->getMock();
        $chainMember->expects(self::exactly(2))
            ->method('getType')
            ->with($stringType)
            ->willReturnOnConsecutiveCalls(null, $type);

        $typeFactory = new TypeFactory([$chainMember, $chainMember]);
        $createdType = $typeFactory->getType($stringType);

        self::assertSame($type, $createdType);
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessageRegExp /Unknown type - '[a-zA-Z0-9]+'+/
     */
    public function testGetTypeThrowsException(): void
    {
        $stringType = TypeEnum::STRING;

        $chainMember = $this->getMockBuilder(ChainMemberInterface::class)->getMock();
        $chainMember->expects(self::once())
            ->method('getType')
            ->with($stringType)
            ->willReturn(null);

        $typeFactory = new TypeFactory([$chainMember]);
        $typeFactory->getType($stringType);
    }

    /**
     *
     */
    public function testAddChainMemberType(): void
    {
        $stringType = TypeEnum::STRING;

        $type = $this->getMockBuilder(TypeInterface::class)->getMock();

        $chainMember = $this->getMockBuilder(ChainMemberInterface::class)->getMock();
        $chainMember->expects(self::once())
            ->method('getType')
            ->with($stringType)
            ->willReturn($type);

        $typeFactory = new TypeFactory();

        try {
            $typeFactory->getType($stringType);
        } catch (LogicException $e) {
        }

        /* @var $chainMember ChainMemberInterface */
        $typeFactory->addChainMember($chainMember);
        $createdType = $typeFactory->getType($stringType);

        self::assertSame($type, $createdType);
    }
}
