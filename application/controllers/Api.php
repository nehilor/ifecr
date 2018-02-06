<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('users_model', '', TRUE);
        $this->load->library('session');
    }

    public function getData() {
        $data = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i');
        print_r($data);
    }

    public function getUsers() {
        $data = $this->users_model->getUsers();
        if($data) {
            echo json_encode(array("users" => data));
        } else {
            echo json_encode(array("users" => array()));
        }
    }
}
