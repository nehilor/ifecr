<?php

class Token_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getToken($user) {
        $query = $this->db
                ->get_where('token', ['user' => $user]);
        return $query->last_row();
    }
    function saveToken($arrayData) {
        $lastId = 0;
        if( $this->db->insert('token', $arrayData) ) {
            $lastId = $this->db->insert_id();
        }
        return $lastId;
    }
}
