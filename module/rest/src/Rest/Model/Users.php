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

      $select->order('users.name ASC');
      $select->group('users.id');
      
      if(isset($params['name']) && !empty($params['name'])){
         $select->where->like('name', '%'.$params['name'].'%');
      }

      if(isset($params['start_date']) && !empty($params['start_date'])){
         $select->where('a.last_login >= ?', $params['start_date']);
      }

      if(isset($params['end_date']) && !empty($params['end_date'])){
         $select->where('a.last_login <= ?', $params['end_date']);
      }

      if(isset($params['page_size']) && !empty($params['page_size'])){
        $offset = ($params['page_size']*$params['current_page']) - $params['page_size'];

        $select->limit((int)$params['page_size'])
             ->offset((int)$offset);
      }

    });
  }


}
