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
 * @create  : 26 ม.ค. 2560 16:01:33
 * 
 */
class page_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function getpagebyid($id = null) {
        
        $this->db->select("*");
        $this->db->from("dengue");
        $this->db->where("id",$id);
        //$this->db->order_by("id", "ASC");

        $query = $this->db->get()->row();

        return $query;
    }

}
