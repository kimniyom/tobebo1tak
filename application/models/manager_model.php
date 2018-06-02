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
 * @create  : 28 ธ.ค. 2560 16:01:33
 *
 */
class manager_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function get_manager() {
        $this->db->cache_on();
        $this->db->select("*");
        $this->db->from("manager");
        $this->db->where("id","1");
        $this->db->order_by("id", "ASC");

        $query = $this->db->get();

        return $query;
    }

}

?>
