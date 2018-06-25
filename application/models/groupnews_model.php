<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class groupnews_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function get_groypnews_active() {
        $this->db->cache_on();
        $sql = "SELECT *
                    FROM groupnews N
                    WHERE N.active = '1'
                    ORDER BY N.level ASC ";
        return $this->db->query($sql);
    }

    function get_groupnews_all() {
        $sql = "SELECT *
                    FROM groupnews N
                    ORDER BY N.level ASC";
        return $this->db->query($sql);
    }

    function get_groupnews_where($id = '') {
        $sql = "SELECT *
                    FROM groupnews N
                    WHERE N.id = '$id' ";
        $result = $this->db->query($sql);
        $row = $result->row();
        return $row;
    }
    
    function groupnews_frontent_active(){
        $sql = "SELECT g.* FROM groupnews g WHERE g.active = '1' ORDER BY g.level ASC";
        $result = $this->db->query($sql);
        return $result;
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
