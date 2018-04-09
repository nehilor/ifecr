<?php

class General_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getPais() {
        $query = $this->db
                ->get_where('pais');
        return $query->result();
    }

    function getProvincia() {
        $query = $this->db
                ->get_where('provincia');
        return $query->result();
    }

    function getCanton($codigo) {
        $query = $this->db->get_where('canton', ['codigoProvincia' => $codigo]);
        return $query->result();
    }

    function getDistrito($codigoP, $codigoC) {
        $query = $this->db->get_where('distrito', ['codigoProvincia' => $codigoP, 'codigoCanton' => $codigoC]);
        return $query->result();
    }

    function getBarrio($codigoP, $codigoC, $codigoD) {
        $query = $this->db->get_where('barrio', ['codigoProvincia' => $codigoP, 'codigoCanton' => $codigoC, 'codigoDistrito' => $codigoD]);
        return $query->result();
    }

    function getCondicionVenta() {
        $query = $this->db
                ->get_where('condicion_venta');
        return $query->result();
    }

    function getDocumentoExoneracion() {
        $query = $this->db
                ->get_where('documento_exoneracion_autorizacion');
        return $query->result();
    }

    function getDocumentoReferencia() {
        $query = $this->db
                ->get_where('documento_referencia');
        return $query->result();
    }

    function getImpuesto() {
        $query = $this->db
                ->get_where('impuesto');
        return $query->result();
    }

    function getMedioPago() {
        $query = $this->db
                ->get_where('medio_pago');
        return $query->result();
    }

    function getMoneda() {
        $query = $this->db
                ->get_where('moneda');
        return $query->result();
    }

    function getReferencia() {
        $query = $this->db
                ->get_where('referencia');
        return $query->result();
    }

    function getTipoIdentificacion() {
        $query = $this->db
                ->get_where('tipo_identificacion');
        return $query->result();
    }

}
