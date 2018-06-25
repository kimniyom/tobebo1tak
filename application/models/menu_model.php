<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class menu_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function get_mas_menu($id) {
        $sql = "SELECT m.*,i.icon
                    FROM mas_menu m LEFT JOIN menu_icon i ON m.icon_id = i.icon_id
                    WHERE m.id = '$id' ";
        return $this->db->query($sql)->row();
    }

    //ดึงข้อมูลไฟล์มาแสดง
    function get_filemenu_system($id = '') {
        $sql = "SELECT * FROM dengue WHERE admin_menu_id = '$id' ORDER BY id DESC";
        return $this->db->query($sql);
    }

    function get_color($colormenu = null) {
        if ($colormenu == 's') {
            $color = 'btn btn-default btn-block';
            $bg = "bg-info";
        } else if ($colormenu == 'g') {
            $color = 'btn btn-success btn-block';
            $bg = "bg-success";
        } else if ($colormenu == 'o') {
            $color = 'btn btn-warning btn-block';
            $bg = " bg-warning";
        } else if ($colormenu == 'r') {
            $color = 'btn btn-danger btn-block';
            $bg = "bg-danger";
        } else if ($colormenu == 'b') {
            $color = 'btn btn-primary btn-block';
            $bg = "bg-primary";
        }

        return $color;
    }

    function get_detail_menu($id = "") {
        $sql = "SELECT m.*,i.icon
                    FROM mas_menu m LEFT JOIN menu_icon i ON m.icon_id = i.icon_id
                    WHERE m.admin_menu_id = '$id' ";
        $Q1 = $this->db->query($sql)->row();
        if(!empty($Q1)){
            $result = $Q1;
        } else {
            $sql2 = "SELECT admin_menu_name AS mas_menu,admin_menu_images AS icon FROM admin_menu WHERE  admin_menu_id = '$id'" ;
            $result = $this->db->query($sql2)->row();
        }
        
        return $result;
    }
    
    function getmenubyid($id = null){
        $this->db->select("*");
        $this->db->from("sub_menu");
        $this->db->where("sub_id",$id);
        
        $query = $this->db->get()->row();
        return $query;
    }
    
    function getgroupmenubyid($id = null){
        $this->db->select("*");
        $this->db->from("mas_menu");
        $this->db->where("id",$id);
        
        $query = $this->db->get()->row();
        return $query;
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

