<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tobenews extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('tobeupload_model', 'upload');
        $this->load->model('tobenews_model', 'news');
        //$this->load->model('groupnews_model', 'groupnews');
        $this->load->helper('url');
        $this->load->library('takmoph_libraries');
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->helper('string');
    }


    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        $template = $this->template_model->get_template();
        $this->load->view($template['template'], $data);
    }

    public function tobehome() {
        $type = $this->input->post('type');
        $data['news'] = $this->tobenews_model->GetnewsAll('10',$type);
        $page = "toberegis/tobenews/tobenewshome";
        $this->load->view($page, $data);
    }

}
