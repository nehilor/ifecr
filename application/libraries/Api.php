<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api {

    function token($client_id, $grant_type, $username, $password, $refresh_token) {
        //GET URL from Post    
        $url = "https://idp.comprobanteselectronicos.go.cr/auth/realms/rut-stag/protocol/openid-connect/token";
        $data;
        if ($grant_type == "password") {
            $data = array(
                'client_id' => $client_id,
                'client_secret' => "",
                'grant_type' => $grant_type,
                'username' => $username,
                'password' => $password
            );
        } else if ($grant_type == "refresh_token") {
            $data = array(
                'client_id' => $client_id,
                'client_secret' => "",
                'grant_type' => $grant_type,
                'refresh_token' => $refresh_token
            );
        }
        //Making the options
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);        
        $result = file_get_contents($url, false, $context);
        $ar = json_decode($result);
        return $ar;
    }

    function consultar($clave, $token) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.comprobanteselectronicos.go.cr/recepcion-sandbox/v1/recepcion/" . $clave,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $token,
                "Cache-Control: no-cache",
                "Content-Type: application/x-www-form-urlencoded",
                "Postman-Token: bf8dc171-5bb7-fa54-7416-56c5cda9bf5c"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "CURL Error #:" . $err;
        } else {
            $responseT = json_decode($response, true);
            return $responseT;
        }
    }

    //Se envia w = XmlToBase64 
    function encode($xml) {
        $result = base64_encode($xml);
        return $result;
    }

    //  CREAR CLAVE
    function getClave($tipoCedula, $cedula, $situacion, $codigoPais, $consecutivo) {
        //-----------------------------------------------//
        $dia = date('d');
        $mes = date('m');
        $ano = date('y');

        //-----------------------------------------------//
        $value="";
        switch ($tipoCedula) {
            case 'fisico': //fisico
                $value = "000" . $cedula;
                break;
            case 'juridico': // juridico
                $value = "00" . $cedula;
                break;
        }
        //Numero de Cedula + el indice identificador
        $identificacion = $value;

        //-----------------------------------------------//
        //1	Normal	Comprobantes electrónicos que son generados y transmitidos en el mismo acto de compra-venta y prestación del servicio al sistema de validación de comprobantes electrónicos de la Dirección General de Tributación de Costa Rica.
        //2	Contingencia	Comprobantes electrónicos que sustituyen al comprobante físico emitido por contingencia.
        //3	Sin internet	Comprobantes que han sido generados y expresados en formato electrónico, pero no se cuenta con el respectivo acceso a internet para el envío inmediato de los mismos a la Dirección General de Tributación de Costa Rica.
        switch ($situacion) {
            case 'normal': //fisico
                $situacion = 1;
                break;
            case 'contingencia': // juridico
                $situacion = 2;
                break;
            case 'sininternet': //dimex
                $situacion = 3;
                break;
        }

        //-----------------------------------------------//     
        //Crea la clave 
        $clave = $codigoPais . $dia . $mes . $ano . $identificacion . $consecutivo . $situacion;
        while(strlen($clave)<50){
            $clave .="9";
        }
        return $clave;
    }

    function enviar($clave, $fecha, $emi_tipoIdentificacion, $emi_numeroIdentificacion, $recp_tipoIdentificacion, $recp_numeroIdentificacion, $comprobanteXml, $token) {

        $datos = array(
            'clave' => $clave,
            'fecha' => $fecha,
            'emisor' => array(
                'tipoIdentificacion' => $emi_tipoIdentificacion,
                'numeroIdentificacion' => $emi_numeroIdentificacion
            ),
            'receptor' => array(
                'tipoIdentificacion' => $recp_tipoIdentificacion,
                'numeroIdentificacion' => $recp_numeroIdentificacion
            ),
            'comprobanteXml' => $comprobanteXml
        );
        //print_r($datos);
        $mensaje = json_encode($datos);
        echo $mensaje;
        echo "<br>";
        $header = array(
            'Authorization: bearer ' . $token,
            'Content-Type: application/json'
        );
        echo $token."<br>";
        echo "<br>";
        //echo $mensaje;
        $curl = curl_init("https://api.comprobanteselectronicos.go.cr/recepcion-sandbox/v1/recepcion");
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
        $respuesta = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return $respuesta . "Esto" . $status;
    }

}
