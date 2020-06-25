<?php

namespace Loxodonta\CommandBusBundle;

use Loxodonta\CommandBusBundle\DependencyInjection\LoxodontaCommandBusExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class LoxodontaCommandBusBundle
 */
class LoxodontaCommandBusBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new LoxodontaCommandBusExtension();
        }

        return $this->extension;
    }
}
