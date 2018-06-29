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

    function get_activity_user($userID){
    	$this->db->where("user_id",$userID);
    	$result = $this->db->get("tobe_activity");
    	return $result;
    }

    function get_images_activity($activity_id){
    	$sql = "select * from tobe_activity_images where activity_id = '$activity_id' ";
    	$result = $this->db->query($sql);
    	return $result;
    }
}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
