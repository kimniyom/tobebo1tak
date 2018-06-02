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

    function GetreportAmphur($type = null){
        if($type){
            $where = " r.type='$type'";
        } else {
            $where = "1=1";
        }
    	$sql = "SELECT d.distid,d.distname,IFNULL(Q.total,0) AS total
				FROM tobe_district d 
				LEFT JOIN 
				(
					SELECT r.ampur,COUNT(*) AS total
					FROM tobe_register r 
                    WHERE $where
					GROUP BY r.ampur
				) Q ON d.distid = Q.ampur ";
		return $this->db->query($sql);
    }

    function GetreportType(){
    	$sql = "SELECT d.id,d.typename,d.icons,IFNULL(Q.total,0) AS total
				FROM tobe_type d 
				LEFT JOIN 
				(
					SELECT r.type,COUNT(*) AS total
					FROM tobe_register r 
					GROUP BY r.type
				) Q ON d.id = Q.type ";
		return $this->db->query($sql);
    }

    function GetreportOffice($type = null,$amphur = null){
        $TypeModel = new toberegis_model();
        $TypeDetail = $TypeModel->TypeRow($type);
        $tables = $TypeDetail->tables;
        $fields = $TypeDetail->fields;
        $relation = $tables.".".$TypeDetail->relation."=Q.office";
        $sql = "SELECT $fields,IFNULL(Q.total,0) AS total
                FROM $tables
                LEFT JOIN 
                (
                    SELECT r.office,COUNT(*) AS total
                    FROM tobe_register r 
                    WHERE r.type = '$type' AND r.ampur = '$amphur'
                    GROUP BY r.office
                ) Q ON $relation";
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

    function CountType($type = null,$amphur = null){
        if($amphur){
            $where = " ampur = '$amphur'";
        } else {
            $where = "1=1";
        }
        $sql = "select IFNULL(count(*),0) as total from tobe_register where type='$type' AND $where";
        $rs = $this->db->query($sql)->row();
        return $rs->total;
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
