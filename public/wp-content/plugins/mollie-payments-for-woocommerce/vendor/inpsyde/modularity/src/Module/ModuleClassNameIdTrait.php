<?php

declare (strict_types=1);
namespace Mollie\Inpsyde\Modularity\Module;

trait ModuleClassNameIdTrait
{
    /**
     * @return string
     *
     * @see Module::id()
     */
    public function id(): string
    {
        return __CLASS__;
    }
}
