<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class users_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
        $this->load->library('takmoph_libraries');
    }

    public function typeuser(){
    	return $this->db->get("tobe_user_type");
    }

    public function DetilUser($id){
        $sql = "select u.*,t.type as typename 
                from tobe_user u inner join tobe_user_type t on u.type = t.id
                where u.id = '$id'";
        $result = $this->db->query($sql)->row();
        return $result;
    }

    public function Checkprivilege($user_id){
        $sql = "select * from tobe_user_privilege where user_id = '$user_id'";
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            return 1;
        } else {
            return 0;
        }
    }

    function login($username) {
        $this->db->select("*");
        $this->db->from("tobe_user");
        $this->db->where("username", $username);
        $this->db->limit("1");
        $query = $this->db->get();
        return $query->row();
    }

    function check_password($password_input = null, $password = null) {
        //$p_input = md5($password_input);
        $p_input = $password_input;
        if ($p_input == $password) {
            $verify = "1";
        } else {
            $verify = "0";
        }

        return $verify;
    }

    function auth($Id = null) {
        $this->db->select("*");
        $this->db->from("tobe_user");
        $this->db->where("id", $Id);
        $this->db->limit("1");
        $query = $this->db->get();
        $row = $query->row();

        $data = array(
            'tobe_name' => $row->name,
            'tobe_lname' => $row->lname,
            'tobe_type' => $row->type,
            'tobe_username' => $row->username,
            'tobe_user_id' => $row->id
        );
        $this->session->set_userdata($data);

        $log = array(
            "username" => $row->username,
            "user_id" => $row->id,
            "password" => $row->password,
            "ip" => $this->input->ip_address(),
            "status" => "True",
            "d_date" => date("Y-m-d H:i:s")
        );
        $this->db->insert("tobe_log_login", $log);
    }

    function savelog_login_flase($username = null, $password = null) {
        $log = array(
            "username" => $username,
            "user_id" => "",
            "password" => $password,
            "ip" => $this->input->ip_address(),
            "status" => "False",
            "d_date" => date("Y-m-d H:i:s")
        );
        $this->db->insert("tobe_log_login", $log);
    }

     public function Getlocation($userID,$type){
        $changwat = $this->takmoph_libraries->Setchangwat();
        if($type == "1"){
            $sql = "SELECT p.*,a.ampurname as locationname
                FROM tobe_user_privilege p 
                INNER JOIN campur a ON p.ampur = a.ampurcodefull
                WHERE p.user_id = '$userID' AND a.changwatcode = '$changwat' ";
        } else if($type == "4"){
            $sql = "SELECT p.*,a.tambonname as locationname
                FROM tobe_user_privilege p 
                INNER JOIN ctambon a ON p.privilege = a.tamboncodefull AND p.ampur = a.ampurcodefull
                WHERE p.user_id = '$userID' AND a.changwatcode = '$changwat' ";
        } else {
            $sql = "SELECT p.*,o.name as locationname
                FROM tobe_user_privilege p INNER JOIN tobe_occupation o ON p.privilege = o.id
                WHERE p.user_id = '$userID' ";
        }

        $result = $this->db->query($sql);
        $rs = $result->row();
        return $rs->locationname;

    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
