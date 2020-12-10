<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Authentication\Storage\Session;
use Zend\Authentication\AuthenticationService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Application\Factory;
use Zend\Session\Container;
use Application\Model\BaseTable;
use Application\Params\Parametros as arrayParams;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {   
      //if HTTP redir to HTTPS
      /*if($_SERVER['SERVER_PORT'] != '443') {
          header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
          exit();
      }*/
      
      ini_set('date.timezone', "America/Sao_Paulo");
      //Config app e service manager
      $this->app = $e->getApplication();
      $this->serviceManager = $this->app->getServiceManager();

      $eventManager        = $e->getApplication()->getEventManager();
      $moduleRouteListener = new ModuleRouteListener();
      $moduleRouteListener->attach($eventManager);

      //handle error
      $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'));
      $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, array($this, 'handleError'));

      //set up some rules here 
      $viewHelperManager = $e->getApplication()->getServiceManager()->get('ViewHelperManager');
      $pluralHelper = $viewHelperManager->get('Plural');
      $pluralHelper->setPluralRule('nplurals=2; plural=(n==1 ? 0 : 1)');

      header('Access-Control-Allow-Origin: *');
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'Application\Validator'
                ),
            ),
        );
    }

    public function getServiceConfig() {

        return array(
            'factories' => array(
                /* DATABASE ADAPTER OBJECTS */
                'db_adapter_factory' => function($sm) {
                    return new Factory\MyAdapterFactory($sm);
                },
                'db_adapter_main' => function($sm) {
                    $factory = $sm->get('db_adapter_factory');
                    $factory->setConfigKey('db');
                    
                    return $factory->createService();
                },
                'session' => function ($sm) {
                    $config = $sm->get('config');
                    if (isset($config['session'])) {
                        $session = $config['session']['config']['options']['name'];
                        
                        //Various Session options
                        $manager = new \Zend\Session\SessionManager();                        
                        
                         if(filter_input(INPUT_SERVER, 'APPLICATION_ENV') === 'production'){
                             
                            $manager->getConfig()
                                    ->setCookieHttpOnly(true)
                                    ->setCookieSecure(false);
                            $manager->start();

                        }
                        
                        return new Session($session);
                    }
                },
            ),
        );
    }

    public function handleError(MvcEvent $event) {
        $result = $event->getResult(); 
        $result->setTerminal(true);
    }
}
