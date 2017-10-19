<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 18/10/2017 11:24
 */

namespace API\LdapUserModel;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            Storage\Ldap\LdapUserLdapStorage::class => Storage\Ldap\LdapUserLdapStorageFactory::class,
            Repository\LdapUserRepositoryInterface::class => Repository\LdapUserRepositoryFactory::class,
        ]
    ],

    'hydrators' => [
        'factories' => [
            Hydrator\LdapUserHydrator::class => InvokableFactory::class,
        ]
    ]
];