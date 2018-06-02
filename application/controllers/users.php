<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('user', 'user');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        $template = $this->template_model->get_template();
        $this->load->view($template['template'], $data);
    }

    public function login() {
        $this->load->view('user/login');
    }

    public function do_login() {
        $ip = $this->input->ip_address();

        $sqllock = "SELECT * FROM lock_ip WHERE ip = '$ip' ";
        $resultlock = $this->db->query($sqllock);
        if ($resultlock->num_rows > 0) {
            echo "lock";
            return false;
        }

        $datenow = date("Y-m-d");
        $sql = "SELECT COUNT(*) AS TOTAL FROM log_login WHERE ip = '$ip' AND LEFT(d_date,10) = '$datenow' AND status = 'Flase'";
        $rs = $this->db->query($sql)->row();

        //นับจำนวนการเข้าต่อวัน
        if ($rs->TOTAL > 50) {
            $lock = array(
                "ip" => $this->input->ip_address(),
                "d_update" => date("Y-m-d H:i:s")
            );
            $this->db->insert("lock_ip", $lock);
        } else {
            //รับค่า
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->user->login($username); //หา user คนนี้ก่อน

            if (!empty($user->username)) {
                // compare passwords
                $checkPassword = $this->user->check_password($password, $user->password);

                if ($checkPassword == 1) {
                    // mark user as logged in
                    $this->user->auth($user->user_id);
                    echo 'Success';
                } else {
                    $this->user->savelog_login_flase($username, $password);
                    echo "NOSuccess";
                }
            } else {
                $this->user->savelog_login_flase($username, $password);
                echo "NOSuccess";
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        echo "<script>window.location='" . site_url('') . "'</script>";
    }

    public function lock() {
        $this->load->view("user/lock");
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */