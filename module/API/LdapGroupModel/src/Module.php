<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 19:04
 */

namespace API\LdapGroupModel;


use Zend\Config\Factory;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;

class Module implements InitProviderInterface, ConfigProviderInterface
{
    public function init(ModuleManagerInterface $manager)
    {
        if (!defined("LDAP_GROUP_MODEL_MODULE_ROOT")) {
            define("LDAP_GROUP_MODEL_MODULE_ROOT", realpath(__DIR__) . "/..");
        }
    }

    public function getConfig()
    {
        return Factory::fromFile(
            LDAP_GROUP_MODEL_MODULE_ROOT . "/config/module.config.php"
        );
    }
}