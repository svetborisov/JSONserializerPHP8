<?php
declare(strict_types=1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Writer\Processor\Factory;

use BetterSerializer\DataBind\MetaData\Reader\ReaderInterface;
use BetterSerializer\DataBind\Writer\Extractor\Factory\AbstractFactoryInterface as ExtractorFactoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class ProcessorFactoryBuilderTest
 * @author mfris
 * @package BetterSerializer\DataBind\Writer\Processor\Factory
 */
class ProcessorFactoryBuilderTest extends TestCase
{

    /**
     *
     */
    public function testBuild(): void
    {
        $extractorFactory = $this->getMockBuilder(ExtractorFactoryInterface::class)->getMock();
        $metaDataReader = $this->getMockBuilder(ReaderInterface::class)->getMock();

        /* @var $extractorFactory ExtractorFactoryInterface */
        /* @var $metaDataReader ReaderInterface */
        $builder = new ProcessorFactoryBuilder($extractorFactory, $metaDataReader);
        $factory = $builder->build();

        self::assertInstanceOf(ProcessorFactoryInterface::class, $factory);
    }
}