<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class backend extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        //$this->load->model('upload_model', 'upload');
        //$this->load->model('news_model', 'news');
        $this->load->model('complain_model', 'complain');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        //$template = $this->template_model->get_template();
        $this->load->view("template_admin", $data);
    }

    public function Index() {
        $page = "backend/index";
        $year = $id = $this->uri->segment(4);
        $month = $id = $this->uri->segment(5);
        if (empty($year) && empty($month)) {
            $where = "1=1";
        } else if(!empty($year) && empty($month)){
            $where = " LEFT(d_update,4) = '$year'";
        } else {
            $where = " LEFT(d_update,4) = '$year' and substr(d_update,6,2) = '$month'";
        }
        $data['year'] = $year;
        $data['month'] = $month;
        $sql = "select * from complain where $where";
        $data['complain'] = $this->db->query($sql);
        $this->output($data, $page, "ร้องเรียน");
    }

    public function View() {
        $id = $id = $this->uri->segment(4);
        $complain = new complain_model();
        $data['datas'] = $complain->Get_complain_By_id($id);
        $page = "complain/backend/view";
        $this->output($data, $page, "complain");
    }

    public function Detail() {
        $id = $this->uri->segment(3);
        $complain = new complain_model();
        $data['complain'] = $complain->Get_complain_By_id($id);

        $page = "complain/detail";
        $this->output($data, $page, $id);
    }

    public function Delet() {
        $id = $this->input->post("id");
        $this->db->where("id", $id);
        $this->db->delete("complain");
    }

    public function Getimages() {
        $complain_id = $this->input->post('complain_id');
        //$this->db->where("complain_id",$complain_id);
        $query = $this->db->get_where('complain_images', array('complain_id' => $complain_id));
        foreach ($query->result() as $rs):
            echo "<img src='" . base_url() . "assets/module/complain/uploads/" . $rs->images . "' class='img-responsive'/><br/>";
        endforeach;
    }

}
