<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 18/10/2017 11:24
 */

namespace API\LdapUserModel;

return [
    'service_manager' => [
        'factories' => [
            Storage\Ldap\LdapUserLdapStorage::class => Storage\Ldap\LdapUserLdapStorageFactory::class,
        ]
    ]
];