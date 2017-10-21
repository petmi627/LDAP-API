<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 20:37
 */

namespace API\ApiFrontend\Controller;


use API\LdapGroupModel\Hydrator\LdapGroupHydrator;
use API\LdapGroupModel\Repository\LdapGroupRepositoryInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class GroupRestControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $hydratorManager = $container->get('HydratorManager');

        $controller = new GroupRestController();
        $controller->setLdapGroupRepository(
            $container->get(LdapGroupRepositoryInterface::class)
        );
        $controller->setLdapGroupHydrator(
            $hydratorManager->get(LdapGroupHydrator::class)
        );

        return $controller;
    }
}