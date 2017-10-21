<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 19:14
 */

namespace API\LdapGroupModel\Entity;


class LdapGroupEntity
{
    private $sAMAccountName;
    private $cn;
    private $displayName;
    private $distinguishedName;
    private $mail;
    private $objectClass;
    private $member;
    private $memberOf;

    /**
     * @return mixed
     */
    public function getSAMAccountName()
    {
        return $this->sAMAccountName;
    }

    /**
     * @param mixed $sAMAccountName
     */
    public function setSAMAccountName($sAMAccountName)
    {
        $this->sAMAccountName = $sAMAccountName;
    }

    /**
     * @return mixed
     */
    public function getCn()
    {
        return $this->cn;
    }

    /**
     * @param mixed $cn
     */
    public function setCn($cn)
    {
        $this->cn = $cn;
    }

    /**
     * @return mixed
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param mixed $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * @return mixed
     */
    public function getDistinguishedName()
    {
        return $this->distinguishedName;
    }

    /**
     * @param mixed $distinguishedName
     */
    public function setDistinguishedName($distinguishedName)
    {
        $this->distinguishedName = $distinguishedName;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getObjectClass()
    {
        return $this->objectClass;
    }

    /**
     * @param mixed $objectClass
     */
    public function setObjectClass($objectClass)
    {
        $this->objectClass = $objectClass;
    }

    /**
     * @return mixed
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * @param mixed $member
     */
    public function setMember($member)
    {
        $this->member = $member;
    }

    /**
     * @return mixed
     */
    public function getMemberOf()
    {
        return $this->memberOf;
    }

    /**
     * @param mixed $memberOf
     */
    public function setMemberOf($memberOf)
    {
        $this->memberOf = $memberOf;
    }
}