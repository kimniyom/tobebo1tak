<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class site extends CI_Controller {
    /*
     *  Creart Code By kimniyom
     *  Date 27/05/2556 | Time 22.26.00
     *
     */

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('counter_model', 'counter');
        $this->load->model('menubar_model', 'menu');
        $this->load->model('newexpress_model');
        $this->load->model('upload_model', 'upload');
        $this->load->model('news_model', 'news');
        
        $this->load->helper('url');
        $this->load->library('takmoph_libraries');
        $this->load->library('session');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        //$this->load->view('template/default', $data);
        $template = $this->template_model->get_template();
        $this->load->view($template['template'], $data);
    }

    public function index() {
        $this->template_model->themes(); //set themes

        $ip = $this->input->ip_address();
        $date = date("Y-m-d");
        $this->counter->get_user($ip, $date);

        $head = "";
        $page = "myhome";
        $this->output('', $page, $head);
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

    public function set_desktop() {
        //$this->input->post->('width');
        $width = $this->input->post('width');
        $this->session->set_userdata("width", $width);
    }

    public function page($Id = null) {
        $PageId = $this->takmoph_libraries->decode($Id);

        $data['page'] = $this->menu->get_page($PageId);
        $head = $data['page']->title;
        $page = "menubar/view";
        $this->output($data, $page, $head);
    }

    public function sitemap(){
        $head = "ผังเว็บไซต์";
        $page = "site/site";
        $this->output($data = "", $page, $head);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
