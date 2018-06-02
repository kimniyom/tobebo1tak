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
 * @company : AsbWeb 2017
 * @create  : 24 มิ.ย. 2560 13:01:33
 * 
 */
class modulemanager_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function Get_moduleAll() {
        $query = "SELECT * FROM module ORDER BY id asc";
        return $this->db->query($query);
    }

    function Get_module_By_id($id = '') {
        $query = "SELECT * FROM module WHERE id = '$id' ";
        return $this->db->query($query)->row();
    }
    
    function Get_moduleActive() {
        $query = "SELECT * FROM module WHERE active = 'Y' ORDER BY id asc";
        return $this->db->query($query);
    }


}
