<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class report_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
        $this->load->library('toberegis/tobeconfig');
    }

    function GetreportAmphur($type = null, $changwat = 63) {
        if ($type && $type != '3') {
            $where = " o.type='$type'";
        } else {
            $where = "1=1";
        }
        $sql = "SELECT d.ampurcodefull,d.ampurname,IFNULL(Q.total,0) AS total
				FROM campur d 
				LEFT JOIN 
				(
					SELECT r.ampur,SUM(IF(o.type != '3',1,0)) AS total
					FROM tobe_register r INNER JOIN tobe_occupation o ON r.occupation = o.id
                    WHERE $where
					GROUP BY r.ampur
				) Q ON d.ampurcodefull = Q.ampur 
                WHERE d.changwatcode = '$changwat'";
        return $this->db->query($sql);
    }

    function GetreportType($changwat = 63) {
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
                            SELECT o.type,SUM(IF(o.type != '3',1,0)) AS total
                            FROM tobe_register r INNER JOIN tobe_occupation o ON r.occupation = o.id
                            INNER JOIN campur c ON r.ampur = c.ampurcodefull AND r.changwat = c.changwatcode
                            WHERE o.type != '' AND r.changwat = '$changwat'
                            GROUP BY o.type
                        ) Q ON d.id = Q.type ORDER BY d.order ASC";
        return $this->db->query($sql);
    }

    function GetreportList($type = null, $amphur = null, $office = null) {
        $sql = "SELECT *
                FROM tobe_register r 
                WHERE r.type = '$type' AND r.ampur = '$amphur' AND r.office = '$office' ";
        return $this->db->query($sql);
    }

    function CountAll($changwat = '63') {
        $sql = "select SUM(IF(o.type != '3',1,0)) AS total
                from tobe_register r 
                INNER JOIN tobe_occupation o ON r.occupation = o.id 
                INNER JOIN campur c ON r.ampur = c.ampurcodefull AND r.changwat = c.changwatcode
                where r.changwat = '$changwat' AND (o.type != '' OR o.type IS NOT NULL)";
        $result = $this->db->query($sql)->row();
        return $result->total;
    }

    function CountType($type = '', $amphur = '', $changwat = '63') {
        if ($amphur != "" && $type != '3') {
            $where = " r.ampur = '$amphur' and o.type='$type' and o.type != ''";
         } else if($amphur == "" && $type != '3'){   
             $where = " o.type='$type' and o.type != ''";
        } else {
            $where = "1=1";
        }
        $sql = "select SUM(IF(o.type != '3',1,0)) AS total 
        from tobe_register r 
        INNER JOIN tobe_occupation o ON r.occupation = o.id 
        INNER JOIN campur c ON r.ampur = c.ampurcodefull AND r.changwat = c.changwatcode
        where r.changwat = '$changwat' and $where";
        $rs = $this->db->query($sql)->row();
        return $rs->total;
    }

    function CountAlcohol($changwat = '63') {
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

    function CountSmoking($changwat = '63') {
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

    function CountReason($changwat = '63') {
        $sql = "SELECT SUM(IF(r.reason='1',1,0)) as reason1,
                        SUM(IF(r.reason='2',1,0)) as reason2
                FROM tobe_register r 
                WHERE (r.smoking != '' OR r.smoking IS NOT NULL) AND r.changwat = '$changwat'";
        return $this->db->query($sql)->row();
    }

    function Countpersoninprivilege($privilege = null, $type = null) {
        $changwat = tobeconfig::Getchangwat();
        $sql = "SELECT COUNT(*) AS total
                FROM tobe_register t 
                WHERE t.changwat = '$changwat' AND (t.level3 = '$privilege' OR t.level2 = '$privilege' OR t.occupation = '$privilege')";
        $result = $this->db->query($sql)->row();
        return $result->total;
    }

    function Countpersoninprivilegetambon($privilege = null) {
        $changwat = tobeconfig::Getchangwat();
        $sql = "SELECT COUNT(*) AS total
                FROM tobe_register t 
                WHERE t.changwat = '$changwat' AND t.tambon = '$privilege'";
        $result = $this->db->query($sql)->row();
        return $result->total;
    }

    function Countpersoninprivilegeampur($privilege = null) {
        $changwat = tobeconfig::Getchangwat();
        $sql = "SELECT COUNT(*) AS total
                FROM tobe_register t 
                WHERE t.changwat = '$changwat' AND t.ampur = '$privilege'";
        $result = $this->db->query($sql)->row();
        return $result->total;
    }

    function GetreportLocation($type = null,$ampur = null){
        $changwat = tobeconfig::Getchangwat();
        if($type  == "3"){
            $sql = "SELECT o.tamboncodefull as code,o.`tambonname` as name,IFNULL(Q.total,0) AS total
                    FROM ctambon o
                    LEFT JOIN
                        (
                        SELECT r.tambon,COUNT(*) AS total
                        FROM tobe_register r 
                        WHERE r.changwat = '$changwat' AND r.ampur = '$ampur'
                        GROUP BY r.tambon
                        ) Q ON o.tamboncodefull = Q.tambon
                    WHERE o.changwatcode = '$changwat' AND o.ampurcode = '$ampur' ";
        } else {
            $sql = "SELECT o.id,o.code,o.`name`,IFNULL(Q.total,0) AS total
                    FROM tobe_occupation o

                    LEFT JOIN
                        (
                        SELECT o.name,o.id,COUNT(*) AS total
                        FROM tobe_register r INNER JOIN tobe_occupation o ON r.level2 = o.id
                        WHERE o.type = '$type' AND r.changwat = '$changwat' AND r.ampur = '$ampur' AND o.upper != '0' 
                        GROUP BY o.id
                        ) Q ON o.id = Q.id
                    WHERE o.changwat = '$changwat' AND o.ampur = '$ampur' AND o.upper != '0' AND o.type = '$type' ";        
        }
        return $this->db->query($sql);
    }

    function Getampur(){
        $changwat = tobeconfig::Getchangwat();
        $this->db->where("changwatcode",$changwat);
        $result = $this->db->get("campur");
        return $result;
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
