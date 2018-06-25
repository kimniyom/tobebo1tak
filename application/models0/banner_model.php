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
class banner_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function get_banner() {
        $this->db->cache_on();
        $this->db->select("*");
        $this->db->from("banner");
        $this->db->where("status","1");
        $this->db->order_by("id", "ASC");

        $query = $this->db->get();

        return $query;
    }

}
