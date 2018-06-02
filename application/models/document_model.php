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
class document_model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI = $this->load->database('default', TRUE);
        $this->CI->query("SET NAMES 'UTF8'");
    }

    /* ############### SERVER ####################### */
/*
    function get_archives($DT_Id = '') {
        $sql = "SELECT d.DO_Id,d.DO_Title,d.DO_Date
      FROM archives2015.documentoutput d INNER JOIN archives2015.numberoutput n ON d.DO_Id = n.DO_Id
      WHERE n.DT_Id = '$DT_Id' AND d.DO_Status = 'ใช้' AND  d.Doc_Flag = 'Yes' AND d.Flagindex = 'Yes'
      ORDER BY DO_Credate DESC LIMIT 5";
        return $this->db->query($sql);
    }

    function get_archives_all($DT_Id = '') {
        $sql = "SELECT d.DO_Id,d.DO_Title,d.DO_Date
      FROM archives2015.documentoutput d INNER JOIN archives2015.numberoutput n ON d.DO_Id = n.DO_Id
      WHERE n.DT_Id = '$DT_Id' AND d.DO_Status = 'ใช้' AND  d.Doc_Flag = 'Yes' AND d.Flagindex = 'Yes'
      ORDER BY DO_Credate DESC";
        return $this->db->query($sql);
    }

    function get_semina() {
        $sql = "SELECT Store_Id,Store_Title,Store_Date
      FROM archives2015.store s INNER JOIN archives2015.document d ON s.Doc_Id = d.Doc_Id
      WHERE d.Doc_Id = '172' AND Store_Flag = 'Yes' AND Flagindex = 'Yes'
      ORDER BY Store_Credate DESC LIMIT 5";
        return $this->db->query($sql);
    }

    function get_semina_all() {
        $sql = "SELECT Store_Id AS DO_Id,Store_Title AS DO_Title,Store_Date AS DO_Date
      FROM archives2015.store s INNER JOIN archives2015.document d ON s.Doc_Id = d.Doc_Id
      WHERE d.Doc_Id = '172' AND Store_Flag = 'Yes' AND Flagindex = 'Yes'
      ORDER BY Store_Credate DESC ";
        return $this->db->query($sql);
    }

    function document_type($Id = null) {
        $sql = "SELECT DT_Id,DT_Name
      FROM archives2015.documenttype
      WHERE DT_Id = '$Id' ";
        return $this->db->query($sql)->row();
    }
*/


      function get_archives($DT_Id = '') {
      $sql = "SELECT d.DO_Id,d.DO_Title,d.DO_Date
      FROM documentoutput d INNER JOIN numberoutput n ON d.DO_Id = n.DO_Id
      WHERE n.DT_Id = '$DT_Id' AND d.DO_Status = 'ใช้' AND  d.Doc_Flag = 'Yes' AND d.Flagindex = 'Yes'
      ORDER BY DO_Credate DESC LIMIT 5";
      return $this->db->query($sql);
      }

      function get_archives_all($DT_Id = '') {
      $sql = "SELECT d.DO_Id,d.DO_Title,d.DO_Date
      FROM documentoutput d INNER JOIN numberoutput n ON d.DO_Id = n.DO_Id
      WHERE n.DT_Id = '$DT_Id' AND d.DO_Status = 'ใช้' AND  d.Doc_Flag = 'Yes' AND d.Flagindex = 'Yes'
      ORDER BY DO_Credate DESC";
      return $this->db->query($sql);
      }


      function get_semina() {
      $sql = "SELECT Store_Id,Store_Title,Store_Date
      FROM store s INNER JOIN document d ON s.Doc_Id = d.Doc_Id
      WHERE d.Doc_Id = '172' AND Store_Flag = 'Yes' AND Flagindex = 'Yes'
      ORDER BY Store_Credate DESC LIMIT 5";
      return $this->db->query($sql);
      }


      function get_semina_all() {
      $sql = "SELECT Store_Id AS DO_Id,Store_Title AS DO_Title,Store_Date AS DO_Date
      FROM store s INNER JOIN document d ON s.Doc_Id = d.Doc_Id
      WHERE d.Doc_Id = '172' AND Store_Flag = 'Yes' AND Flagindex = 'Yes'
      ORDER BY Store_Credate DESC ";
      return $this->db->query($sql);
      }


      function document_type($Id = null) {
      $sql = "SELECT DT_Id,DT_Name
      FROM documenttype
      WHERE DT_Id = '$Id' ";
      return $this->db->query($sql)->row();
      }

////////// end //////
}

?>
