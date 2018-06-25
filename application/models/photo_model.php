<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class photo_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    function count(){
      return $this->db->count_all("album");
    }

    // Fetch data according to per_page limit.
    public function fetch_data($limit, $start) {
      if($start != ''){
        $pagestart = $start;
      } else {
        $pagestart = 0;
      }
      $sql = "SELECT n.*,m.name,m.lname
      FROM album n INNER JOIN mas_user m ON n.owner = m.user_id
      ORDER BY n.id DESC
      LIMIT $pagestart,$limit";
      return $this->db->query($sql);
    }

    public function get_first_album($id = null){
      $this->db->select("images");
      $this->db->from("gallery");
      $this->db->where("album_id","$id");
      $this->db->limit("1");
      $query = $this->db->get();

      $result = $query->row();
      if($result){
        $images = $result->images;
      } else {
        $images = "no-sign_1334604348.png";
      }

      return $images;
    }

    public function get_album($id = null){
      $this->db->select("album.*,mas_user.name,mas_user.lname");
      $this->db->from("album");
      $this->db->join("mas_user","mas_user.user_id = album.owner");
      $this->db->where("album.id",$id);
      $this->db->limit("1");
      $query = $this->db->get();

      return $query->row();
    }

    public function get_gallery($album_id = null){
      $this->db->select("*");
      $this->db->from("gallery");
      $this->db->where("album_id",$album_id);
      $this->db->order_by("id","ASC");
      $query = $this->db->get();

      return $query;
    }

    public function album_limit($limit = null){
      $this->db->select("*");
      $this->db->from("album");
      $this->db->order_by("id","DESC");
      $this->db->limit($limit);
      $query = $this->db->get();

      return $query;
    }

    public function read_album($album_id = null){
      $this->db->select("views");
      $this->db->from("album");
      $this->db->where("id",$album_id);
      //$this->db->limit("1");

      $query = $this->db->get();
      $rs = $query->row();
      return $rs->views;
    }

    public function count_gallery($album_id = null){
      $this->db->select("COUNT(*) AS total");
      $this->db->from("gallery");
      $this->db->where("album_id",$album_id);
      $this->db->limit("1");
      $rs = $this->db->get()->row();

      return $rs->total;
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
