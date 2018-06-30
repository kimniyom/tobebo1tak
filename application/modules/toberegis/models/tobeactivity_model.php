<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tobeactivity_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function get_activity_user($userID) {
        $this->db->where("user_id", $userID);
        $result = $this->db->get("tobe_activity");
        return $result;
    }

    function get_images_activity($activity_id) {
        $sql = "select * from tobe_activity_images where activity_id = '$activity_id' ";
        $result = $this->db->query($sql);
        return $result;
    }

    function getactivitylast($limit = 10) {
        $sql = "select a.*,u.name,u.lname
                from tobe_activity a inner join tobe_user u ON a.user_id = u.id
                order by id desc limit $limit";
        return $this->db->query($sql);
    }
    
    public function Gettype($type = null){
        $sql = "select * from tobe_user_type where id = '$type'";
        $result = $this->db->query($sql);
        return $result->row();
    }

    public function GettypeAll() {
        $sql = "select * from tobe_user_type where id NOT IN('1','5')";
        $result = $this->db->query($sql);
        return $result;
    }

    function countgroup($typeID = null) {
        if($typeID){
            $WHERE = "type = '$typeID'";
        } else {
            $WHERE = "1=1";
        }
        $sql = "SELECT COUNT(*) AS TOTAL FROM tobe_activity WHERE $WHERE";
        $rs = $this->db->query($sql)->row();
        return $rs->TOTAL;
    }
    
    // Fetch data according to per_page limit.
    public function fetch_data_group($limit, $start, $type) {
        if ($start != '') {
            $pagestart = $start;
        } else {
            $pagestart = 0;
        }
        if($type != ''){
            $where = "n.type = '$type'";
        } else {
            $where = "1=1";
        }
        $sql = "SELECT n.*,m.name,m.lname
                FROM tobe_activity n INNER JOIN tobe_user m ON n.user_id = m.id
                WHERE $where
                ORDER BY n.date DESC
                LIMIT $pagestart,$limit";
        return $this->db->query($sql);
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
