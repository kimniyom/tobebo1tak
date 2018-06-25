<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class homepage extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->model('homepage_model', 'model');
        $this->load->model('sub_homepage_model');
        $this->load->library('takmoph_libraries');
        $this->load->helper('url');
        $this->load->library('session');

        /*
          $user = $this->session->userdata('user_id');
          if (empty($user)) {
          echo $this->tak->redir('takmoph_admin');
          }
         *
         */
    }

    public function output($deta = '', $page = '', $head = '') {

            $data['detail'] = $deta;
            $data['page'] = $page;
            $data['head'] = $head;
            $template = $this->template_model->get_template();
            $this->load->view($template['template'], $data);

    }

    public function index() {
        header('Access-Control-Allow-Origin: *');
        $model = new homepage_model();
        //$data['type'] = $model->get_type();
        $data['mas_homepage'] = $model->get_menu();
        $page = "homepage/index";
        //$head = "ข้อมูลหน้าเว็บ";
        $this->load->view($page, $data);
        //$this->output($data, $page, $head);
    }

    public function all($id = null) {
        $menu_id = $this->takmoph_libraries->decode($id);
        $homepage = new homepage_model();
        $subhomepage = new sub_homepage_model();
        $data['homepage'] = $homepage->get_menu_where($menu_id)->row();
        $data['result'] = $subhomepage->get_subhomepage($menu_id);
        $page = "homepage/all";
        $head = $data['homepage']->title_name;
        $this->output($data, $page, $head);
    }
    

    public function view($Id = null,$submenuID = null) {
        $pageId = $this->takmoph_libraries->decode($Id);
        $subhomepage = new sub_homepage_model();
        $data['submenuID'] = $submenuID;
        $data['submenu'] = $subhomepage->get_subhomepage_detail($submenuID)->row();
        $data['result'] = $subhomepage->get_subhomepage_where($pageId)->row();

        $head = "view";
        $page = "homepage/view";
        $this->output($data, $page, $head);
    }
    
    public function viewupper($id = null,$suphomepageID = null) {
        $menu_id = $this->takmoph_libraries->decode($id);
        $homepage = new homepage_model();
        $subhomepage = new sub_homepage_model();
        //$data['homepage'] = $homepage->get_menu_where($suphomepageID)->row();
        $data['submenu'] = $subhomepage->get_subhomepage_where($suphomepageID)->row();
        $data['result'] = $subhomepage->getupper($menu_id);
        $page = "homepage/viewupper";
        $head = $data['submenu']->title;
        $this->output($data, $page, $head);
    }

}
