<?php

namespace ConsumerClient;

use ConsumerClient\Util\AlmArray;
use ConsumerClient\Util\AlmDate;
use ConsumerClient\Util\AlmValidator;
use GuzzleHttp\Client;

class Auth {

    private $sessionPath = "/var/session";
    private $client;
    private $url;
    private $username;
    private $password;
    private $identificacion;
    public $access_token;

    /**
     * @return null
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param null $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @return string
     */
    public function getSessionPath()
    {
        return $this->sessionPath;
    }


    public function __construct($data){

        $this->url = AlmArray::get($data, 'url');
        $this->username = AlmArray::get($data, 'username');
        $this->password = AlmArray::get($data, 'password');
        $this->identificacion = AlmArray::get($data, 'identificacion');
        $this->client = new Client();
    }

    public function isValid($token){

        try {
            $res = $this->client->get($this->url . "/autenticacion/IsValid", [
                'query' => array(
                    'token' => $token
                )
            ]);
            return json_decode($res->getBody()->getContents(), true);
        }catch (\Exception $e) {

            return false;
        }
    }

    public function auth()
    {
        try {
            $res = $this->client->post($this->url . "/Autentication", [
                'query' => array(
                    'identificacion' => $this->identificacion,
                    'nombreusuario' => $this->username,
                    'clave' => $this->password
                )
            ]);
            $this->createToken($res);
            return true;
        }catch (\Exception $e) {

            return false;
        }
    }
    public function createToken($res){

        $result = json_decode($res->getBody()->getContents(), true);

        if (!file_exists(__DIR__.'/'.$this->sessionPath)){
            mkdir(__DIR__.'/var',0777);
            chmod(__DIR__.'/var',0777);
        }

        $token = $result; //['Resultado']['Token'];
        AlmArray::saveToFile($token, __DIR__.'/'.$this->sessionPath);

        $this->setAccessToken($this->loadToken());
    }



    public function loadToken(){

        $token = AlmArray::loadFromFile( __DIR__.'/'.$this->sessionPath);

        $this->access_token = AlmArray::get($token['Resultado'], 'Token');
        return $this->access_token;

    }
}