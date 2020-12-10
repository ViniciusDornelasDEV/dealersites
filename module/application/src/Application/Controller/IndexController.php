<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\BaseController;
use Zend\View\Model\ViewModel;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Session\Container;

use Rest\Classes\JwtAdapter;

class IndexController extends BaseController
{
  private $token;
  public function __construct(){
    $container = new Container();
    //check if token exists
    $JwtAdapter = new JwtAdapter();
    if(!isset($container['token']) || empty($container['token'])){
      //generate token
      $container['token'] = $JwtAdapter->generateToken('d3@l3rProcess0');
    }

    //if token expired, generate new token
    $decoded = $JwtAdapter->decodeToken($container['token']);
    if($decoded == 'Token expired'){
      $container['token'] = $JwtAdapter->generateToken('d3@l3rProcess0');
    }

    $this->token = $container['token'];
  }

  public function indexAction(){
    
    return new ViewModel(array(
      'token'   =>  $this->token
    ));
  }

  //gerar um novo token 
  public function generatetokenAction(){
    $container = new Container();
    $JwtAdapter = new JwtAdapter();
    $token = $JwtAdapter->generateToken('d3@l3rProcess0');
    
    $view = new ViewModel();
    $view->setTerminal(true);
    $view->setVariables(array('token' => $token));
    return $view;
    
  }

}