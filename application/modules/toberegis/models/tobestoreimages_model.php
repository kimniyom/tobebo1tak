<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tobestoreimages_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function count($folederID) {
        $sql = "SELECT COUNT(*) AS total FROM tobestoreimages_list WHERE folder_id = '$folederID' ";
        $rs = $this->db->query($sql)->row();
        return $rs->total;
    }

    public function get_folder_all($user_id) {
        $this->db->select("*");
        $this->db->from("tobestoreimages_folder");
        $this->db->where("user_id", "$user_id");
        $query = $this->db->get();
        return $query;
    }

    public function get_folder_all_type($user_id,$type) {
        $where = array("user_id" => $user_id,"type" => $type);
        $this->db->select("*");
        $this->db->from("tobestoreimages_folder");
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
