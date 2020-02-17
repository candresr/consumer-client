<?php
/**
 * Created by PhpStorm.
 * User: nomada
 * Date: 30/01/19
 * Time: 09:56 AM
 */

namespace ConsumerClient\Resource;
use ConsumerClient\Util\AlmArray;
use GuzzleHttp\Client;


class Construdata
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function listarCategorias($data){

        $url = AlmArray::get($data, 'url');
        $function = AlmArray::get($data, 'function');
        $token = AlmArray::get($data, 'token');

        try{
            $res = $this->client->get($url . $function, [
                'query' => $data
            ]);
            return  json_decode($res->getBody()->getContents(), true);
        } catch (\Exception $e) {

            return false;
        }
    }

    public function crearCotizacion($data){

        $url = AlmArray::get($data, 'url');
        $function = AlmArray::get($data, 'function');

        try {
            $res = $this->client->post($url . "Cotizacion/" . $function, [
                'query' => $data['data']
            ]);
            return json_decode($res->getBody()->getContents(), true);
        }catch (\Exception $e) {

            return false;
        }
    }

    public function editarCotizacion($data){

        $url = AlmArray::get($data, 'url');
        $function = AlmArray::get($data, 'function');

        try {
            $res = $this->client->patch($url . "Cotizacion/" . $function, [
                'query' => $data['data']
            ]);
            return json_decode($res->getBody()->getContents(), true);
        }catch (\Exception $e) {

            return false;
        }
    }

    public function agregarCantidad($data){

        $url = AlmArray::get($data, 'url');
        $function = AlmArray::get($data, 'function');
        $idCotizacion =  AlmArray::get($data, 'idCotizacion');

        try {
            $res = $this->client->post($url . "Cotizacion/" . $idCotizacion . "/" . $function, [
                'query' => $data['data']
            ]);
            return json_decode($res->getBody()->getContents(), true);
        }catch (\Exception $e) {

            return false;
        }
    }

    public function consultarCotizacion($data){

        $url = AlmArray::get($data, 'url');
        $idCotizacion =  AlmArray::get($data, 'idCotizacion');

        try {
            $res = $this->client->get($url . "Cotizacion/" . $idCotizacion, [
                'query' => $data['data']
            ]);
            return json_decode($res->getBody()->getContents(), true);
        }catch (\Exception $e) {

            return false;
        }
    }
}