<?php
declare(strict_types = 1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */
namespace BetterSerializer\DataBind\MetaData\Type;

/**
 * Class TypeFactory
 * @author mfris
 * @package BetterSerializer\DataBind\MetaData\Type
 */
interface TypeFactoryInterface
{
    /**
     * @param string $stringType
     * @return TypeInterface
     */
    public function getType(string $stringType = null): TypeInterface;
}
