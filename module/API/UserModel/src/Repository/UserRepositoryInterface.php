<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 20/10/2017 15:21
 */

namespace API\UserModel\Repository;


use API\UserModel\Entity\UserEntity;

interface UserRepositoryInterface
{
    public function getUsers();

    public function getUser(array $whereIsEqualTo = []);

    public function saveUser(UserEntity $entity);

    public function deleteUser(UserEntity $entity);
}