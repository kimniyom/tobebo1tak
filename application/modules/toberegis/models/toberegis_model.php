<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class toberegis_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function Type() {
        return $this->db->get("tobe_type");
    }

    function TypeRow($id) {
        $this->db->where("id",$id);
        $query = $this->db->get("tobe_type");
        return $query->row();
    }

    function Amphur() {
        return $this->db->get("tobe_district");
    }

    function AmphurRow($id) {
        $this->db->where("distid",$id);
        $query = $this->db->get("tobe_district");
        return $query->row();
    }

    function GetOffice($table,$amphur,$columns){
        $sql = "SELECT $columns FROM $table WHERE distid = '$amphur'";
        return $this->db->query($sql);
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
