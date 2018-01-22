<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 18/10/2017 12:12
 */

namespace API\LdapUserModel\Storage\Ldap;


use API\LdapUserModel\Entity\LdapUserEntity;
use API\LdapUserModel\Hydrator\LdapUserHydrator;
use API\LdapUserModel\Storage\LdapUserStorageInterface;
use Zend\Ldap\Ldap;

class LdapUserLdapStorage implements LdapUserStorageInterface
{
    /**
     * @var Ldap
     */
    private $ldap;

    /**
     * @var LdapUserHydrator
     */
    private $hydrator;

    /**
     * @param mixed $ldap
     */
    public function setLdap(Ldap $ldap)
    {
        $this->ldap = $ldap;
    }

    /**
     * @param mixed $hydrator
     */
    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function searchForDn($dn)
    {
        $this->ldap->bind();
        $result = $this->ldap->getEntry($dn);

        if (count($result) > 0) {
            $entity = new LdapUserEntity();
            $this->hydrator->hydrate($result, $entity);
        } else {
            $entity = null;
        }

        return $entity;
    }

    public function search($query, $filter)
    {
        $this->ldap->bind();
        $result = $this->ldap->search(
            '(&(objectClass=person)('.$filter.'=*'.$query.'*))'
        );

        if (count($result) > 0) {
            foreach ($result as $item) {
                $entity = new LdapUserEntity();
                $array[] = $this->hydrator->hydrate($item, $entity);
            }

            return $array;
        } else {
            $entity = null;
            return $entity;
        }
    }

    public function getUserByUsername($username)
    {
        $this->ldap->bind();
        $result = $this->ldap->search(
            '(&(objectClass=person)(sAMAccountName='.$username.'))'
        );

        if (count($result) > 0) {
            $entity = new LdapUserEntity();
            foreach ($result as $item) {
                $entity = $this->hydrator->hydrate($item, $entity);
            }
        } else {
            $entity = null;
        }

        return $entity;
    }
}