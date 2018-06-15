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
        /*
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
                */
                $sql = "SELECT d.id,d.typename,IFNULL(Q.total,0) AS total
                        FROM tobe_type d 
                        LEFT JOIN 
                        (
                            SELECT o.type,COUNT(*) AS total
                            FROM tobe_register r INNER JOIN tobe_occupation o ON r.occupation = o.id
                            WHERE o.type != ''
                            GROUP BY o.type
                        ) Q ON d.id = Q.type";
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

    function CountAlcohol($changwat = '63'){
        $sql = "SELECT a.id,a.alcohol,IFNULL(Q.total,0) AS total
                FROM tobe_alcohol a 
                LEFT JOIN (
                        SELECT r.alcohol,COUNT(*) AS total
                        FROM tobe_register r 
                        WHERE (r.alcohol != '' OR r.alcohol IS NOT NULL) AND r.changwat = '$changwat'
                        GROUP BY r.alcohol
                ) Q ON a.id = Q.alcohol ";
        return $this->db->query($sql);
    }

    function CountSmoking($changwat = '63'){
        $sql = "SELECT a.id,a.smoking,IFNULL(Q.total,0) AS total
                FROM tobe_smoking a 
                LEFT JOIN (
                    SELECT r.smoking,COUNT(*) AS total
                    FROM tobe_register r 
                    WHERE (r.smoking != '' OR r.smoking IS NOT NULL) AND r.changwat = '$changwat'
                    GROUP BY r.smoking
                ) Q ON a.id = Q.smoking";
        return $this->db->query($sql);
    }

    function CountReason($changwat = '63'){
        $sql = "SELECT SUM(IF(r.reason='1',1,0)) as reason1,
                        SUM(IF(r.reason='2',1,0)) as reason2
                FROM tobe_register r 
                WHERE (r.smoking != '' OR r.smoking IS NOT NULL) AND r.changwat = '$changwat'";
        return $this->db->query($sql)->row();
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
