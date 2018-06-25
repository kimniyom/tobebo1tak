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
 * @company : Takmoph 2014
 * @create  : 29 พ.ค. 2556 16:01:33
 *
 */
class takmoph_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function autoId($table, $value, $number) {
        $new_id = mysql_result(mysql_query("Select Max($value)+1 as MaxID from  $table"), 0, "MaxID"); //เลือกเอาค่า id ที่มากที่สุดในฐานข้อมูลและบวก 1 เข้าไปด้วยเลย
        if ($new_id == '') { // ถ้าได้เป็นค่าว่าง หรือ null ก็แสดงว่ายังไม่มีข้อมูลในฐานข้อมูล
            $std_id = sprintf("%0" . $number . "d", 1); //ถ้าไม่ใช่ค่าว่าง
        } else {
            $std_id = sprintf("%0" . $number . "d", $new_id); //ถ้าไม่ใช่ค่าว่าง
        }

        return $std_id;
    }

    function thaidate($dateformat = "") {
        $year = substr($dateformat, 0, 4);
        $month = substr($dateformat, 5, 2);
        $day = substr($dateformat, 8, 2);
        $thai = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

        if (strlen($dateformat) <= 10) {
            return $thaidate = (int) $day . " " . $thai[(int) $month] . " " . ($year + 543);
        } else {
            return $thaidate = (int) $day . " " . $thai[(int) $month] . " " . ($year + 543) . " " . substr($dateformat, 10);
        }
    }

    function month_full() {
        $thai_month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        return $thai_month;
    }

    function refresh($url, $text) {
        $result = "<SCRIPT LANGUAGE='JavaScript' charset='UTF-8'>
        window.alert('" . $text . "')
        window.location.href='" . base_url() . "index.php/" . $url . "'</SCRIPT>";
        return $result;
    }

    function redir($url) {
        $result = "<SCRIPT LANGUAGE='JavaScript' charset='UTF-8'>
        window.location.href='" . base_url() . "index.php/" . $url . "'</SCRIPT>";
        return $result;
    }

    function close($text) {
        $result = "<SCRIPT LANGUAGE='JavaScript' charset='UTF-8'>
        window.alert('" . $text . "')
        window.close();</SCRIPT>";
        return $result;
    }

    function checkbrowser() {

        $this->load->library('user_agent');

        if ($this->agent->is_browser('Internet Explorer')) {
            $browser = 'IE';
        } else if ($this->agent->is_browser()) {
            $browser = $this->agent->is_browser();
        }

        return $browser;
    }

    function duration($begin = "") {
        $end = date("Y-m-d H:i:s");
        $remain = intval(strtotime($end) - strtotime($begin));
        $wan = floor($remain / 86400);
        $l_wan = $remain % 86400;
        $hour = floor($l_wan / 3600);
        $l_hour = $l_wan % 3600;
        $minute = floor($l_hour / 60);
        $second = $l_hour % 60;
        if ($wan > 0) {
            $datetime = " ประมาณ " . $wan . " วัน";
        } else if ($hour > 0) {
            $datetime = " ประมาณ " . $hour . " ชั่วโมง";
        } else if ($minute > 0) {
            $datetime = " ประมาณ " . $minute . " นาที";
        } else if ($second > 0) {
            $datetime = " ไม่กี่วินาทีที่แล้ว";
        }
        //return "ผ่านมาแล้ว ".$wan." วัน ".$hour." ชั่วโมง ".$minute." นาที ".$second." วินาที";
        return $datetime;
    }

    function max_id($table = '', $fild = '') {
        $sql = "SELECT MAX($fild)AS max_id FROM $table";
        $result = $this->db->query($sql);
        $row = $result->row();

        return $row->max_id;
    }

    function login($username, $password) {
        $sql = "SELECT * FROM mas_user WHERE username = ? AND password = ?";
        return $this->db->query($sql, array($username, $password));

        //return $this->db->query($sql);
    }


    function get_mas_menu() {
        $sql = "SELECT m.*,i.icon AS menu_icon
                FROM mas_menu m INNER JOIN menu_icon i ON m.icon_id = i.icon_id
                ORDER BY m.level ASC ";
        return $this->db->query($sql);
    }

    function get_mas_menu_where($mas_id = '') {
        $sql = "SELECT m.*,i.icon_id,i.icon AS menu_icon
                FROM mas_menu m INNER JOIN menu_icon i ON m.icon_id = i.icon_id
                WHERE m.id = '$mas_id' ";
        $result = $this->db->query($sql);
        $row = $result->row();

        return $row;
    }

    function get_sub_menu($mas_id = '') {
        $sql = "SELECT s.*
                FROM mas_menu m INNER JOIN sub_menu s ON m.id = s.mas_id
                WHERE s.mas_id = '$mas_id'
                ORDER BY sub_id DESC LIMIT 100";
        return $this->db->query($sql);
    }

    function get_sub_menu_where($sub_id = '') {
        $sql = "SELECT *
                FROM sub_menu
                WHERE sub_id = '$sub_id'";
        $result = $this->db->query($sql);
        return $result->row();
    }

    function count_menu($mas_id = '') {
        $sql = "SELECT COUNT(*) AS total
                FROM sub_menu
                WHERE mas_id = '$mas_id' ";
        $result = $this->db->query($sql);
        $row = $result->row();
        return $row->total;
    }

    function get_mas_from() {
        $sql = "SELECT *
                FROM mas_from
                ORDER BY id ASC ";
        return $this->db->query($sql);
    }

    function get_mas_from_where($Id = null) {
        $sql = "SELECT *
                FROM mas_from
                WHERE id = '$Id' ";
        return $this->db->query($sql)->row();
    }

    function get_sub_from($mas_id = '') {
        $sql = "SELECT *
                FROM sub_from
                WHERE mas_id = '$mas_id'
                ORDER BY sub_id DESC LIMIT 100";
        return $this->db->query($sql);
    }

    function get_sub_from_where($sub_id = '') {
        $sql = "SELECT *
                FROM sub_from
                    WHERE sub_id = '$sub_id'";
        return $this->db->query($sql)->row();
    }

    function get_meeting() {
        $sql = "SELECT m.meettitle,f.filemeeting
                FROM dbmeeting_system.meeting m INNER JOIN dbmeeting_system.filemeeting f ON m.meetid = f.meeid
                ORDER BY m.id DESC LIMIT 12 ";
        return $this->db->query($sql);
    }

    function get_menu_system() {
        $this->db->cache_on();
        $sql = "SELECT *
                FROM menu_system
                WHERE status_show = 'Yes'
                ORDER BY system_id DESC";
        return $this->db->query($sql);
    }

    function get_menu_systemAll() {
        $this->db->cache_on();
        $sql = "SELECT *
                FROM menu_system
                ORDER BY system_id DESC";
        return $this->db->query($sql);
    }

    function get_icon() {
        $sql = "SELECT * FROM menu_icon ORDER BY icon_id DESC ";
        return $this->db->query($sql);
    }

    function get_icon_menu($icon_id = '') {
        $sql = "SELECT * FROM menu_icon WHERE icon_id = '$icon_id' ";
        $result = $this->db->query($sql);
        $row = $result->row();
        return $row;
    }

    function get_dengue($id = '') {
        $sql = "SELECT d.*,u.name,u.lname
                FROM dengue d INNER JOIN mas_user u ON d.user_id = u.user_id
                WHERE d.admin_menu_id = '$id' ORDER BY d.id DESC";
        return $this->db->query($sql);
    }

    public function get_banner() {
        $sql = "SELECT * FROM banner ";
        return $this->db->query($sql);
    }

    public function get_banner_show() {
        $sql = "SELECT * FROM banner WHERE status = '1' ";
        return $this->db->query($sql);
    }

    function _get_detail_user($user_id = '') {
        $sql = "SELECT * FROM mas_user WHERE user_id = '$user_id' ";
        $result = $this->db->query($sql);
        $row = $result->row();

        return $row;
    }

    function get_menu_sit() {
        $sql = "SELECT p.id,p.admin_menu_id,a.admin_menu_name,a.admin_menu_images,a.admin_menu_link
                FROM permissions p INNER JOIN admin_menu a ON p.admin_menu_id = a.admin_menu_id
                WHERE p.user_id = '" . $this->session->userdata('user_id') . "' ";
        return $this->db->query($sql);
    }

    function get_menu_admin() {
        $userId = $this->session->userdata('user_id');
        $status = $this->session->userdata('status');
          if($status != "S"){
            $sql = "SELECT p.id,p.admin_menu_id,a.admin_menu_name,a.admin_menu_images,a.admin_menu_link,a.typelink
                FROM permissions p INNER JOIN admin_menu a ON p.admin_menu_id = a.admin_menu_id
                WHERE p.user_id = '$userId' ";
              } else {
                $sql = "SELECT * FROM admin_menu WHERE status = '1' ";
              }
        return $this->db->query($sql);
    }
    
    function get_menu_module() {
        $userId = $this->session->userdata('user_id');
        $status = $this->session->userdata('status');
          if($status != "S"){
            $sql = "
              	SELECT m.*
              	FROM permission_module p INNER JOIN module m ON p.module = m.id
              	WHERE p.user_id = '$userId' AND m.active = 'Y' ";
              } else {
                $sql = "SELECT * FROM module m WHERE m.active = 'Y' ";
              }
        return $this->db->query($sql);
    }
    
    
    

    function get_menu_admin_type($type = null) {
        $userId = $this->session->userdata('user_id');
        $status = $this->session->userdata('status');
          if($status != "S"){
            $sql = "SELECT p.id,p.admin_menu_id,a.admin_menu_name,a.admin_menu_images,a.admin_menu_link,a.typelink
                FROM permissions p INNER JOIN admin_menu a ON p.admin_menu_id = a.admin_menu_id
                WHERE p.user_id = '$userId' AND a.typelink = '$type' ";
              } else {
                $sql = "SELECT * FROM admin_menu WHERE status = '1' AND typelink = '$type'";
              }
        return $this->db->query($sql);
    }


    function get_system_menu() {
        $sql = "SELECT a.admin_menu_id,a.admin_menu_name,CONCAT(a.admin_menu_link,'/',a.admin_menu_id)AS link
                FROM dengue d INNER JOIN admin_menu a ON d.admin_menu_id = a.admin_menu_id
                GROUP BY d.admin_menu_id ";

        return $this->db->query($sql);
    }

    function user_status($status = '') {
        if ($status == 'S') {
            $type = "Super Admin";
        } else {
            $type = "Admin";
        }

        return $type;
    }

    function get_name_menu($menu_id = '') {
        $sql = "SELECT admin_menu_name FROM admin_menu WHERE admin_menu_id = '$menu_id' ";
        $result = $this->db->query($sql)->row();
        return $result->admin_menu_name;
    }

    function GetMaxId($table = '', $filde = '') {
        $sql = "SELECT MAX($filde) AS MAXID FROM $table";
        $rs = $this->db->query($sql)->row();
        return $rs->MAXID;
    }

    function GetMenuId() {
        $sql = "SELECT admin_menu_id,admin_menu_images FROM admin_menu ORDER BY admin_menu_id DESC LIMIT 1";
        $rs = $this->db->query($sql)->row();
        return $rs;
    }

    function GetMasMenuAdmin() {
        $sql = "SELECT *
                    FROM admin_menu a
                    WHERE a.`typelink` = '1' AND a.`admin_menu_id` NOT IN (SELECT m.`admin_menu_id` FROM mas_menu m WHERE m.`mas_status` = '0')
                    AND a.`fix` = '0' ";
        $rs = $this->db->query($sql);
        return $rs;
    }

    function Get_name_group($menu_id = '') {
        $sql = "SELECT a.admin_menu_name
                    FROM admin_menu a
                    WHERE a.admin_menu_id = '$menu_id' ";

        $rs = $this->db->query($sql)->row();

        return $rs->admin_menu_name;
    }
    
    function GetMonth(){
        $rs = $this->db->get('mas_month');
        return $rs;
    }

////////// end //////
}

?>
