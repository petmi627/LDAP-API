<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 19/10/2017 13:06
 */

namespace API\UserModel\Storage\Db;


use API\UserModel\Entity\UserEntity;
use API\UserModel\Hydrator\UserHydrator;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserDbStorageFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter = $container->get(Adapter::class);

        $resultSetPrototype = new HydratingResultSet(
            new UserHydrator(),
            new UserEntity()
        );

        $tableGateway = new TableGateway(
            'users',
            $dbAdapter,
            null,
            $resultSetPrototype
        );

        $storage = new UserDbStorage($tableGateway);

        return $storage;
    }
}