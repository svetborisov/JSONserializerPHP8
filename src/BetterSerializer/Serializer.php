<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */
namespace BetterSerializer;

use BetterSerializer\Common\SerializationTypeInterface;
use BetterSerializer\DataBind\Reader\ReaderInterface;
use BetterSerializer\DataBind\Writer\SerializationContext;
use BetterSerializer\DataBind\Writer\SerializationContextInterface;
use BetterSerializer\DataBind\Writer\WriterInterface;
use LogicException;
use ReflectionException;
use RuntimeException;

/**
 * Class Serializer
 *
 * @author  mfris
 * @package BetterSerializer
 */
final class Serializer
{

    /**
     * @var ReaderInterface
     */
    private $reader;

    /**
     * @var WriterInterface
     */
    private $writer;

    /**
     * ObjectMapper constructor.
     *
     * @param ReaderInterface $reader
     * @param WriterInterface $writer
     */
    public function __construct(ReaderInterface $reader, WriterInterface $writer)
    {
        $this->reader = $reader;
        $this->writer = $writer;
    }

    /**
     * @param string $serialized
     * @param string $stringType
     * @param SerializationTypeInterface $serializationType
     * @return mixed
     */
    public function deserialize(
        string $serialized,
        string $stringType,
        SerializationTypeInterface $serializationType
    ) {
        return $this->reader->readValue($serialized, $stringType, $serializationType);
    }

    /**
     * @param mixed             $data
     * @param SerializationTypeInterface $type
     * @param SerializationContextInterface $context
     * @return string
     * @throws LogicException
     * @throws ReflectionException
     * @throws RuntimeException
     */
    public function serialize(
        $data,
        SerializationTypeInterface $type,
        SerializationContextInterface $context = null
    ): string {
        if (!$context) {
            $context = new SerializationContext();
        }

        return $this->writer->writeValueAsString($data, $type, $context);
    }
}
