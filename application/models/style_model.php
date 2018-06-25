<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class style_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function get_background(){
      $this->db->select("*");
      $this->db->from("background");
      $this->db->limit("1");

      $query = $this->db->get();

      return $query->row();
    }
}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
