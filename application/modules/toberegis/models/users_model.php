<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class users_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    public function typeuser(){
    	return $this->db->get("tobe_user_type");
    }


}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
