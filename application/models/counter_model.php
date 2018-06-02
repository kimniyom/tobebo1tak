<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author  : kimniyom
 * @company : Takmoph 2016
 * @create  : 17 ม.ค. 255ต 16:01:33
 *
 */
class counter_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function get_user($ip = null,$date = null) {
        $this->db->select("*");
        $this->db->from("counter");
        $this->db->where("ip","$ip");
        $this->db->where("date","$date");
        $query = $this->db->get();
        $row = $query->row();
        if(empty($row)){
            $columns = array("ip" => $ip,"date" => $date);
            $this->db->insert("counter",$columns);
        }
    }
    
    function counter(){
        $count = $this->db->count_all("counter");
        return $count;
    }
    
    
    function group_month(){
        $sql = "SELECT m.month_val,m.month_th,IFNULL(Q1.TOTAL,0) AS TOTAL
                    FROM mas_month m 

                    LEFT JOIN 
                    (
                    SELECT TRIM(SUBSTR(c.date,6,2)) AS month,COUNT(*) AS TOTAL
                    FROM counter c 
                    GROUP BY TRIM(SUBSTR(c.date,6,2))
                    ) Q1 

                    ON m.month_val = Q1.`month`

                    ORDER BY m.month_val ";
        
        $result = $this->db->query($sql);
        
        foreach($result->result() as $rs):
            $val[] = $rs->TOTAL;
        endforeach;
        
        $countermonth = implode(",", $val);
        
        return $countermonth;
    }
    
    function getmonth(){
        $thai = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        return "'".implode("','", $thai)."'";
    }
    
    function getcounterMonth(){
        $sql = "SELECT COUNT(*) AS TOTAL
                FROM counter c 
                WHERE LEFT(c.date,4) = YEAR(NOW()) 
                AND MONTH(NOW()) = SUBSTR(c.date,6,2)";
        $rs = $this->db->query($sql)->row();
        return $rs->TOTAL;
    }
    
    function getcounterDay(){
        $sql = "SELECT COUNT(*) AS TOTAL
                FROM counter c 
                WHERE LEFT(c.date,4) = YEAR(NOW()) 
                AND DAY(NOW()) = SUBSTR(c.date,9,2) ";
        $rs = $this->db->query($sql)->row();
        return $rs->TOTAL;
    }
}
