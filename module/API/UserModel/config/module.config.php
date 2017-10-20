<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 19/10/2017 12:18
 */

namespace API\UserModel;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            Storage\Db\UserDbStorage::class => Storage\Db\UserDbStorageFactory::class,
            Repository\UserRepositoryInterface::class => Repository\UserRepositoryFactory::class,
        ]
    ],

    'hydrators' => [
        'factories' => [
            Hydrator\UserHydrator::class => InvokableFactory::class
        ]
    ]
];