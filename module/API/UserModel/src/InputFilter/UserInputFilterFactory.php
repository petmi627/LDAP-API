<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 21:40
 */

namespace API\UserModel\InputFilter;


use API\UserModel\Config\UserConfigInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserInputFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get(UserConfigInterface::class);

        $inputFilter = new UserInputFilter();
        $inputFilter->setLanguageOptions(
            $config->getLanguageOptions()
        );

        return $inputFilter;
    }
}