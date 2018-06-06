<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class report_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function GetreportAmphur($occupation=null,$changwat = 63){
        if($occupation){
            $where = " r.occupation='$occupation'";
        } else {
            $where = "1=1";
        }
    	$sql = "SELECT d.ampurcodefull,d.ampurname,IFNULL(Q.total,0) AS total
				FROM campur d 
				LEFT JOIN 
				(
					SELECT r.ampur,COUNT(*) AS total
					FROM tobe_register r 
                    WHERE $where
					GROUP BY r.ampur
				) Q ON d.ampurcodefull = Q.ampur 
                WHERE d.changwatcode = '$changwat'";
		return $this->db->query($sql);
    }

    function GetreportType(){
    	$sql = "SELECT d.id,d.name,IFNULL(Q.total,0) AS total
                FROM tobe_occupation d 
                LEFT JOIN 
                (
                    SELECT r.occupation,COUNT(*) AS total
                    FROM tobe_register r INNER JOIN tobe_occupation o ON r.occupation = o.id
                    WHERE o.upper = ''
                    GROUP BY r.occupation
                ) Q ON d.id = Q.occupation
                WHERE d.upper = '' ";
		return $this->db->query($sql);
    }

    
    function GetreportList($type = null,$amphur = null,$office = null){
        $sql = "SELECT *
                FROM tobe_register r 
                WHERE r.type = '$type' AND r.ampur = '$amphur' AND r.office = '$office' ";
        return $this->db->query($sql);
    }

    function CountAll(){
    	$result = $this->db->get("tobe_register");
    	return $result->num_rows();
    }

    function CountType($occupation = null,$amphur = null){
        if($amphur){
            $where = " ampur = '$amphur'";
        } else {
            $where = "1=1";
        }
        $sql = "select IFNULL(count(*),0) as total from tobe_register where occupation='$occupation' AND $where";
        $rs = $this->db->query($sql)->row();
        return $rs->total;
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
