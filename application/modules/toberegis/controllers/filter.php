<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class filter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('toberegis/toberegis_model', 'model');
        $this->load->model('toberegis/report_model', 'report');
        $this->load->model('toberegis/users_model', 'usermodel');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
        $this->load->library('Ciqrcode', 'ciqrcode');
        $this->load->library('takmoph_libraries');
        $this->load->helper('cookie');
    }

    public function Auth() {
        if ($this->session->userdata('status') == "S" || $this->session->userdata('user_register') != "" || !empty($this->session->userdata('user_register'))) {
            return TRUE;
        } else {
            redirect('users/login', 'refresh');
        }
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        //$template = $this->template_model->get_template();
        $this->load->view("toberegis/template", $data);
    }

    public function Index() {
        $this->Auth();
    }

    public function filterampur($changwat = "63"){
        $page = "filter/ampur";
        $this->db->where("changwatcode",$changwat);
        $data['ampur'] = $this->db->get("campur");
    }

}
