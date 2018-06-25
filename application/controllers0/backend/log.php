<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class log extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('log_model');
        $this->load->model('user');
        $this->load->library('takmoph_libraries');
        $this->load->helper('url');
        $this->load->library('session');

        $user = $this->session->userdata('user_id');
        if (empty($user)) {
            echo $this->tak->redir('takmoph_admin');
        }
    }

    public function output($deta = '', $page = '', $head = '') {

        if (!empty($this->session->userdata['status']) && ($this->session->userdata['status'] == "S" || $this->session->userdata['status'] == "A")) {

            $data['detail'] = $deta;
            $data['page'] = $page;
            $data['head'] = $head;

            $this->load->view('template_admin', $data);
        } else {
            echo "<script>window.location='" . site_url('takmoph_admin') . "'</script>";
        }
    }

    public function Index() {
        $data['countlog'] = $this->user->Countlog();
        $this->output($data, 'log/index', 'log');
    }

    public function Loglogin() {
        $type = $this->uri->segment(4);
        $logModel = new Log_model();
        $log = $logModel->Getloglogin($type);
        $str = "";
        $str .= "ประวัติการ login เข้าใช้งาน<hr/>";
        $str .= "<table class='table' id='loglogin'><thead><tr>";
        $str .= "<th>#</th>";
        $str .= "<th>Username</th>";
        $str .= "<th>UserId</th>";
        $str .= "<th>Sratus</th>";
        $str .= "<th>Ip</th>";
        $str .= "<th>Date</th><tr></thead>";
        $str .= "<tbody>";
        $i = 0;
        foreach ($log->result() as $rs):$i++;
        $str .= "<tr>";
            $str .= "<td>" . $i . "</td>";
            $str .= "<td>" . $rs->username . "</td>";
            $str .= "<td>" . $rs->user_id . "</td>";
            $str .= "<td>" . $rs->status . "</td>";
            $str .= "<td>" . $rs->ip . "</td>";
            $str .= "<td>" . $rs->d_date . "</td>";
            $str .= "</tr>";
        endforeach;
        $str .= "</tbody></tbale>";
        echo $str;
    }

}
