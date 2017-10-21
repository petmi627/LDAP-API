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
     * @var array
     */
    private $url;

    /**
     * @param mixed $userStorage
     */
    public function setUserStorage($userStorage)
    {
        $this->userStorage = $userStorage;
    }

    /**
     * @param array $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
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

    public function createEntityFromData(array $data = [])
    {
        $entity = new UserEntity();
        $entity->setUsername($data["username"]);
        $entity->setLanguage($data["language"]);
        $entity->setCreated(new \DateTime());
        $entity->setModified(new \DateTime());

        return $entity;
    }

    public function getUserUrls($username, $baseUrl = null)
    {
        if (get_headers($this->url["base_avatar_url"] . $username . ".jpg")[0] != 'HTTP/1.1 404 Not Found') {
            $data['avatar'] = $this->url["base_avatar_url"] . $username . ".jpg";
        } else {
            $data['avatar'] = $baseUrl . "/img/no-user.jpg";
        }

        if (get_headers($this->url["base_profile_url"] . $username)[0] != 'HTTP/1.1 404 Not Found') {
            $data['profile'] = $this->url["base_profile_url"] . $username;
        }

        return $data;
    }
}