<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class footer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('menubar_model', 'menu');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        $this->load->view('template_admin', $data);
    }

    public function index() {
        $model = new menubar_model();
        $sql = "SELECT * FROM style LIMIT 1";
        $result = $this->db->query($sql)->row();
        $data['style'] = $result;
        $this->output($data, "backend/footer/index", "Footer");
    }

    public function update(){
      $input = $this->input;
      $columns = array(
        "footer" => $input->post('footer')
      );
      $this->db->where("id","1");
      $this->db->update("style",$columns);
    }



}
