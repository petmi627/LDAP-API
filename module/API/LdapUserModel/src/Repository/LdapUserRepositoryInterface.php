<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 18/10/2017 12:55
 */

namespace API\LdapUserModel\Repository;


interface LdapUserRepositoryInterface
{
    public function getUserByDn($dn);
}