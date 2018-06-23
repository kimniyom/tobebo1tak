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

    public function DetilUser($id){
        $sql = "select u.*,t.type as typename 
                from tobe_user u inner join tobe_user_type t on u.type = t.id
                where u.id = '$id'";
        $result = $this->db->query($sql)->row();
        return $result;
    }


}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
