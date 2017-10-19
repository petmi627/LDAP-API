<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 18/10/2017 12:13
 */

namespace API\LdapUserModel\Storage\Ldap;


use API\LdapUserModel\Hydrator\LdapUserHydrator;
use Interop\Container\ContainerInterface;
use Zend\Config\Config;
use Zend\Ldap\Ldap;
use Zend\ServiceManager\Factory\FactoryInterface;

class LdapUserLdapStorageFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $options = $config['ldap'];

        $storage = new LdapUserLdapStorage();
        $storage->setLdap(new Ldap($options));
        $storage->setHydrator(new LdapUserHydrator());

        return $storage;
    }
}