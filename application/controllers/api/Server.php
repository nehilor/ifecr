<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Server extends REST_Controller {

    function __construct() {
        parent::__construct();
    }

    /* APIS GENERALES */

    public function pais_post() {
        $paises = $this->general_model->getProvincia();
        if (!empty($paises)) {
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $paises
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Datos vacios",
                'data' => $paises
            ];
        }

        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function provincia_post() {
        $provincia = $this->general_model->getProvincia();
        if (!empty($provincia)) {
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $provincia
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Datos vacios",
                'data' => $provincia
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function canton_post() {
        $data = $this->post('data');
        $canton = $this->general_model->getCanton($data['codigo']);
        if (!empty($canton)) {
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $canton
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Datos vacios",
                'data' => $canton
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function distrito_post() {
        $data = $this->post('data');
        $distrito = $this->general_model->getDistrito($data['codigop'], $data['codigoc']);
        if (!empty($distrito)) {
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $distrito
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Datos vacios",
                'data' => $distrito
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function barrio_post() {
        $data = $this->post('data');
        $barrio = $this->general_model->getBarrio($data['codigop'], $data['codigoc'], $data['codigod']);
        if (!empty($barrio)) {
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $barrio
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Datos vacios",
                'data' => $barrio
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function condicionventa_post() {
        $data = $this->general_model->getCondicionVenta();
        if (!empty($data)) {
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $data
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Datos vacios",
                'data' => $data
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function documentoexoneracion_post() {
        $data = $this->general_model->getDocumentoExoneracion();
        if (!empty($data)) {
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $data
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Datos vacios",
                'data' => $data
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function documentoreferencia_post() {
        $data = $this->general_model->getDocumentoReferencia();
        if (!empty($data)) {
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $data
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Datos vacios",
                'data' => $data
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function impuesto_post() {
        $data = $this->general_model->getImpuesto();
        if (!empty($data)) {
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $data
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Datos vacios",
                'data' => $data
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function mediopago_post() {
        $data = $this->general_model->getMedioPago();
        if (!empty($data)) {
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $data
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Datos vacios",
                'data' => $data
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function moneda_post() {
        $data = $this->general_model->getMoneda();
        if (!empty($data)) {
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $data
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Datos vacios",
                'data' => $data
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function referencia_post() {
        $data = $this->general_model->getReferencia();
        if (!empty($data)) {
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $data
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Datos vacios",
                'data' => $data
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function tipoidentificacion_post() {
        $data = $this->general_model->getTipoIdentificacion();
        if (!empty($data)) {
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $data
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Datos vacios",
                'data' => $data
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function enviar_post() {
        $data = $this->post('data');
        $key = $this->input->get_request_header('key');
        $pin = $this->input->get_request_header('pin');
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
        $clave = $this->api->getClave($data['tipocedula'], $data['cedula'], $data['situacion'], $data['codigopais'], $data['consecutivo']);
        $fecha = date('c');
        $xml = $this->xml->crearXml($clave, $fecha, $data);
        $xmlfirmado = 'assets/firmado/';
        $this->firmado->firmar($key, $pin, $xml, $xmlfirmado, $clave);
        $xml = file_get_contents($xmlfirmado . $clave . ".xml");
        $comprobanteXml = $this->api->encode($xml);
        $this->api->enviar($clave, $fecha, $data['emisor']['tipoidentificacion'], $data['emisor']['numeroIdentificacion'], $data['receptor']['tipoidentificacion'], $data['receptor']['numeroIdentificacion'], $comprobanteXml, $token);
        $response = $this->api->consultar($clave, $token);
        $this->comprobante_model->saveComprobante(['clave' => $response['clave'], 'estado' => $response['ind-estado']]);

        $message = [
            'type' => "success",
            'message' => "Envio de datos",
            'data' => $response['ind-estado']
        ];

        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function consultar_post() {
        $data = $this->post('data');
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
        $response = $this->api->consultar($data['clave'], $token);
        $this->comprobante_model->updateComprobante($data['clave'], ['estado' => $response['ind-estado']]);
        $message = [
            'type' => "success",
            'message' => "Datos vacios",
            'data' => $response['ind-estado']
        ];

        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

}
