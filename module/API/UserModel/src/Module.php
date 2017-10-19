<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 19/10/2017 12:36
 */

namespace API\UserModel;


use Zend\Config\Factory;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;

class Module implements ConfigProviderInterface, InitProviderInterface
{
    public function init(ModuleManagerInterface $manager)
    {
        if (!defined("USER_MODEL_MODULE_ROOT")) {
            define("USER_MODEL_MODULE_ROOT", realpath(__DIR__) . "/..");
        }
    }

    public function getConfig()
    {
        return Factory::fromFile(
            USER_MODEL_MODULE_ROOT . "/config/module.config.php"
        );
    }
}