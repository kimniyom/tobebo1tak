<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class asbforum_model extends CI_Model {

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

    function Category() {
        return $this->db->get_where("forum_category", array("active" => "Y", "upper" => "0"));
    }

    function Comment($post_id, $user_id) {
        //AND c.user_id = '$user_id' 
        $sql = "SELECT c.*,u.alias,u.photo,p.user_id as user_post
                FROM forum_comment c INNER JOIN forum_register u ON c.user_id = u.id 
                INNER JOIN forum_post p ON c.post_id = p.id 
                WHERE c.post_id = '$post_id' ORDER BY c.id ASC";
        return $this->db->query($sql);
    }

    function GetpostInCategory($catID) {
        $sql = "SELECT p.*,r.name,r.lname,r.alias 
            FROM forum_post p INNER JOIN forum_register r ON p.user_id = r.id 
            WHERE p.category IN ($catID) AND p.flag = '0' ORDER BY p.id DESC";
        return $this->db->query($sql);
    }

    function CountComment($postID = null) {
        $sql = "SELECT COUNT(*) AS total FROM forum_comment WHERE post_id = '$postID' ";
        $rs = $this->db->query($sql)->row();
        return $rs->total;
    }

    function CountPost($CatID = null) {
        $rs = $this->db->get_where("forum_category", array("id" => $CatID))->row();
        if ($rs->level == "0") {
            $sql = "SELECT COUNT(*) AS total FROM forum_post WHERE category = '$CatID' AND flag = '0' ";
            $row = $this->db->query($sql)->row();
            $total = $row->total;
        } else {
            $total = 0;
            $upper = $this->db->get_where("forum_category", array("upper" => $CatID));
            foreach ($upper->result() as $uppers):
                $sql = "SELECT COUNT(*) AS total FROM forum_post WHERE category = '$uppers->id' AND flag = '0' ";
                $row = $this->db->query($sql)->row();
                $total = ($total + $row->total);
            endforeach;
        }
        return $total;
    }

    public function LastComment($post_id = null) {
        $sql = "SELECT c.create_date,r.alias,c.ip,r.token_key FROM forum_comment c INNER JOIN forum_register r ON c.user_id = r.id WHERE c.post_id = '$post_id' ORDER BY c.create_date DESC LIMIT 1";
        $rs = $this->db->query($sql)->row();
        return $rs;
    }
    
    public function Getrecomment($comment_id = null){
        $sql = "SELECT r.*,u.alias,u.photo
                FROM forum_inform_comment i INNER JOIN forum_recomment r ON i.recomment_id = r.id
                INNER JOIN forum_register u ON r.user_id = u.id
                WHERE r.comment_id = '$comment_id' 
                ORDER BY r.id DESC LIMIT 5 ";
         $rs = $this->db->query($sql);
        return $rs;
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
