<?php

Class Log_model extends CI_Model {

    function Getloglogin($type) {
        if($type == '0'){
            $WHERE = "";
        } else if($type == '1'){
            $WHERE = "WHERE status = 'true' ";
        } else {
            $WHERE = "WHERE status = 'false' ";
        }
        
        $sql = "SELECT * FROM log_login $WHERE ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query;
    }

}

?>
