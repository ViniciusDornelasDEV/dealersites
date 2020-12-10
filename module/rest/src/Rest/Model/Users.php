<?php

namespace Rest\Model;
use Application\Model\BaseTable;
use Zend\Db\Sql\Predicate\Expression;

class Users Extends BaseTable {
  public function getUsersByParams($params){
    return $this->getTableGateway()->select(function($select) use ($params) { 
      $select->join(
              array('a' => 'users_acess'),
              'a.users_id = users.id',
              array('acess_count' => new Expression('COUNT(a.users_id)')),
              'LEFT'
          );

      $select->group('users.id');

      if(isset($params['name']) && !empty($params['name'])){
         $select->where->like('name', '%'.$params['name'].'%');
      }

      if(isset($params['start_date']) && !empty($params['start_date'])){
         $select->where('a.last_login >= "'.parent::dateFormat($params['start_date'])." 00:00:00".'"');
      }

      if(isset($params['end_date']) && !empty($params['end_date'])){
         $select->where('a.last_login <= "'.parent::dateFormat($params['end_date'])." 23:59:59".'"');
      }

      //order and limit, if num login filter param limit = 10
      if(isset($params['login_filter']) && !empty($params['login_filter'])){
          if($params['login_filter'] == 1){
            $select->order('acess_count DESC');
          }else{
            $select->order('acess_count ASC');
          }
          $select->limit(10);
      }else{
        $select->order('users.name '.$params['order']);
        if(isset($params['page_size']) && !empty($params['page_size'])){
          $offset = ($params['page_size']*$params['current_page']) - $params['page_size'];

          $select->limit((int)$params['page_size'])
               ->offset((int)$offset);
        }
      }

    });
  }

  public function getUsersCountByParams($params){
    return $this->getTableGateway()->select(function($select) use ($params) { 
      $select->columns(array());
      $select->join(
              array('a' => 'users_acess'),
              'a.users_id = users.id',
              array('acess_count' => new Expression('COUNT(a.users_id)')),
              'LEFT'
          );

      $select->group('users.id');

      if(isset($params['name']) && !empty($params['name'])){
         $select->where->like('name', '%'.$params['name'].'%');
      }

      if(isset($params['start_date']) && !empty($params['start_date'])){
         $select->where('a.last_login >= "'.parent::dateFormat($params['start_date'])." 00:00:00".'"');
      }

      if(isset($params['end_date']) && !empty($params['end_date'])){
         $select->where('a.last_login <= "'.parent::dateFormat($params['end_date'])." 23:59:59".'"');
      }

      //order and limit, if num login filter param limit = 10
      if(isset($params['login_filter']) && !empty($params['login_filter'])){
          if($params['login_filter'] == 1){
            $select->order('acess_count DESC');
          }else{
            $select->order('acess_count ASC');
          }
          $select->limit(10);
      }else{
        $select->order('users.name ASC');
        if(isset($params['page_size']) && !empty($params['page_size'])){
          $offset = ($params['page_size']*$params['current_page']) - $params['page_size'];
        }
      }

    })->count();
  }


}
