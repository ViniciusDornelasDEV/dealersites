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

    //get total users
    $totalUsers = $this->getServiceLocator()->get('Users')->getUsersCountByParams($params);
    
    //if selected page is greater than total pages, set current page
    $totalPages = (int)($totalUsers/$params['page_size']);

    if($params['current_page'] > $totalPages){
      $params['current_page'] = $totalPages;
    }

    if($params['current_page'] == 0){
      $params['current_page'] = 1;
    }

    //get users
    $users = $this->getServiceLocator()->get('Users')->getUsersByParams($params)->toArray();
    $users['total'] = $totalUsers;
    return new JsonModel($users);
  }

}

