<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class asbforum extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('asbforum/asbforum_model', 'forum');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        //$template = $this->template_model->get_template();
        $this->load->view("asbforum/template", $data);
    }

    public function Index() {
        $page = "index";
        $data['lastpost'] = $this->forum->Lastpost();
        $data['category'] = $this->db->get_where("forum_category",array("active" => "Y","upper" => "0"));
        $this->output($data, $page, "ลงทะเบียน");
    }

    public function Send_complain() {
        $data = array(
            "name" => $this->input->post("name"),
            "email" => $this->input->post("email"),
            "card" => $this->input->post("card"),
            "tel" => $this->input->post("tel"),
            "head_complain" => $this->input->post("head_complain"),
            "detail" => $this->input->post("detail"),
            "d_update" => date("Y-m-d H:i:s"),
            "ip" => $this->input->ip_address()
        );

        $this->db->insert("complain", $data);
        /*
          $client = new SoapClient("http://tools.modoeye.com/thid/ws/?WSDL");
          $result = $client->Check(new SoapParam("1234567891011", "id"));
          var_dump($result);
         * 
         */
    }

    public function Success() {
        $page = "complain/success";
        $this->output("", $page, "เรื่องร้องทุกข์");
    }

    public function View() {
        $complain = new complain_model();
        $data['complain'] = $complain->Get_complainAll();
        $page = "complain/view";
        $this->output($data, $page, "เรื่องร้องทุกข์");
    }

    public function Detail() {
        $id = $this->uri->segment(3);
        $complain = new complain_model();
        $data['complain'] = $complain->Get_complain_By_id($id);

        $page = "complain/detail";
        $this->output($data, $page, "เรื่องร้องทุกข์");
    }

    public function Delet() {
        $id = $this->input->post("id");
        $this->db->where("id", $id);
        $this->db->delete("complain");
    }

}
