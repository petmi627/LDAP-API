<?php

/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 19/10/2017 12:53
 */

namespace API\UserModel\Hydrator;

use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\Strategy\DateTimeFormatterStrategy;

class UserHydrator extends ClassMethods
{
    public function __construct($underscoreSeparatedKeys = true, $methodExistsCheck = false)
    {
        parent::__construct($underscoreSeparatedKeys, $methodExistsCheck);

        $this->addStrategy(
            'created',
            new DateTimeFormatterStrategy('Y-m-d H:i:s')
        );

        $this->addStrategy(
            'modified',
            new DateTimeFormatterStrategy('Y-m-d H:i:s')
        );
    }
}