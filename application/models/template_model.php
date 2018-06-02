<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class template_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    // Fetch data according to per_page limit.
    public function get_template_active() {
        $this->db->cache_on();
        $sql = "SELECT * FROM template WHERE active = '1' LIMIT 1";
        $query = $this->db->query($sql)->row();
        return $query;
    }
    public function get_template() {
        $this->db->cache_on();
        $sql = "SELECT * FROM template WHERE active = '1' LIMIT 1";
        $query = $this->db->query($sql)->row();

        if (!empty($query->template)) {
            //$this->session->set_userdata("pathThemes", "themes/" . $query->template);

            return array(
                "template" => 'template/' . $query->template . '/index',
                "path" => 'themes/' . $query->template
            );
        } else {
            return array("template" => "template2015");
        }
    }

    public function themes() {
        //$themes = $this->get_template();
    }

    public function get_template_setup() {
        $this->db->select("*");
        $this->db->from("template");
        $this->db->order_by("id", "desc");
        $query = $this->db->get();

        return $query;
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
