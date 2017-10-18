<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 18/10/2017 12:54
 */

namespace API\LdapUserModel\Repository;


use API\LdapUserModel\Storage\Ldap\LdapUserLdapStorage;

class LdapUserRepository implements LdapUserRepositoryInterface
{
    /**
     * @var LdapUserLdapStorage
     */
    private $ldapUserStorage;

    /**
     * @param mixed $ldapUserStorage
     */
    public function setLdapUserStorage($ldapUserStorage)
    {
        $this->ldapUserStorage = $ldapUserStorage;
    }

    public function getUserByCn($cn)
    {
        return $this->ldapUserStorage->searchForCn($cn);
    }
}