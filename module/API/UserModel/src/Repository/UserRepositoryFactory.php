<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 20/10/2017 15:22
 */

namespace API\UserModel\Repository;

use API\UserModel\Storage\Db\UserDbStorage;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');

        $repository = new UserRepository();
        $repository->setUserStorage(
            $container->get(UserDbStorage::class)
        );
        $repository->setUrl(
            $config["url"]
        );

        return $repository;
    }
}