<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 20:10
 */

namespace API\LdapGroupModel\Repository;


use API\LdapGroupModel\Storage\Ldap\LdapGroupLdapStorage;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class LdapGroupRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $repository = new LdapGroupRepository();
        $repository->setLdapGroupStorage(
            $container->get(LdapGroupLdapStorage::class)
        );

        return $repository;
    }
}