<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 19:04
 */

namespace API\LdapGroupModel;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            Storage\Ldap\LdapGroupLdapStorage::class => Storage\Ldap\LdapGroupLdapStorageFactory::class,
            Repository\LdapGroupRepositoryInterface::class => Repository\LdapGroupRepositoryFactory::class
        ]
    ],

    'hydrators' => [
        'factories' => [
            Hydrator\LdapGroupHydrator::class => InvokableFactory::class
        ]
    ],
];