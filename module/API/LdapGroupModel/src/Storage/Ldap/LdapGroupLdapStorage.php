<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 19:27
 */

namespace API\LdapGroupModel\Storage\Ldap;


use API\LdapGroupModel\Entity\LdapGroupEntity;
use API\LdapGroupModel\Hydrator\LdapGroupHydrator;
use API\LdapGroupModel\Storage\LdapGroupStorageInterface;
use Zend\Ldap\Ldap;

class LdapGroupLdapStorage implements LdapGroupStorageInterface
{
    /**
     * @var Ldap
     */
    private $ldap;

    /**
     * @var LdapGroupHydrator
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
            $entity = new LdapGroupEntity();
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
            '(&(objectClass=group)('.$filter.'=*'.$query.'*))'
        );

        if (count($result) > 0) {
            foreach ($result as $item) {
                $entity = new LdapGroupEntity();
                $array[] = $this->hydrator->hydrate($item, $entity);
            }

            return $array;
        } else {
            return null;
        }
    }
}