<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class takmoph2014 extends CI_Controller {
    /*
     *  Creart Code By kimniyom
     *  Date 27/05/2556 | Time 22.26.00 
     * 
     */

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('newexpress_model');
        $this->load->model('upload_model', 'upload');
        $this->load->model('news_model', 'news');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;

        $this->load->view('template', $data);
    }

    public function output_main($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;

        $this->load->view('template2015', $data);
    }

    public function index() {
        $head = "";
        $page = "myhome";
        $this->output('', $page, $head);
    }

    public function main() {
        $head = "";
        $page = "myhome";
        $this->output_main('', $page, $head);
    }

    public function do_login() {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $query = $this->tak->login($username, $password);
        //echo $query->num_rows;
        if ($query->num_rows > 0) {
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
                "password" => $password,
                "ip" => $this->input->ip_address(),
                "status" => "True",
                "d_date" => date("Y-m-d H:i:s")
            );

            $this->db->insert("log_login", $log);
            echo 'Success';
        } else {
            echo "NOSuccess";
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
    }

    public function tel() {
        $data = "";
        $page = "web_page/tel";
        $head = "เบอร์โทรศัพท์สำนักงานสาธารณสุขจังหวัดตาก";

        $this->output($data, $page, $head);
    }

    public function history() {
        $data = "";
        $page = "web_page/history";
        $head = "ประวัติความเป็นมา";

        $this->output($data, $page, $head);
    }

    public function mission() {
        $data = "";
        $page = "web_page/mission";
        $head = "ภาระกิจ";

        $this->output($data, $page, $head);
    }

    public function logout() {
        $this->session->sess_destroy();
        $this->main();
    }

    public function president() {
        $data = "";
        $page = "web_page/president";
        $head = "โครงสร้างผู้บริหาร";

        $this->output($data, $page, $head);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */