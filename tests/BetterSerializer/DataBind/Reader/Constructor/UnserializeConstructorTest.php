<?php
declare(strict_types=1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Reader\Constructor;

use BetterSerializer\Dto\Door;
use Doctrine\Instantiator\InstantiatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class UnserializeConstructorTest
 * @author mfris
 * @package BetterSerializer\DataBind\Reader\Constructor
 */
class UnserializeConstructorTest extends TestCase
{

    /**
     *
     */
    public function testConstruct(): void
    {
        $className = Door::class;
        $instantiator = $this->getMockBuilder(InstantiatorInterface::class)
            ->disableProxyingToOriginalMethods()
            ->getMock();
        $instantiator->expects(self::once())
            ->method('instantiate')
            ->with($className)
            ->willReturn(new Door());

        /* @var $instantiator InstantiatorInterface */
        $constructor = new UnserializeConstructor($instantiator, $className);
        $object = $constructor->construct();

        self::assertInstanceOf($className, $object);
    }
}
