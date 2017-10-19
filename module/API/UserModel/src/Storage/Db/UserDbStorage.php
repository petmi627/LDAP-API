<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 19/10/2017 13:06
 */

namespace API\UserModel\Storage\Db;

use API\UserModel\Entity\UserEntity;
use API\UserModel\Hydrator\UserHydrator;
use API\UserModel\Storage\UserStorageInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;

class UserDbStorage implements UserStorageInterface
{
    /**
     * @var TableGatewayInterface | TableGateway
     */
    private $tableGateway;

    /**
     * @var HydratingResultSet
     */
    private $hydratingResultSet;

    /**
     * @var UserHydrator
     */
    private $hydrator;


    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;

        $this->hydratingResultSet = $this->tableGateway->getResultSetPrototype();

        $this->hydrator = $this->hydratingResultSet->getHydrator();
    }

    public function fetchAll()
    {
        $select = $this->tableGateway->getSql()->select();

        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet->buffer();
    }

    public function fetchEntity(array $whereIsEqualTo = [])
    {
        $select = $this->tableGateway->getSql()->select();
        foreach ($whereIsEqualTo as $column => $value) {
            $select->where->equalTo($column, $value);
        }

        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet->current();
    }

    public function insertEntity(UserEntity $entity)
    {
        $insertData = $this->hydrator->extract($entity);

        $insert = $this->tableGateway->getSql()->insert();
        $insert->values($insertData);

        return $this->tableGateway->insertWith($insert) > 0;
    }

    public function updateEntity(UserEntity $entity)
    {
        $updateData = $this->hydrator->extract($entity);

        $update = $this->tableGateway->getSql()->update();
        $update->set($updateData);
        $update->where->equalTo('id', $entity->getId());

        return $this->tableGateway->updateWith($update) > 0;
    }

    public function deleteEntity(UserEntity $entity)
    {
        $delete = $this->tableGateway->getSql()->delete();
        $delete->where->equalTo('id', $entity->getId());

        return $this->tableGateway->deleteWith($delete) > 0;
    }


}