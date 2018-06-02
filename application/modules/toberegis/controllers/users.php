<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('toberegis/toberegis_model', 'model');
        $this->load->model('toberegis/report_model', 'report');
        $this->load->model('toberegis/users_model', 'model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
        $this->load->library('Ciqrcode', 'ciqrcode');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        //$template = $this->template_model->get_template();
        $this->load->view("toberegis/template", $data);
    }

    public function Index() {
        $page = "index";
        $data['type'] = $this->model->Type();
        $data['amphur'] = $this->model->Amphur();
        $ReportAmphur = $this->report->GetreportAmphur();
        $ReportType = $this->report->GetreportType();
        $data['countall'] = $this->report->CountAll();
        foreach($ReportAmphur->result() as $rs):
            $ChartAmphurArr[] = "['".$rs->distname."',".$rs->total."]";
        endforeach;

        foreach($ReportType->result() as $rss):
            $ChartTypeArr[] = "{name:'".$rss->typename."',y:".$rss->total."}";
        endforeach;
        $data['chartamphur'] = implode(",",$ChartAmphurArr);
        $data['charttype'] = implode(",",$ChartTypeArr);
        $data['ReportType'] = $ReportType;
        $this->output($data, $page, "ลงทะเบียน");
    }

    public function Checkprivilege(){
        $page = "users/checkprivilege";
        $data = "";
        $this->output($data, $page, "ตรวจสอบข้อมูล");
    }

    public function Checkprivileges(){
        $cid = trim($this->input->post('cid'));
        $birth = trim($this->input->post('birth'));
        $sql = "select * from tobe_register where cid = '$cid'";
        $result = $this->db->query($sql);
        $row = $result->num_rows();
        if($row > 0){
            $sql .= " and birth='$birth'";
            $results = $this->db->query($sql);
            $rows = $results->num_rows();
            if($rows > 0){
                $data = $results->row();
                $this->session->set_userdata('user_register',$data->id);
                echo "1";
            } else {
                echo "0";
            }
        } else {
            echo "0";
        }
    }

    public function view(){
        $page = "users/view";
        $data = "";
        $this->output($data, $page, "ข้อมูลสมาชิก");
    }

}
