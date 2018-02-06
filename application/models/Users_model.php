<?php

Class Users_model extends CI_Model {

    function getUsers() {
        $sql = "SELECT * FROM users";
        $query = $this->db->query($sql);
        return $query->result();
    }

}
