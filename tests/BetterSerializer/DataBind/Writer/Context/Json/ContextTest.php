<?php
declare(strict_types=1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Writer\Context\Json;

use BetterSerializer\DataBind\Writer\Context\ContextInterface;
use PHPUnit\Framework\TestCase;
use Mockery;
use RuntimeException;

/**
 * Class ContextTest
 * @author mfris
 * @package BetterSerializer\DataBind\Writer\Context\Json
 */
class ContextTest extends TestCase
{

    /**
     *
     */
    public function testAll(): void
    {
        $context = new Context();
        $context->write('key', 'value');
        $data = $context->getData();

        self::assertInternalType('array', $data);
        self::assertArrayHasKey('key', $data);
        self::assertSame('value', $data['key']);

        $subContext = $context->createSubContext();
        self::assertInstanceOf(Context::class, $subContext);
        $data = $subContext->getData();
        self::assertEmpty($data);

        $subContext->write('key2', 'value2');
        $context->mergeSubContext('sub', $subContext);

        $data = $context->getData();
        self::assertInternalType('array', $data);
        self::assertArrayHasKey('key', $data);
        self::assertSame('value', $data['key']);
        self::assertArrayHasKey('sub', $data);
        self::assertInternalType('array', $data['sub']);
        self::assertArrayHasKey('key2', $data['sub']);
        self::assertSame('value2', $data['sub']['key2']);
    }

    /**
     * @expectedException RuntimeException
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testMergeSubContextThrowsException(): void
    {
        $msg = '/Invalid context to merge. Expected: [A-Z][\\a-zA-Z0-9_]+, actual: [A-Z][\\a-zA-Z0-9_]+/';
        $this->expectExceptionMessageRegExp($msg);
        $context = new Context();
        /* @var $subContext ContextInterface */
        $subContext = Mockery::mock(ContextInterface::class);
        $context->mergeSubContext('test', $subContext);
    }
}
