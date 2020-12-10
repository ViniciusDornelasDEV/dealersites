<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\Request;
use Zend\Http\Client;
use Zend\Stdlib\Parameters;

abstract class BaseController extends AbstractActionController {
    
  private $baseUrl = 'http://dealersites.local/';

  public function requestPOST($url, $params, $jwtToken, $dump = false){
    //set request header
    $request = new Request();
    $request->getHeaders()->addHeaders(array(
        'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
        'Authorization' => $jwtToken
    ));

    //set url, method and parameters 
    $request->setUri($this->baseUrl.$url);
    $request->setMethod('POST');
    $request->setPost(new Parameters($params));

    //send request
    $client = new Client();
    $client->setOptions(array('sslverifypeer' => false, 'sslallowselfsigned' => false));
    $response = $client->dispatch($request);

    //if debug mode print response
    if($dump){
        print_r($response->getBody());
        die();
    }

    //return response
    return json_decode($response->getBody(), true);
  }
}
