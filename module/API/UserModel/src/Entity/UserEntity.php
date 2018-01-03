<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 19/10/2017 12:48
 */

namespace API\UserModel\Entity;


class UserEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string (en|de|fr|lb)
     */
    private $language;

    /**
     * @var object \DateTime
     */
    private $created;

    /**
     * @var object \DateTime
     */
    private $modified;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        if (!in_array($language, ["en","de","lb","fr"])) {
            $language = "en";
        }

        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $modified
     */
    public function setModified(\DateTime $modified)
    {
        $this->modified = $modified;
    }


}