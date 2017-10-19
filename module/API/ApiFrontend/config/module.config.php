<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 18/10/2017 13:39
 */

namespace API\ApiFrontend;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'api' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/api/user[/:id]',
                    'defaults' => [
                        'controller' => Controller\RestController::class
                    ]
                ]
            ]
        ]
    ],

];