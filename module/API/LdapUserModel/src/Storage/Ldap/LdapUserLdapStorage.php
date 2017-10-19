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

    public function searchForCn($cn)
    {
        $this->ldap->bind();
        $result = $this->ldap->getEntry($cn);

        $entity = new LdapUserEntity();

        $this->hydrator->hydrate($result, $entity);

        return $entity;
    }
}