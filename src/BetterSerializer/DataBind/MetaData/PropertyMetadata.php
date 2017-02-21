<?php
declare(strict_types = 1);

/**
 * @author  mfris
 */
namespace BetterSerializer\DataBind\MetaData;

use BetterSerializer\DataBind\MetaData\Annotations\AnnotationInterface;
use BetterSerializer\DataBind\MetaData\Type\TypeInterface;
use ReflectionProperty;

/**
 * Class PropertyMetadata
 * @author mfris
 * @package BetterSerializer\DataBind\MetaData
 */
final class PropertyMetadata implements PropertyMetadataInterface
{

    /**
     * @var ReflectionProperty
     */
    private $reflectionProperty;

    /**
     * @var AnnotationInterface[]
     */
    private $annotations;

    /**
     * @var TypeInterface
     */
    private $type;

    /**
     * PropertyMetadata constructor.
     * @param ReflectionProperty $reflectionProperty
     * @param AnnotationInterface[] $annotations
     * @param TypeInterface $type
     */
    public function __construct(ReflectionProperty $reflectionProperty, array $annotations, TypeInterface $type)
    {
        $this->reflectionProperty = $reflectionProperty;
        $this->annotations = $annotations;
        $this->type = $type;
    }

    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface
    {
        return $this->type;
    }
}