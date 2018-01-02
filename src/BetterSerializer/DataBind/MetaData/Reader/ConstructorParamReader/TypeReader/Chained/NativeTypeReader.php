<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\MetaData\Reader\ConstructorParamReader\TypeReader\Chained;

use BetterSerializer\DataBind\MetaData\Type\Factory\NativeTypeFactoryInterface;
use BetterSerializer\DataBind\MetaData\Type\StringFormType\Parser\StringTypeParserInterface;
use BetterSerializer\DataBind\MetaData\Type\TypeInterface;
use BetterSerializer\Reflection\ReflectionMethodInterface;
use BetterSerializer\Reflection\ReflectionParameterInterface;
use LogicException;

/**
 *
 */
final class NativeTypeReader implements ChainedTypeReaderInterface
{

    /**
     * @var StringTypeParserInterface
     */
    private $stringTypeParser;

    /**
     * @var NativeTypeFactoryInterface
     */
    private $nativeTypeFactory;

    /**
     * @param StringTypeParserInterface $stringTypeParser
     * @param NativeTypeFactoryInterface $nativeTypeFactory
     */
    public function __construct(
        StringTypeParserInterface $stringTypeParser,
        NativeTypeFactoryInterface $nativeTypeFactory
    ) {
        $this->nativeTypeFactory = $nativeTypeFactory;
        $this->stringTypeParser = $stringTypeParser;
    }

    /**
     * @param ReflectionMethodInterface $constructor
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function initialize(ReflectionMethodInterface $constructor): void
    {
    }

    /**
     * @param ReflectionParameterInterface $parameter
     * @return TypeInterface
     * @throws LogicException
     */
    public function getType(ReflectionParameterInterface $parameter): TypeInterface
    {
        $type = $parameter->getType();
        $stringFormType = $this->stringTypeParser->parseWithParentContext(
            (string) $type,
            $parameter->getDeclaringClass()
        );

        return $this->nativeTypeFactory->getType($stringFormType);
    }
}
