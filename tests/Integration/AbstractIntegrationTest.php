<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace Integration;

use BetterSerializer\Builder;
use BetterSerializer\Helper\DataBind\BooleanStringExtension;
use BetterSerializer\Serializer;
use JMS\Serializer\Serializer as JmsSerializer;
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

/*
 * @author mfris
 * @package Integration
 */
abstract class AbstractIntegrationTest extends TestCase
{

    /**
     * @var Builder
     */
    private static $builder;

    /**
     * @var Builder
     */
    private static $builderCached;

    /**
     * @var Serializer
     */
    private static $serializer;

    /**
     * @var Serializer
     */
    private static $cachedSerializer;

    /**
     * @var JmsSerializer
     */
    private static $jmsSerializer;

    /**
     *
     */
    public static function setUpBeforeClass()
    {
        self::$builder = new Builder();
        self::$builderCached = new Builder();
        self::$builder->addExtension(BooleanStringExtension::class);
        self::$builderCached->addExtension(BooleanStringExtension::class);

        if (extension_loaded('apcu') && ini_get('apc.enabled')) {
            self::$builderCached->enableApcuCache();

            return;
        }

        self::$builderCached->enableFilesystemCache(dirname(__DIR__, 2) . '/cache/better-serializer');
    }

    /**
     * @return Serializer
     * @throws \Pimple\Exception\UnknownIdentifierException
     */
    protected function getSerializer(): Serializer
    {
        if (self::$serializer === null) {
            self::$serializer = self::$builder->createSerializer();
        }

        return self::$serializer;
    }

    /**
     * @return Serializer
     * @throws \Pimple\Exception\UnknownIdentifierException
     */
    protected function getCachedSerializer(): Serializer
    {
        if (self::$cachedSerializer === null) {
            self::$builderCached->clearCache();
            self::$cachedSerializer = self::$builderCached->createSerializer();
        }

        return self::$cachedSerializer;
    }

    /**
     * @return JmsSerializer
     * @throws \JMS\Serializer\Exception\InvalidArgumentException
     * @throws \JMS\Serializer\Exception\RuntimeException
     */
    protected function getJmsSerializer(): JmsSerializer
    {
        if (self::$jmsSerializer === null) {
            self::$jmsSerializer = SerializerBuilder::create()
                ->setCacheDir(dirname(__DIR__, 2) . '/cache/jms-serializer')
                ->build();
        }

        return self::$jmsSerializer;
    }
}
