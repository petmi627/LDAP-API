<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 18/10/2017 11:17
 */

namespace API\LdapUserModel;


use Zend\Config\Factory;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;

class Module implements ConfigProviderInterface, InitProviderInterface
{
    public function init(ModuleManagerInterface $manager)
    {
        if (!defined("LDAP_USER_MODEL_MODULE_ROOT")) {
            define("LDAP_USER_MODEL_MODULE_ROOT", realpath(__DIR__) . "/..");
        }
    }

    public function getConfig()
    {
        return Factory::fromFile(
            LDAP_USER_MODEL_MODULE_ROOT . "/config/module.config.php"
        );
    }
}