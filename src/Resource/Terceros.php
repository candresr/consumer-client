<?php
/**
 * Created by PhpStorm.
 * User: nomada
 * Date: 28/01/19
 * Time: 11:05 AM
 */

namespace ConsumerClient\Resource;

use ConsumerClient\Util\AlmArray;
use GuzzleHttp\Client;

class Terceros{

    private $client;
    public function __construct()
    {
        $this->client = new Client();
    }

    public function gestionTerceros($data){

        $url = AlmArray::get($data, 'url');
        $function = AlmArray::get($data, 'function');

        try {
            $res = $this->client->post($url . $function, [
                'json' => $data['info']
            ]);
            return json_decode($res->getBody()->getContents(), true);
        }catch (\Exception $e) {

            return false;
        }
    }
}