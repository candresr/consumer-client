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

class Siab
{
    private $clientRest;

    private $plantilla = array(
        'tipoAlistamiento' => null,
        'ciudadServicio' => null,
        'direccionInmueble' => null,
        'barrioInmueble' => null,
        'nombreContacto' => null,
        'telefonoContacto' => null,
        'tipoInmueble' => null,
        'estadoInmueble' => null,
        'nitInmobiliaria' => null,
        'nombreInmobiliaria' => null,
        'nombreConsultor' => null,
        'telefonoConsultor' => null,
        'nombrePersonaFactura' => null,
        'numeroDocumentoPersonaFactura' => null,
        'direccionPersonaFactura' => null,
        'numeroCotizacion' => null,
        'comisionInmobiliaria' => null,
        'descripcionComision' => null,
        'correoElectronicoContacto' => null,
        'correoInmobiliaria' => null,
        'correoPersonaFactura' => null,
        'latitudInmueble' => null,
        'longitudinmueble' => null,
        'nombreCliente' => null,
        'nombreContactoInmobiliaria' => null,
        'numeroContactoInmobiliaria' => null
    );
    public function __construct($data = []){
        $this->clientRest = new Client();
    }

    function crearCaso($option = []){

        $url  = AlmArray::get($option, 'url');
        $function  = AlmArray::get($option, 'function');

        $soap_request = $this->buildXml($option['data']);

        $out = fopen('php://output', 'w');
        $ch = curl_init($url.$function);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $soap_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $response = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        fclose($out);

        if($httpcode>=200 && $httpcode<300) return $response;
        else return false;

    }

    /**
     * Construye el xml para crear caso
     * @param $data
     */
    private function buildXml($data = []){

        $data = array_merge($this->plantilla, $data);

        $soap_request  = "<?xml version=\"1.0\"?>\n";
        $soap_request .= "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ws=\"http://ws.ciencuadras.siab.asistenciabolivar.com.co/\">\n";
        $soap_request .= "<soapenv:Header/>\n";
        $soap_request .= "<soapenv:Body>\n";
        $soap_request .= "<ws:crearCasoCiencuadras>\n";
        $soap_request .= "<datosCaso>\n";
        $soap_request .= "<tipoAlistamiento>{{tipoAlistamiento}}</tipoAlistamiento>\n";
        $soap_request .= "<ciudadServicio>{{ciudadServicio}}</ciudadServicio>\n";
        $soap_request .= "<direccionInmueble>{{direccionInmueble}}</direccionInmueble>\n";
        $soap_request .= "<barrioInmueble>{{barrioInmueble}}</barrioInmueble>\n";
        $soap_request .= "<nombreContacto>{{nombreContacto}}</nombreContacto>\n";
        $soap_request .= "<telefonoContacto>{{telefonoContacto}}</telefonoContacto>\n";
        $soap_request .= "<tipoInmueble>{{tipoInmueble}}</tipoInmueble>\n";
        $soap_request .= "<estadoInmueble>{{estadoInmueble}}</estadoInmueble>\n";
        $soap_request .= "<nitInmobiliaria>{{nitInmobiliaria}}</nitInmobiliaria>\n";
        $soap_request .= "<nombreInmobiliaria>{{nombreInmobiliaria}}</nombreInmobiliaria>\n";
        $soap_request .= "<nombreConsultor>{{nombreConsultor}}</nombreConsultor>\n";
        $soap_request .= "<telefonoConsultor>{{telefonoConsultor}}</telefonoConsultor>\n";
        $soap_request .= "<nombrePersonaFactura>{{nombrePersonaFactura}}</nombrePersonaFactura>\n";
        $soap_request .= "<numeroDocumentoPersonaFactura>{{numeroDocumentoPersonaFactura}}</numeroDocumentoPersonaFactura>\n";
        $soap_request .= "<direccionPersonaFactura>{{direccionPersonaFactura}}</direccionPersonaFactura>\n";
        $soap_request .= "<numeroCotizacion>{{numeroCotizacion}}</numeroCotizacion>\n";
        $soap_request .= "<comisionInmobiliaria>{{comisionInmobiliaria}}</comisionInmobiliaria>\n";
        $soap_request .= "<descripcionComision>{{descripcionComision}}</descripcionComision>\n";
        $soap_request .= "<correoElectronicoContacto>{{correoElectronicoContacto}}</correoElectronicoContacto>\n";
        $soap_request .= "<correoInmobiliaria>{{correoInmobiliaria}}</correoInmobiliaria>\n";
        $soap_request .= "<correoPersonaFactura>{{correoPersonaFactura}}</correoPersonaFactura>\n";
        $soap_request .= "<latitudInmueble>{{latitudInmueble}}</latitudInmueble>\n";
        $soap_request .= "<longitudinmueble>{{longitudinmueble}}</longitudinmueble>\n";
        $soap_request .= "<nombreCliente>{{nombreCliente}}</nombreCliente>\n";
        $soap_request .= "<nombreContactoInmobiliaria>{{nombreContactoInmobiliaria}}</nombreContactoInmobiliaria>\n";
        $soap_request .= "<numeroContactoInmobiliaria>{{numeroContactoInmobiliaria}}</numeroContactoInmobiliaria>\n";
        $soap_request .= "</datosCaso>\n";
        $soap_request .= "</ws:crearCasoCiencuadras>\n";
        $soap_request .= "</soapenv:Body>\n";
        $soap_request .= "</soapenv:Envelope>\n";

        foreach ($data as $key => $value){
            $pattern = sprintf("/\{\{%s\}\}/", $key);
            $soap_request = preg_replace($pattern, $value, $soap_request);

        }

        return $soap_request;
    }

    public function estadoCaso($option)
    {
        $url  = AlmArray::get($option, 'url');
        $function  = AlmArray::get($option, 'function');

        try {
            $res = $this->clientRest->post($url . $function, [
                'json' => $option['data']
            ]);
            return json_decode($res->getBody()->getContents(),true);
        } catch (\Exception $e) {

            return false;
        }
    }

}