<?php
return array(
    'router' => array(
        'routes' => array(
            'restUsers' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/rest/users',
                    'defaults' => array(
                        'controller' => 'Rest\Controller\Rest',
                        'action'     => 'users',
                    ),
                ),
            ),
            'restTotalUsers' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/rest/users/total',
                    'defaults' => array(
                        'controller' => 'Rest\Controller\Rest',
                        'action'     => 'totalusers',
                    ),
                ),
            ),
            
        ),
    ),

	'controllers' => array(
        'invokables' => array(
            'Rest\Controller\Rest' => 'Rest\Controller\RestController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
                'ViewJsonStrategy',
        ),
    ),
    
);