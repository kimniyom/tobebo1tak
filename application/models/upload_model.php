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
class upload_model extends CI_Model{
    
    var $CI;
    
    function __construct()
    {
        parent::__construct();
        $this->CI= $this->load->database('default', TRUE);   
        $this->CI->query("SET NAMES 'UTF8'"); 
    }


    function get_id_album(){
        $sql = "SELECT MAX(AlbumID) AS AlbumID
                 FROM album ";
        $result = $this->db->query($sql);
        $row = $result->row();
        return $row->AlbumID;
    }

    function get_album($AlbumID = ''){
        $sql = "SELECT * 
                FROM album
                WHERE AlbumID = '$AlbumID' ";
        $result = $this->db->query($sql);
        $row = $result->row();

        return $row;
    }

       function get_album_all(){
        $sql = "SELECT * 
                FROM album 
                ORDER BY date DESC";
        $result = $this->db->query($sql);
        return $result;
    }

    function get_gallery($AlbumID = ''){
        $sql = "SELECT * 
                FROM gallery
                WHERE AlbumID = '$AlbumID' ";
        return $this->db->query($sql);
    }


////////// end //////

}

?>
