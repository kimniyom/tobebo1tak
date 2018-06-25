<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class formdownload extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->library('takmoph_libraries');
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

    public function index() {
        $data['catergory'] = $this->tak->get_mas_from();
        $page = "formdownload/index";
        $head = "แบบฟอร์มต่าง ๆ";

        $this->output($data, $page, $head);
    }

}
