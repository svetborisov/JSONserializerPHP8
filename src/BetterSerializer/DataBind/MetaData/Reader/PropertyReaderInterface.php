<?php
declare(strict_types = 1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */
namespace BetterSerializer\DataBind\MetaData\Reader;

use BetterSerializer\DataBind\MetaData\PropertyMetaDataInterface;
use ReflectionClass;

/**
 * Class PropertyReader
 * @author mfris
 * @package BetterSerializer\DataBind\MetaData
 */
interface PropertyReaderInterface
{
    /**
     * @param ReflectionClass $reflectionClass
     * @return PropertyMetaDataInterface[]
     */
    public function getPropertyMetadata(ReflectionClass $reflectionClass): array;
}
