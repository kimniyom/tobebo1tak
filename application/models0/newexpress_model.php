<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author  : kimniyom
 * @company : Takmoph 2016
 * @create  : 17 ม.ค. 255ต 16:01:33
 *
 */
class newexpress_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function get_express() {
        $this->db->cache_on();
        $this->db->select("*");
        $this->db->from("new_express");
        $this->db->order_by("id", "desc");

        $query = $this->db->get();

        return $query;
    }

    function get_detail($Id = null) {
        $this->db->select("*");
        $this->db->from("new_express");
        $this->db->where("id", "$Id");
        $query = $this->db->get();

        return $query;
    }

}
