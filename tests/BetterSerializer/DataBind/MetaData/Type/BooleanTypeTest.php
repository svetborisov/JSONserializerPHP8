<?php
declare(strict_types = 1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */
namespace BetterSerializer\DataBind\MetaData\Type;

use BetterSerializer\Dto\Car;
use PHPUnit\Framework\TestCase;

/**
 * Class BooleanTypeTest
 * @author mfris
 * @package BetterSerializer\DataBind\MetaData\Type
 */
class BooleanTypeTest extends TestCase
{

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testGetType(): void
    {
        $bool = new BooleanType();
        self::assertInstanceOf(get_class(TypeEnum::BOOLEAN()), $bool->getType());
    }

    /**
     * @param TypeInterface $typeToTest
     * @param bool $expectedResult
     * @dataProvider typeProvider
     */
    public function testEquals(TypeInterface $typeToTest, bool $expectedResult): void
    {
        $type = new BooleanType();

        self::assertSame($expectedResult, $type->equals($typeToTest));
    }

    /**
     * @return array
     */
    public function typeProvider(): array
    {
        return [
            [new ArrayType(new StringType()), false],
            [new BooleanType(), true],
            [new FloatType(), false],
            [new IntegerType(), false],
            [new NullType(), false],
            [new ObjectType(Car::class), false],
            [new StringType(), false],
        ];
    }
}
