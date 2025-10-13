<?php

namespace CAS\Service\Controller;

use CAS\Controller\SloController;
use CAS\Session\TicketStorage;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class SloControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        return new SloController(
            $services->get(TicketStorage::class),
            $services->get('Omeka\Logger')
        );
    }
}

