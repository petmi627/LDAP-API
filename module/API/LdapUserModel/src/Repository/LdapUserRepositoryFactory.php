<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 18/10/2017 12:54
 */

namespace API\LdapUserModel\Repository;


use API\LdapUserModel\Storage\Ldap\LdapUserLdapStorage;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class LdapUserRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $repository = new LdapUserRepository();
        $repository->setLdapUserStorage(
            $container->get(LdapUserLdapStorage::class)
        );

        return $repository;
    }
}