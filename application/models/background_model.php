<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class background_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function count() {
        return $this->db->count_all("background");
    }

    // Fetch data according to per_page limit.
    public function get_data() {
        $sql = "SELECT *
      FROM background 
      ORDER BY id ASC";
        return $this->db->query($sql);
    }

    // Fetch data according to per_page limit.
    public function fetch_data($limit, $start) {
        if ($start != '') {
            $pagestart = $start;
        } else {
            $pagestart = 0;
        }
        $sql = "SELECT *
      FROM background 
      LIMIT $pagestart,$limit";
        return $this->db->query($sql);
    }

    public function get_bg_color() {
        $this->db->select("*");
        $this->db->from("background_color");
        $query = $this->db->get();
        return $query;
    }

    public function background_active() {
        $sql = "SELECT background
                FROM background 
                WHERE active = '1' ";
        $rs = $this->db->query($sql)->row();

        if (!empty($rs)) {
            $img = base_url() . "upload_images/bg/" . $rs->background;
            $bg = "
            background: url($img) no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;";
        } else {
            $sql = "SELECT color
                FROM background_color 
                WHERE active = '1' ";
            $rs = $this->db->query($sql)->row();
            $color = $rs->color;
            $bg = "background:$color;";
        }
        return $bg;
    }

    public function background_active_backend() {
        $sql = "SELECT background
                FROM background 
                WHERE active = '1' ";
        $rs = $this->db->query($sql)->row();

        if (!empty($rs)) {
            $color = $rs->background;
        } else {
            $sql = "SELECT color
                FROM background_color 
                WHERE active = '1' ";
            $rs = $this->db->query($sql)->row();
            $color = $rs->color;
        }
        return $color;
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
