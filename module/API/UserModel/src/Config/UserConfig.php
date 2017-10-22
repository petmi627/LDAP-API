<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 21:24
 */

namespace API\UserModel\Config;


use Zend\Config\Config;

class UserConfig extends Config implements UserConfigInterface
{
    public function getLanguageOptions()
    {
        return $this->get('language_options')->toArray();
    }
}