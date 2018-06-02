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
 * @create  : 24 ม.ค. 2559 21:47:33
 * @Write From Thailand
 */
class homepage_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function get_menu() {
        $this->db->select("menu_homepage.*,type_homepage.style");
        $this->db->from("menu_homepage");
        $this->db->join('type_homepage', 'type_homepage.id = menu_homepage.type_id');
        $this->db->where("menu_homepage.active", "0");
        $this->db->order_by("menu_homepage.level", "ASC");

        $query = $this->db->get();

        return $query;
    }

    function get_menu_where($Id = null) {
        $this->db->select("menu_homepage.*,type_homepage.style");
        $this->db->from("menu_homepage");
        $this->db->join('type_homepage', 'type_homepage.id = menu_homepage.type_id');
        $this->db->where("menu_homepage.active", "0");
        $this->db->where("menu_homepage.id", "$Id");

        $query = $this->db->get();

        return $query;
    }

    function get_subhomepage_where($Id = null) {
        $this->db->select("id,title AS title_name");
        $this->db->from("sub_homepage");
        $this->db->where("id", "$Id");

        $query = $this->db->get();

        return $query;
    }

    function get_type() {
        $this->db->select("*");
        $this->db->from("type_homepage");

        $query = $this->db->get();

        return $query;
    }

    

}
