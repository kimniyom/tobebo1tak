<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class config extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
        //$this->load->library('grocery_CRUD');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        //$template = $this->template_model->get_template();
        $this->load->view("template_admin", $data);
    }

    public function Index() {
        $this->db->select_max('id', 'ids');
        $result = $this->db->get('forum_config');  
        $id = $result->row()->ids;

        $query = $this->db->get_where("forum_config",array("id" => $id))->row();
        $data['config'] = $query; 
        $page = "config/index";
        $data['id'] = $id;
        $this->output($data, $page, "Config");
    }

    public function Saveconfig() {
        $id = $this->input->post('id');
        $columns = array(
            "title" => $this->input->post('title'),
            "smtp_server" => $this->input->post('smtp_server'),
            "smtp_username" => $this->input->post('smtp_username'),
            "smtp_password" => $this->input->post('smtp_password'),
            "port" => $this->input->post('port'),
            "email_send" => $this->input->post('email_send'),
            "name_send" => $this->input->post('name_send')
        );
        
        $this->db->where("id", $id);
        $this->db->update("forum_config", $columns);
    }

}
