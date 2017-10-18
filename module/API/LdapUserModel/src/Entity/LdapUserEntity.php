<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 18/10/2017 11:34
 */

namespace API\LdapUserModel\Entity;


class LdapUserEntity
{
    private $sAMAccountName;
    private $distinguishedName;
    private $cn;
    private $givenName;
    private $sn;
    private $displayName;
    private $title;
    private $description;
    private $department;
    private $o;
    private $physicalDeliveryOfficeName;
    private $co;
    private $mail;
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
    public function getGivenName()
    {
        return $this->givenName;
    }

    /**
     * @param mixed $givenName
     */
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;
    }

    /**
     * @return mixed
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * @param mixed $sn
     */
    public function setSn($sn)
    {
        $this->sn = $sn;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    }

    /**
     * @return mixed
     */
    public function getO()
    {
        return $this->o;
    }

    /**
     * @param mixed $o
     */
    public function setO($o)
    {
        $this->o = $o;
    }

    /**
     * @return mixed
     */
    public function getPhysicalDeliveryOfficeName()
    {
        return $this->physicalDeliveryOfficeName;
    }

    /**
     * @param mixed $physicalDeliveryOfficeName
     */
    public function setPhysicalDeliveryOfficeName($physicalDeliveryOfficeName)
    {
        $this->physicalDeliveryOfficeName = $physicalDeliveryOfficeName;
    }

    /**
     * @return mixed
     */
    public function getCo()
    {
        return $this->co;
    }

    /**
     * @param mixed $co
     */
    public function setCo($co)
    {
        $this->co = $co;
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