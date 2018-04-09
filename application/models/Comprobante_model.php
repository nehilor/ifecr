<?php

class Comprobante_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getComprobante($clave) {
        $query = $this->db
                ->get_where('comprobante', ['clave' => $clave]);
        return $query->last_row();
    }

    function saveComprobante($arrayData) {
        $lastId = 0;
        if ($this->db->insert('comprobante', $arrayData)) {
            $lastId = $this->db->insert_id();
        }
        return $lastId;
    }

    function updateComprobante($clave, $arrayData) {
        $this->db->where('clave', $clave);
        return $this->db->update('comprobante', $arrayData);
    }

}
