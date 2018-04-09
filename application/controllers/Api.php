<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('firmado_model', '', TRUE);
    }

    public function createXML(){
        $xml   = new SimpleXMLElement();

    }



    public function getXMLHeader($xml){
        $header = $xml->addChild('FacturaElectronica');
        $header->addAttribute('Clave', $clave);
        $header->addAttribute('NmeroConsecutivo', $numero);     
        $header->addAttribute('FechaEmision', $fecha);  
        $header->addAttribute('Emisor', $emisor);  
        $header->addAttribute('Receptor', $receptor);  
    }



    public function getXML2($clave,$numero,$fecha,$emisor,$receptor,$condiciones,$plazo,$medio) {
        $xml   = new SimpleXMLElement();
        $header = $xml->addChild('FacturaElectronica');
        $header->addAttribute('Clave', $clave);
        $header->addAttribute('NmeroConsecutivo', $numero);     
        $header->addAttribute('FechaEmision', $fecha);  
        $header->addAttribute('Emisor', $emisor);  
        $header->addAttribute('Receptor', $receptor);  
        $header->addAttribute('CondicionVenta', $condiciones);  //01 Contado, 02 CrÃ©dito, 03 ConsignaciÃ³n, 04 Apartado, 05 Arrendamiento con opciÃ³n de compra, 06 Arrendamiento en funciÃ³n financiera, 99 Otros
        $header->addAttribute('PlazoCredito', $plazo);  
        $header->addAttribute('MedioPago', $medio);  //01 Efectivo, 02 Tarjeta, 03 Cheque, 04 Transferencia - depÃ³sito bancario, 05 - Recaudado por terceros, 99 Otros
    
    }


    function makeFinalJson($clave,$emi_tipoIdentificacion,$emi_numeroIdentificacion,$recp_tipoIdentificacion,$recp_numeroIdentificacion,$comprobanteXml){      
        $fecha= date('Y-m-d');
        $response=array();
        $response = array('clave'=>$clave,
                                'fecha'=>$fecha,        
                                'emisor'=>array('tipoIdentificacion'=>$emi_tipoIdentificacion,'numeroIdentificacion'=>$emi_numeroIdentificacion),
                                'receptor'=>array('tipoIdentificacion'=>$recp_tipoIdentificacion,'numeroIdentificacion'=>$recp_numeroIdentificacion),                    
                                'comprobanteXml'=>$comprobanteXml);                            
                            
        return  $response;
    }
    //  CREAR CLAVE
    function getClave($tipoCedula,$cedula,$situacion,$codigoPais,$consecutivo,$codigoSeguridad){
        //-----------------------------------------------//
           $dia = date('d');
           $mes = date('m');
           $ano = date('y');      
        
        //-----------------------------------------------//
        $value;
        switch ($tipoCedula) {
        case 'fisico': //fisico
        $value = "000".$cedula;
        break;
        case 'juridico': // juridico
        $value = "00".$cedula;
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
            $situacion=1;
            break;
            case 'contingencia': // juridico
            $situacion=2;
            break;
            case 'sininternet': //dimex
            $situacion=3;
            break;
       }
       
       //-----------------------------------------------//     
       //Crea la clave 
      $clave = $codigoPais.$dia.$mes.$ano.$identificacion.$consecutivo.$situacion.$codigoSeguridad;
      return $clave;
    }
    //Se envia w = XmlToBase64 
    function encode($xml){
        $result = base64_encode($xml);
        return $result;	
    }
    function consutar($clave,$token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.comprobanteselectronicos.go.cr/recepcion-sandbox/v1/recepcion/".$clave,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ". $token,
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
            $responseT= json_decode($response);
            return $responseT;
        }
    }
    function sign($p12Url,$pinP12,$outXmlUrl){                    
        return $$this->firmado_model->firmar($p12Url, $pinP12,$inXmlUrl,$outXmlUrl );;                         
    }
    
    //grant_type : password or refresh_token
    
    function token($client_id,$grant_type,$username,$password,$refresh_token){
        //GET URL from Post    
        $url = "https://idp.comprobanteselectronicos.go.cr/auth/realms/rut-stag/protocol/openid-connect/token"; 
        $data;
        //Get Data from Post
        if ($grant_type=="password") {
            
            $data = array(
                        'client_id' => $client_id,
                        'client_secret' => "",
                        'grant_type' => $grant_type,
                        'username' => $username,
                        'password' => $password     
                        );
        } 
        else if ($grant_type=="refresh_token") {
                $data = array(
                            'client_id' => $client_id,
                            'client_secret' => "",
                            'grant_type' => $grant_type,
                            'refresh_token' =>  $refresh_token
                );
            }
        //Making the options
            $options = array(
                        'http' => array(
                                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                                    'method'  => 'POST',
                                    'content' => http_build_query($data)
                                            )	
                            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $ar = json_decode($result);
            return $ar;	
    }
    
}
