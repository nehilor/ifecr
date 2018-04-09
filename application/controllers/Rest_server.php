<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rest_server extends CI_Controller {

    public function index() {
        $this->load->helper('url');
        $this->load->view('rest_server');
        $this->load->library("api");
        $this->load->library("xml");
        $this->load->library("firmado");
    }

    public function token() {

        $json = array(
            'data' =>
            array(
                'tipo' => '1',
                'usuario' => '',
                'clave' => '',
                'tipocedula' => 'juridico',
                'cedula' => '',
                'situacion' => 'normal',
                'codigopais' => '506',
                'consecutivo' => '00100001010000000012',
                'emisor' =>
                array(
                    'tipoidentificacion' => '02',
                    'numeroIdentificacion' => '',
                    'nombre' => '',
                    'nombreComercial' => '',
                    'provincia' => '4',
                    'canton' => '01',
                    'distrito' => '02',
                    'barrio' => '06',
                    'OtrasSenas' => 'Cualquier direccion',
                    'telefono' => '22306763',
                    'codigopaistelefono' => '506',
                    'correo' => 'usuario@email.com',
                ),
                'receptor' =>
                array(
                    'tipoidentificacion' => '02',
                    'numeroIdentificacion' => '3102651429',
                    'nombre' => 'Dynamis-soft',
                    'nombreComercial' => 'Dynamis-soft',
                    'provincia' => '1',
                    'canton' => '08',
                    'distrito' => '01',
                    'barrio' => '13',
                    'OtrasSenas' => 'Cualquier direccion',
                    'telefono' => '22306763',
                    'codigopaistelefono' => '506',
                    'correo' => 'usuario@email.com',
                ),
                'CondicionVenta' => '01',
                'MedioPago' => '01',
                'detalles' =>
                array(
                    0 =>
                    array(
                        'numero' => '1',
                        'codigodescripcion' => '2',
                        'codigotipo' => '01',
                        'cantidad' => '1',
                        'unidad' => 'Unid',
                        'detalle' => 'Soda',
                        'preciounitario' => '500',
                        'montototal' => '500',
                        'montodescuento' => '0',
                        'descripciondescuento' => 'ninguno',
                        'subtotal' => '500.00000',
                        'totallinea' => '565.00000',
                        'codigoimpuesto' => '01',
                        'tarifaimpuesto' => '13',
                        'montoimpuesto' => '65.00000'
                    )
                ),
                'codigomoneda' => 'CRC',
                'totalservgravados' => '0.00000',
                'totalservexentos' => '0.00000',
                'totalmercanciasgravadas' => '500.00000',
                'totalmercanciasexentas' => '0.00000',
                'totalgravado' => '500.00000',
                'totalexento' => '0.00000',
                'totalventa' => '500.00000',
                'totaldescuentos' => '0.0',
                'totalventaneta' => '500.00000',
                'totalImpuesto' => '65.00000',
                'totalcomprobante' => '565.00000',
                'referencia' => ""
            )
        );
        //api-stag  api-prod
        $data = $json['data'];
        $tokenObjeto = $this->token_model->getToken($data['usuario']);
        if (!empty($tokenObjeto)) {
                $token = $this->api->token("api-stag", "refresh_token", $data['usuario'], $data['clave'], $tokenObjeto->token);
                $token = $token->access_token;
            if (empty($token = $token->access_token)) {
                $token = $this->api->token("api-stag", "password", $data['usuario'], $data['clave'], "");
                $token = $token->access_token;
                $this->token_model->saveToken(['user' => $data['usuario'], 'token' => $token]);
            }
        } else {
            $token = $this->api->token("api-stag", "password", $data['usuario'], $data['clave'], "");
            $token = $token->access_token;
            $this->token_model->saveToken(['user' => $data['usuario'], 'token' => $token]);
        }


          $clave = $this->api->getClave($data['tipocedula'], $data['cedula'],  $data['situacion'], $data['codigopais'], $data['consecutivo']);
          date_default_timezone_set('America/Costa_Rica');
          $fecha = date('c');
          $xml = $this->xml->crearXml($clave, $fecha, $data);
          $xmlfirmado ='assets/firmado/';
          $key = "assets/310170884332.p12";
          $this->firmado->firmar($key,"2401", $xml, $xmlfirmado, $clave);
          //shell_exec("java -jar assets/xadessignercr.jar $key 2010 $xml ../ruta_personalizada/demo-factura-firmada.xml");
          $xml = file_get_contents($xmlfirmado.$clave.".xml");
          $comprobanteXml = $this->api->encode($xml);
          echo $this->api->enviar($clave, $fecha, $data['emisor']['tipoidentificacion'], $data['emisor']['numeroIdentificacion'], $data['receptor']['tipoidentificacion'], $data['receptor']['numeroIdentificacion'], $comprobanteXml, $token);
          echo "<br>";
          echo "<br>";
          $response = $this->api->consultar($clave,$token);
          $this->comprobante_model->saveComprobante(['clave' => $response['clave'], 'estado' => $response['ind-estado']]);

    }

}
