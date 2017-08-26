<?php
declare(strict_types = 1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */
namespace BetterSerializer\DataBind\MetaData\Type;

/**
 * Class String
 * @author mfris
 * @package BetterSerializer\DataBind\MetaData\Type
 */
abstract class AbstractObjectType extends AbstractType implements ObjectTypeInterface
{

    /**
     * @var string
     */
    private $className;

    /**
     * StringDataType constructor.
     * @param string $className
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct(string $className)
    {
        parent::__construct();
        $this->className = ltrim($className, '\\');
    }

    /**
     * @return void
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function initType(): void
    {
        $this->type = TypeEnum::OBJECT();
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param TypeInterface $type
     * @return bool
     */
    public function equals(TypeInterface $type): bool
    {
        /* @var $type ObjectType */
        return parent::equals($type) && $this->className === $type->getClassName();
    }

    /**
     * @param TypeInterface $type
     * @return bool
     */
    public function isCompatibleWith(TypeInterface $type): bool
    {
        return (
            ($type instanceof ObjectType && $this->className === $type->getClassName())
            || $type instanceof UnknownType
        );
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return parent::__toString() . '<' . $this->className . '>';
    }
}
