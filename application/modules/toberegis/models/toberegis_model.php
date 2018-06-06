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
        $sql = "select * from tobe_occupation where upper = '' ";
        return $this->db->query($sql);
    }

    function TypeRow($id) {
        $this->db->where("id",$id);
        $query = $this->db->get("tobe_occupation");
        return $query->row();
    }

    function Amphur($changwat = 63) {
        $sql = "select * from campur where changwatcode = '$changwat' ";
        return $this->db->query($sql);
    }

    function AmphurRow($id) {
        $this->db->where("ampurcodefull",$id);
        $query = $this->db->get("campur");
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
