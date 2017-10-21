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
            'api-user' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/api/user[/:id]',
                    'defaults' => [
                        'controller' => Controller\UserRestController::class
                    ]
                ]
            ],
            'api-group' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/api/group[/:id]',
                    'defaults' => [
                        'controller' => Controller\GroupRestController::class
                    ]
                ]
            ],
        ]
    ],

    'controllers' => [
        'factories' => [
            Controller\UserRestController::class => Controller\UserRestControllerFactory::class,
            Controller\GroupRestController::class => Controller\GroupRestControllerFactory::class,
        ]
    ],

    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];