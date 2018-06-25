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
 * @company : Takmoph 2015
 * @create  : 18 พ.ค. 2558 13:01:33
 * 
 */
class complain_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function Get_complainAll() {
        $query = "SELECT * FROM complain ORDER BY d_update DESC";
        return $this->db->query($query);
    }

    function Get_complain_By_id($id = '') {
        $query = "SELECT * FROM complain WHERE id = '$id' ";
        return $this->db->query($query)->row();
    }

}
