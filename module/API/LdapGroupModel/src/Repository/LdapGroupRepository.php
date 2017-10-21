<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 20:09
 */

namespace API\LdapGroupModel\Repository;


use API\LdapGroupModel\Storage\Ldap\LdapGroupLdapStorage;

class LdapGroupRepository implements LdapGroupRepositoryInterface
{
    /**
     * @var LdapGroupLdapStorage
     */
    private $ldapGroupStorage;

    /**
     * @param LdapGroupLdapStorage $ldapGroupStorage
     */
    public function setLdapGroupStorage($ldapGroupStorage)
    {
        $this->ldapGroupStorage = $ldapGroupStorage;
    }

    public function getUserByDn($dn)
    {
        return $this->ldapGroupStorage->searchForDn($dn);
    }

    public function searchUser($query, $filter)
    {
        return $this->ldapGroupStorage->search($query, $filter);
    }


}