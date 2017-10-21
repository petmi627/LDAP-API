<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 20:10
 */

namespace API\LdapGroupModel\Repository;


interface LdapGroupRepositoryInterface
{
    public function getUserByDn($dn);

    public function searchUser($query, $filter);
}