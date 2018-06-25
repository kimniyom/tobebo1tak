<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of borderHealth_model
 *
 * @author  : kimniyom
 * @company : Takmoph 2014
 * @create  : 29 พ.ค. 2556 16:01:33
 * 
 */
class formdownload_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function get_mas_from() {
        $sql = "SELECT * 
                FROM mas_from 
                ORDER BY id ASC ";
        return $this->db->query($sql);
    }

    function get_mas_from_where($Id = null) {
        $sql = "SELECT * 
                FROM mas_from 
                WHERE id = '$Id' ";
        return $this->db->query($sql)->row();
    }

    function get_sub_from($mas_id = '') {
        $sql = "SELECT *
                FROM sub_from
                WHERE mas_id = '$mas_id'
                ORDER BY sub_id DESC LIMIT 100";
        return $this->db->query($sql);
    }

    function get_sub_from_where($sub_id = '') {
        $sql = "SELECT *
                FROM sub_from
                    WHERE sub_id = '$sub_id'";
        return $this->db->query($sql)->row();
    }
    
    function get_type_file($type = null){
        if($type == "pdf"){
            $filetype = "<i class='fa fa-file-pdf-o'></i>";
        } else if($type == "doc"){
            $filetype = "<i class='fa fa-file-word-o'></i>";
        } else if($type == "zip" || $type == "rar"){
            $filetype = "<i class='fa fa-file-zip-o'></i>";
        } else if($type == "ppt"){
            $filetype = "<i class='fa fa-file-powerpoint-o'></i>";
        }
        
        return $filetype;
    }

}

?>
