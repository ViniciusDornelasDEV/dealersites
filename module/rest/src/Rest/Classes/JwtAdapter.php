<?php
namespace Rest\Classes;
use Firebase\JWT\JWT;

class JWTadapter{
	private $secret = '%(*YasarO1#';
	private $iss = 	"Dealer Sites";
	private $decoded;

	public function generateToken($sub){
    try{
      $jwt = JWT::encode(array('sub' => $sub, 'iss' => $this->iss, 'expiration' => strtotime(date("Y-m-d H:i:s", strtotime('+1 hours')))), $this->secret);
      return $jwt;
    }catch (UnexpectedValueException $e) {
      return $e->getMessage();
    }
	}

	public function decodeToken($token){
		try{
      $decoded = JWT::decode($token, $this->secret, array('HS256'));

      if($decoded->expiration < strtotime(date("Y-m-d H:i:s"))){
        return 'Token expired';
      }
			return $decoded;
    }catch (Exception $e) {
        return false;
    }
	}

	public function getDecoded(){
		return $this->decoded;
	}
}

?>

