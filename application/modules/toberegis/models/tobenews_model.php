<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tobenews_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function get_news_limit($limit = null) {
        if (empty($limit)) {
            $limits = 6;
        } else {
            $limits = $limit;
        }
        $this->db->cache_on();
        $sql = "SELECT N.*,M.name,M.lname,IM.*
                    FROM tobe_news N LEFT JOIN (SELECT MAX(id),new_id,images FROM tobeimages_news GROUP BY new_id) IM ON N.id = IM.new_id
                    INNER JOIN tobe_user M ON N.user_id = M.user_id
                    ORDER BY N.id DESC
                    LIMIT $limits ";
        return $this->db->query($sql);
    }

    
    function get_news() {
        $sql = "SELECT n.*,m.name,m.lname
        FROM tobe_news n INNER JOIN tobe_user m ON n.user_id = m.user_id
        ORDER BY date DESC";
        return $this->db->query($sql);
    }

    function get_news_ingroup($user_id = null) {
        $sql = "SELECT n.*,m.name,m.lname
        FROM tobe_news n INNER JOIN tobe_user m ON n.user_id = m.id
        WHERE n.user_id = '$user_id'
        ORDER BY n.date DESC";
        return $this->db->query($sql);
    }

    function get_news_where($new_id = '') {
        $sql = "SELECT n.*,m.name,m.lname
                FROM tobe_news n INNER JOIN tobe_user m ON n.user_id = m.user_id
                WHERE id = '$new_id' ORDER BY id DESC";
        $result = $this->db->query($sql);
        $row = $result->row();
        return $row;
    }

    function get_images_news($new_id = '') {
        $sql = "SELECT * FROM tobeimages_news WHERE new_id = '$new_id' ";
        return $this->db->query($sql);
    }

    function get_first_images_news($new_id = '') {
        $sql = "SELECT images FROM tobeimages_news WHERE new_id = '$new_id' LIMIT 1";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            $row = $result->row();
            $images = $row->images;
        } else {
            $images = "";
        }
        return $images;
    }

    function max_read($newsId = null) {
        $sql = "SELECT MAX(views) AS total FROM tobe_news WHERE id = '$newsId'";
        $rs = $this->db->query($sql)->row();
        return $rs->total;
    }

    function near() {
        $sql = "SELECT n.*,m.name,m.lname
        FROM tobe_news n INNER JOIN tobe_user m ON n.user_id = m.user_id
        ORDER BY date DESC LIMIT 5";
        return $this->db->query($sql);
    }

    function hot() {
        $sql = "SELECT n.*,m.name,m.lname
        FROM tobe_news n INNER JOIN tobe_user m ON n.user_id = m.user_id
        ORDER BY n.views DESC LIMIT 6";
        return $this->db->query($sql);
    }

    function last_news() {
        $sql = "SELECT n.*,m.name,m.lname
        FROM tobe_news n INNER JOIN tobe_user m ON n.user_id = m.user_id
        ORDER BY n.id DESC LIMIT 6";
        return $this->db->query($sql);
    }

    function count() {
        return $this->db->count_all("tobe_news");
    }

    

    // Fetch data according to per_page limit.
    public function fetch_data($limit, $start) {
        if ($start != '') {
            $pagestart = $start;
        } else {
            $pagestart = 0;
        }
        $sql = "SELECT n.*,m.name,m.lname
      FROM tobe_news n INNER JOIN tobe_user m ON n.user_id = m.user_id
      ORDER BY date DESC
      LIMIT $pagestart,$limit";
        return $this->db->query($sql);
    }

    public function GetnewsAll($limit = null){
        if()
    }

    

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
