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