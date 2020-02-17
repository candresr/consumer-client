<?php


require 'vendor/autoload.php';

use ConsumerClient\Auth;


try{
    
//========= Autenticacion ===================

    $m = new \ConsumerClient\Main();
    $credenciales = array(
        'url' => 'http://157.56.180.214/WebApi/api',
        'username' => 'Admin',
        'password' => '123',
        'identificacion' => 0
    );
    $auth = new Auth($credenciales);


    $res = $auth->auth();
    dump($res);
//    dump($auth->isValid($auth->loadToken()));
//============== Peticiones GET ======================
    $data = array(
        'url' => 'http://157.56.180.214/WebApi/api/general/',
        'function' => 'comisiones',
        'token' => $auth->loadToken(),
        'listaPrecio' => 0,
        'ciudad' => 'BOGOTA'

    );


    $cd = $m->listarCategorias($data);
    dump($cd);

//================== CREAR y EDITAR COTIZACIONES ===========
    $data = array(
        'url' => 'http://157.56.180.214/WebApi/api/general/',
        'function' => 'Editar',
        'data' => array(
            'token' => $auth->getAccessToken(),
            "idCotizacion" => 121,
            "tipoDocumento"=>"cedula",
            "documento"=>13571294,
            "razonSocial"=>"Mazuren",
            "fechaInicio"=>"2018-12-01",
            "fechaFin"=>"2018-12-31",
            "ciudad"=>"Bogota",
            "condicionInmueble"=>"vendido",
            "listaPrecio"=>2,
            "porcIVA"=>19,
            "comisiones"=> 1501,
/*            "comisionesAdicionales"=>json_encode(array(
                [
                    "nombre"=>"ComisionAd 1",
                    "cantidad"=>"10.5",
                    "codigo"=>"1025"
                ],[
                    "nombre"=>"ComisionAd 2",
                    "cantidad"=>"8.2",
                    "codigo"=>"1026"
                ]))*/
        )
    );

//    $gc = $m->editarCotizacion($data);
//    dump($gc);


//============= AGREGAR CANTIDAD ========================
//
    $data = array(
        'url' => 'http://157.56.180.214/WebApi/api/general/',
        'function' => 'agregarCantidad',
        'idCotizacion' => 121,
        'data' => array(
            "token" => $auth->getAccessToken(),
            "idServicio" => 9,
            "cantidad" => 10,
            "observaciones" => "Texto de observacion 121"
        )
    );

//    $ac = $m->agregarCantidad($data);
//    dump($ac);


//============ CONSULTAR COTIZACION =======================
    $data = array(
        'url' => 'http://157.56.180.214/WebApi/api/general/',
        'idCotizacion' => 123,
        'data' => array(
            "token" => $auth->getAccessToken()
        )
    );

//    $ac = $m->consultarCotizacion($data);
//    dump($ac);

 //=================== CREAR CASO SIAB ========================

    $crearcaso = array(
        'url' => 'http://ambientepruebas.asistenciabolivar.com:805/SIAB-Core-CienCuadrasApi-web/',
        'function' => 'crearCaso',
        'data' => array(
            'tipoAlistamiento' => 'cortesia',
            'ciudadServicio' => 14000, //int
            'direccionInmueble' => '123 calle false',
            'barrioInmueble' => 'bronx',
            'nombreContacto' => 'Homero',
            'telefonoContacto' => 1234567890, //int
            'tipoInmueble' => 'casa',
            'estadoInmueble' => 'venta',
            'nitInmobiliaria' => 98765432, //int
            'nombreInmobiliaria' => 'real state',
            'nombreConsultor' => 'Flandres',
            'telefonoConsultor' => 1234567890,
            'nombrePersonaFactura' => 'Bart',
            'numeroDocumentoPersonaFactura' => 2587,
            'direccionPersonaFactura' => '712 Red Bark Lane',
            'numeroCotizacion' => '30',
            'comisionInmobiliaria' => 1, //int
            'descripcionComision' => 'dinero'
//            'correoElectronicoContacto' => '',
//            'correoInmobiliaria' => '',
//            'correoPersonaFactura' => '',
//            'latitudInmueble' => '', //int
//            'longitudinmueble' => '', //int
//            'nombreCliente' => '',
//            'nombreContactoInmobiliaria' => '',
//            'numeroContactoInmobiliaria' => ''
        ));
//    $res = $m->crearCaso($crearcaso);
//    dump($res);


//================== ESTADO CASO SIAB ===============================
    $estadocaso = array(
      'url' => 'http://ambientepruebas.asistenciabolivar.com:805/SIAB-Core-CienCuadrasApi-web/RecursosBolivar/cienCuadras/',
      'function' => 'estadoCaso',
      'data' => array('codigoCaso' => '922288')
    );

//    $res = $m->estadoCaso($estadocaso);
//    dump($res);

//======================= CONSULTA TERCEROS ================================

    $consultaT = array(
        'url' => 'https://ambientepruebas.segurosbolivar.com/TercerosBasicoWS/servicios/',
        'function' => 'consultaJuridicos',
        'info' => array(
            'dataHeader' => array(
                "codUsr"=> "RDUSSAN",
		        "sistemaOrigen" => 9056,
		        "paisISO" => "CO",
                //cambia entre natural y juridico
		        "direccionIp" => "10.1.16.13",
		        "info1"=> "S"
            ),
            'data' => array(
                'datosTercero' => array(
                    "tipoDocumento" => "NT",
			        "numeroDocumento"=> 860057525
                )
            )

        )
    );
//    $res = $m->gestionTerceros($consultaT);
//    dump($res);

//========================= CREAR NATURAL TERCEROS =========================================

    $crearT = array(
        'url' => 'https://ambientepruebas.segurosbolivar.com/TercerosBasicoWS/servicios/',
        'function' => 'crearNatural',
        'info' => array(
            'dataHeader' => array(
                "codUsr"=> "79467856",
                "sistemaOrigen" => 9056,
                "paisISO" => "CO",
                //cambia entre natural y juridico
                "direccionIp" => "10.1.16.13",
                "info1"=> "S"
            ),
            'data' => array(
                'datosTercero' => array(
                    "tipoDocumento" => "CC",
                    "numeroDocumento"=> 13517294
                ),
                'tercerosNaturalInfo' => array(
                    'infoGeneralTerceroNatural' => array(
                        "primerNombre"=> "CESAR",
                        "segundoNombre" => "ANDRES",
                        "primerApellido" => "RAMIREZ",
                        "segundoApellido" => "VANEGAS",
                        "sexo"=> array(
                            "codigo"=> "M"
                        ),
                    "direccionResidencia" => "CARRERA 55 #152B-68",
                    "ciudadResidencia" => "11001",
                    "telefonoResidencia" => "4517625",
                    "celular" => "3125514788",
                    "correoElectronico" => "CARV@HOTMAIL.COM",
                    "autorizaRecibirInf" => "N",
                    "autorizaCompartirInf" => "N"
                    )
                )
            )
        )
    );
//    $res = $m->gestionTerceros($crearT);
//    dump($res);

//========================= CREAR JURIDICO TERCEROS =========================================

    $crearT = array(
        'url' => 'https://ambientepruebas.segurosbolivar.com/TercerosBasicoWS/servicios/',
        'function' => 'crearJuridico',
        'info' => array(
            'dataHeader' => array(
                "codUsr"=> "RDUSSAN",
                "sistemaOrigen" => 9056,
                "paisISO" => "CO",
                //cambia entre natural y juridico
                "direccionIp" => "10.1.16.13",
                "info1"=> "S"
            ),
            'data' => array(
                'datosTercero' => array(
                    "tipoDocumento" => "NT",
                    "numeroDocumento"=> 13517294
                ),
                'tercerosJuridicosInfo' => array(
                    'infoGeneralTerceroJuridico' => array(
                        "razonSocial"=> "INMOBILIARIA CESRA",
				        "direccionOficina" => "CARRERA 55C #161A-21",
				        "ciudadOficina" => "11001",
				        "telefonoOficina" => "6407414",
				        "correoElectronico" => "CORREO@CESRA.COM",
				        "autorizaCompartirInf" => "N",
				        "autorizaRecibirInf" => "N"
                    )
                )
            )
        )
    );
//    $res = $m->gestionTerceros($crearT);
//    dump($res);

} catch (Exception $ex){

    dump($ex->getMessage());
//    die();

}
