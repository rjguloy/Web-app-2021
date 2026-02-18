<?php

//application/libraries/CreatorJwt.php

require APPPATH . '/libraries/JWT.php';

class CreatorJwt
{
   

    /*************This function generate token private key**************/ 

    PRIVATE $key = "tDU4V0JfAh3OP17gHjVeXXT6jVctnTqhh4xcwEwWHP5uuWIpyljdFsp1OzYvLMrF"; 
    public function GenerateToken($data)
    {          
        $jwt = JWT::encode($data, $this->key);
        return $jwt;
    }
    

   /*************This function DecodeToken token **************/

    public function DecodeToken($token)
    {          
        $decoded = JWT::decode($token, $this->key, array('HS256'));
        $decodedData = (array) $decoded;
        return $decodedData;
    }
}