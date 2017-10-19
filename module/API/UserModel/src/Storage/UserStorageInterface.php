<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 19/10/2017 13:01
 */

namespace API\UserModel\Storage;


use API\UserModel\Entity\UserEntity;

interface UserStorageInterface
{
    public function fetchAll();

    public function fetchEntity(array $whereIsEqualTo = []);

    public function insertEntity(UserEntity $entity);

    public function updateEntity(UserEntity $entity);

    public function deleteEntity(UserEntity $entity);
}