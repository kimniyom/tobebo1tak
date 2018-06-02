<?php

Class User extends CI_Model {

    function login($username) {
        /*
          $sql = "SELECT * FROM mas_user WHERE username = ? AND password = ?";
          return $this->db->query($sql, array($login_user, md5($password)));
         */

        $this->db->select("*");
        $this->db->from("mas_user");
        $this->db->where("username", $username);
        //$this->db->where("password", md5($password));
        $this->db->limit("1");
        $query = $this->db->get();

        return $query->row();

        //return $this->db->query($sql);
    }

    function check_password($password_input = null, $password = null) {
        $p_input = md5($password_input);

        if ($p_input == $password) {
            $verify = "1";
        } else {
            $verify = "0";
        }

        return $verify;
    }

    function auth($Id = null) {
        $this->db->select("*");
        $this->db->from("mas_user");
        $this->db->where("user_id", $Id);
        //$this->db->where("block", "0");
        //$this->db->where("password", md5($password));
        $this->db->limit("1");
        $query = $this->db->get();

        $row = $query->row();

        $data = array(
            'name' => $row->name,
            'lname' => $row->lname,
            'status' => $row->status,
            'username' => $row->username,
            'user_id' => $row->user_id
        );
        $this->session->set_userdata($data);

        $log = array(
            "username" => $row->username,
            "user_id" => $row->user_id,
            "password" => $row->password,
            "ip" => $this->input->ip_address(),
            "status" => "True",
            "d_date" => date("Y-m-d H:i:s")
        );
        $this->db->insert("log_login", $log);
    }

    function savelog_login_flase($username = null, $password = null) {
        $log = array(
            "username" => $username,
            "user_id" => "",
            "password" => $password,
            "ip" => $this->input->ip_address(),
            "status" => "False",
            "d_date" => date("Y-m-d H:i:s")
        );
        $this->db->insert("log_login", $log);
    }

    function get_user() {
        $this->db->select("*");
        $this->db->from("mas_user");
        $this->db->order_by("user_id", "ASC");
        $query = $this->db->get();

        return $query;
    }

    function view($user_id = null) {
        $this->db->select("*");
        $this->db->from("mas_user");
        $this->db->where("user_id", $user_id);
        $query = $this->db->get();

        return $query->row();
    }

    function get_menu_permissions($user_id = null) {
        $sql = "SELECT Q1.*,IF(Q2.active != '','1','0')AS active,Q2.id FROM
                    (
                        SELECT a.admin_menu_id,a.admin_menu_name
                        FROM admin_menu a
                    ) Q1

                LEFT JOIN

                    (
                        SELECT p.id,p.admin_menu_id,p.user_id AS active
                        FROM permissions p
                        WHERE p.user_id = '$user_id'
                    ) Q2

                ON Q1.admin_menu_id = Q2.admin_menu_id ";

        return $this->db->query($sql);
    }

    function permissions_homepage($user_id = null){
      $sql = "SELECT m.*,Q1.homepage_id AS menu_active,Q1.id AS permission_id
              FROM menu_homepage m
              LEFT JOIN
              (
              	SELECT p.homepage_id,p.id
              	FROM permission_homepage p
              	WHERE p.user_id = '$user_id'
              ) Q1

              ON m.id = Q1.homepage_id
              ORDER BY m.id ";

      return $this->db->query($sql);
    }
    
    function permissions_module($user_id = null){
      $sql = "SELECT m.*,Q1.module AS menu_active,Q1.id AS permission_id
              FROM module m
              LEFT JOIN
              (
              	SELECT p.module,p.id
              	FROM permission_module p
              	WHERE p.user_id = '$user_id'
              ) Q1

              ON m.id = Q1.module
              ORDER BY m.id ";

      return $this->db->query($sql);
    }
    
    

    public function get_permission_user($user_id = null){
      $this->db->select("homepage_id");
      $this->db->from("permission_homepage");
      $this->db->where("user_id",$user_id);

      $query = $this->db->get();

      $permission = array();
      foreach($query->result() as $rs):
        $permission[] = $rs->homepage_id;
      endforeach;

      return $permission;
    }
    
    public function Countlog(){
        
        $sql = "SELECT SUM(IF(l.`status` = 'true',1,0)) AS login_true,
                SUM(IF(l.`status` = 'false',1,0)) AS login_false,
                COUNT(*) AS total
                FROM log_login l";
        return $this->db->query($sql)->row();
    }

}

?>
