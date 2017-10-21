<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 19:27
 */

namespace API\LdapGroupModel\Storage\Ldap;


use API\LdapGroupModel\Hydrator\LdapGroupHydrator;
use Interop\Container\ContainerInterface;
use Zend\Ldap\Ldap;
use Zend\ServiceManager\Factory\FactoryInterface;

class LdapGroupLdapStorageFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $options = $config['ldap'];

        $storage = new LdapGroupLdapStorage();
        $storage->setLdap(new Ldap($options));
        $storage->setHydrator(new LdapGroupHydrator());

        return $storage;
    }
}