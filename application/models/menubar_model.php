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
class menubar_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function get_style() {
        $this->db->cache_on();
        $this->db->select("*");
        $this->db->from("style");
        $this->db->where("id", "1");
        $this->db->limit("1");

        $query = $this->db->get();

        return $query->row();
    }

    function get_navbarmenu($id) {
        $this->db->cache_on();
        $this->db->select("*");
        $this->db->from("navbarmenu");
        $this->db->where("id", $id);
        //$this->db->limit("1");

        $query = $this->db->get();

        return $query->row();
    }

    function get_navbarmenu_all() {
        $this->db->select("*");
        $this->db->from("navbarmenu");
        $this->db->where("upper","0");
        $this->db->order_by("id", "ASC");
        //$this->db->limit("1");

        $query = $this->db->get();

        return $query;
    }

    function get_sub_navbarmenu($upper = null) {
        $this->db->select("*");
        $this->db->from("navbarmenu");
        $this->db->where("upper",$upper);
        $this->db->order_by("id", "ASC");
        //$this->db->limit("1");

        $query = $this->db->get();

        return $query;
    }

    function get_page($Id = null){
        $this->db->cache_on();
        $this->db->select("*");
        $this->db->from("navbarmenu");
        $this->db->where("id",$Id);
        //$this->db->order_by("id", "ASC");
        //$this->db->limit("1");

        $query = $this->db->get();

        return $query->row();
    }

}
