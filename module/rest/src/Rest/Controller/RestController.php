<?php

namespace Rest\Controller;

use Zend\View\Model\JsonModel;
use Zend\Session\Container;
use Zend\Mvc\Controller\AbstractRestfulController;

use Rest\Classes\JwtAdapter;


class RestController extends AbstractRestfulController
{

  public function usersAction(){
    //check if JWT token is valid
    $JwtAdapter = new JwtAdapter();

  $decoded = $JwtAdapter->decodeToken($_SERVER["HTTP_AUTHORIZATION"]);
    if($decoded == 'Token expired' || $decoded->sub != 'd3@l3rProcess0'){
      return new JsonModel(array('error' => 'Token inválido!'));
    }

    //get app params
    $params = $this->getRequest()->getPost();

    //get users
    $users = $this->getServiceLocator()->get('Users')->getUsersByParams($params);
    
    return new JsonModel($users->toArray());
  }

  public function totalusersAction(){
    //check if JWT token is valid
    $JwtAdapter = new JwtAdapter();
    $decoded = $JwtAdapter->decodeToken($_SERVER["HTTP_AUTHORIZATION"]);

    if($decoded == 'Token expired' || $decoded->sub != 'd3@l3rProcess0'){
      return new JsonModel(array('error' => 'Token inválido!'));
    }

    //get users
    $users = $this->getServiceLocator()->get('Users')->getUsersByParams(array());
    
    return new JsonModel(array('numUsers' => $users->count()));
  }

}

