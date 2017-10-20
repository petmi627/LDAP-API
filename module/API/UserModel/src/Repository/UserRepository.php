<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 20/10/2017 15:21
 */

namespace API\UserModel\Repository;


use API\UserModel\Entity\UserEntity;
use API\UserModel\Storage\Db\UserDbStorage;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var UserDbStorage
     */
    private $userStorage;

    /**
     * @param mixed $userStorage
     */
    public function setUserStorage($userStorage)
    {
        $this->userStorage = $userStorage;
    }

    public function getUsers()
    {
        return $this->userStorage->fetchAll();
    }

    public function getUser(array $whereIsEqualTo = [])
    {
        return $this->userStorage->fetchEntity($whereIsEqualTo);
    }

    public function saveUser(UserEntity $entity)
    {
        if (!$entity->getId()) {
            return $this->userStorage->insertEntity($entity);
        } else {
            return $this->userStorage->updateEntity($entity);
        }
    }

    public function deleteUser(UserEntity $entity)
    {
        return $this->userStorage->deleteEntity($entity);
    }
}