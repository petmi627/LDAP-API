<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 18/10/2017 13:45
 */

namespace API\ApiFrontend\Controller;


use API\LdapUserModel\Hydrator\LdapUserHydrator;
use API\LdapUserModel\Repository\LdapUserRepositoryInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserRestControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $hydratorManager = $container->get('HydratorManager');

        $controller = new UserRestController();
        $controller->setLdapUserRepository(
            $container->get(LdapUserRepositoryInterface::class)
        );
        $controller->setLdapUserHydrator(
            $hydratorManager->get(LdapUserHydrator::class)
        );

        return $controller;
    }
}