<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class newexpress extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->model('newexpress_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function output($deta = '', $page = '', $head = '') {

        if (!empty($this->session->userdata['status']) && ($this->session->userdata['status'] == "S" || $this->session->userdata['status'] == "A")) {

            $data['detail'] = $deta;
            $data['page'] = $page;
            $data['head'] = $head;

            $this->load->view('template_admin', $data);
        } else {
            echo "<script>window.location='" . site_url('takmoph2014') . "'</script>";
        }
    }

    public function Index() {
        $express = new newexpress_model();
     
        $sql = "SELECT * FROM style";
        $rs = $this->db->query($sql)->row();
        $data['setactive'] = $rs->activeexpress;
        $data['express'] = $express->get_express();
        $page = "backend/new_express/index";
        $head = "ประกาศด่วน";

        $this->output($data, $page, $head);
    }

    public function Create() {
        $head = "สร้าง ประกาศ(ด่วน)";

        $this->output("", "backend/new_express/create", $head);
    }

    public function save() {
        $tak = new takmoph_model();
        $data = array(
            'title' => $_POST['title'],
            'detail' => $_POST['detail'],
            'owner' => $this->session->userdata('user_id'),
            'create_date' => date('Y-m-d H:i:s')
        );
        $this->db->insert('new_express', $data);
        $Id = $tak->GetMaxId("new_express", "id");

        echo $Id;
    }

    public function view($id = null) {
        $model = new newexpress_model();
        $data['model'] = $model->get_detail($id)->row();
        $head = $data['model']->title;
        $this->output($data, "backend/new_express/view", $head);
    }

    public function update($id = null) {
        $model = new newexpress_model();
        $data['model'] = $model->get_detail($id)->row();
        $head = "แก้ไข";
        $this->output($data, "backend/new_express/update", $head);
    }

    public function save_update() {
        $id = $_POST['id'];
        $data = array(
            'title' => $_POST['title'],
            'detail' => $_POST['detail']
        );
        $this->db->where('id', $id);
        $this->db->update('new_express', $data);

        echo $id;
        //echo $this->tak->redir('takmoph_admin/get_news/');
    }

    public function delete() {
        $id = $this->input->post('id');

        $this->db->where('id', $id);
        $this->db->delete('new_express');
    }
    
    public function setactive(){
        $val = $this->input->post('val');
        $columns = array("activeexpress" => $val);
        $this->db->update("style",$columns,'id = 1');
    }

}
