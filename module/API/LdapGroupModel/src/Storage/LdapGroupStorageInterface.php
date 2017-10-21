<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 19:23
 */

namespace API\LdapGroupModel\Storage;


interface LdapGroupStorageInterface
{
    public function searchForDn($dn);
}