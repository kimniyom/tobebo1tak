<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function Lastpost() {
        $sql = "SELECT p.*,u.alias,u.photo,c.title AS cat_name
                FROM forum_post p INNER JOIN forum_register u ON p.user_id = u.id 
                INNER JOIN forum_category c ON p.category = c.id
                WHERE p.flag = '0'
                ORDER BY p.id DESC LIMIT 100";
        $result = $this->db->query($sql);
        return $result;
    }

    function CountComment($postID = null) {
        $sql = "SELECT COUNT(*) AS total FROM forum_comment WHERE post_id = '$postID' ";
        $rs = $this->db->query($sql)->row();
        return $rs->total;
    }

    function ViewPost($post_id = null) {
        $sql = "SELECT p.*,c.title AS catname
                FROM forum_post p INNER JOIN forum_category c ON p.category = c.id
                WHERE p.flag = '0' AND p.id = '$post_id'";
        $rs = $this->db->query($sql)->row();
        return $rs;
    }

    function UserDetail($user_id = null) {
        $this->db->select("*");
        $this->db->from("forum_register");
        $this->db->where("id", $user_id);
        $query = $this->db->get()->row();
        return $query;
    }

    function CountPost($user_id = null) {
        $sql = "SELECT COUNT(*) AS TOTAL FROM forum_post p WHERE p.user_id = '$user_id' AND p.flag = '0' ";
        $result = $this->db->query($sql)->row();
        return $result->TOTAL;
    }

    function LastPostUser($tokens = null) {
        $sql = "SELECT p.*,c.title as cat_name 
                FROM forum_post p 
                INNER JOIN forum_category c ON p.category = c.id 
                INNER JOIN forum_register r ON p.user_id = r.id
                WHERE r.token_key = '$tokens' AND p.flag = '0'
                ORDER BY p.create_date DESC LIMIT 10";
        return $this->db->query($sql);
    }

    public function Countrepost() {
        $user_id = $this->session->userdata('forum_user_id');
        $sql = "SELECT COUNT(*) AS total
                 FROM forum_repost r INNER JOIN forum_post p ON r.post_id = p.id
                 WHERE p.user_id = '$user_id' AND p.flag = '0' AND r.read_status = '0' ";
        $rs = $this->db->query($sql)->row();
        return $rs->total;
    }

    public function Repost() {
        $user_id = $this->session->userdata('forum_user_id');
        $sql = "SELECT r.id,u.alias,p.title,r.post_id,r.comment_id,r.d_update
                 FROM forum_repost r INNER JOIN forum_post p ON r.post_id = p.id
                 INNER JOIN forum_register u ON r.user_id = u.id
                 WHERE p.user_id = '$user_id' AND p.flag = '0' AND r.read_status = '0' 
                 ORDER BY r.d_update DESC";
        $rs = $this->db->query($sql);
        return $rs;
    }
    
    public function Countrecomment(){
        $user_id = $this->session->userdata('forum_user_id');
        $sql = "SELECT COUNT(*) AS total
                FROM forum_inform_comment i INNER JOIN forum_recomment r ON i.recomment_id = r.id
                WHERE r.user_id = '$user_id' AND i.flag = '1'";
        $rs = $this->db->query($sql)->row();
        return $rs->total;
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
