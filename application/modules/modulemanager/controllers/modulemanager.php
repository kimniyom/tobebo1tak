<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class modulemanager extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->model('modulemanager/modulemanager_model', 'module');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        $this->load->view('template_admin', $data);
    }

    public function Index() {
        $page = "modulemanager/index";
        $data['module'] = $this->module->Get_moduleAll();
        $this->output($data, $page, "Module manager");
    }

}
