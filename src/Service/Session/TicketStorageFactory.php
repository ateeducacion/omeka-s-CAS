<?php

namespace CAS\Service\Session;

use CAS\Session\TicketStorage;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class TicketStorageFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        $tempDir = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR);
        $basePath = defined('OMEKA_PATH') ? OMEKA_PATH : getcwd();
        $namespace = md5((string) $basePath);
        $storagePath = $tempDir . DIRECTORY_SEPARATOR . 'omeka_s_cas_' . $namespace . '.json';

        return new TicketStorage($storagePath);
    }
}

