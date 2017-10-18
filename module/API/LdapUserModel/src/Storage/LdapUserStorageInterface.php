<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 18/10/2017 12:10
 */

namespace API\LdapUserModel\Storage;


interface LdapUserStorageInterface
{
    public function searchForCn($cn);
}