<?php
declare(strict_types=1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Writer\Processor;

use BetterSerializer\DataBind\Context\ContextInterface;
use Iterator;

/**
 * Class Object
 * @author mfris
 * @package BetterSerializer\DataBind\Writer\Processor
 */
final class ComplexCollection implements CollectionProcessorInterface
{

    /**
     * @var ProcessorInterface
     */
    private $processor;

    /**
     * Object constructor.
     * @param ProcessorInterface $processor
     */
    public function __construct(ProcessorInterface $processor)
    {
        $this->processor = $processor;
    }

    /**
     * @param ContextInterface $context
     * @param mixed $data
     */
    public function process(ContextInterface $context, $data): void
    {
        if (empty($data)) {
            return;
        }

        /* @var $data Iterator */
        foreach ($data as $key => $value) {
            $subContext = $context->createSubContext();
            $this->processor->process($subContext, $value);
            $context->mergeSubContext($key, $subContext);
        }
    }
}
