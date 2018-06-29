<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class toberegis extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('toberegis/toberegis_model', 'model');
        $this->load->model('toberegis/report_model', 'report');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
        $this->load->library('Ciqrcode', 'ciqrcode');
        $this->load->library('takmoph_libraries');
        $this->load->helper('cookie');
    }

    public function Auth(){
        if($this->session->userdata('status') == "S" || $this->session->userdata('user_register') != ""){
            return TRUE;
        } else {
            redirect('users/login','refresh');
        }
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
        $data['occupation'] = $this->model->Type();
        $data['amphur'] = $this->model->Amphur();
        $ReportAmphur = $this->report->GetreportAmphur();
        $ReportType = $this->report->GetreportType();
        $data['countall'] = $this->report->CountAll();
        $data['alcohol'] = $this->report->CountAlcohol();
        $data['smoking'] = $this->report->CountSmoking();
        $data['reason'] = $this->report->CountReason();
        foreach($ReportAmphur->result() as $rs):
            $ChartAmphurArr[] = "['".$rs->ampurname."',".$rs->total."]";
        endforeach;
        $sum = 0;
        foreach($ReportType->result() as $rss):
            if($rss->id != '3'){
                $sum = $sum + $rss->total;
                $ChartTypeArr[] = "{name:'".$rss->typename."',y:".$rss->total."}";
            } else if($rss->id == '3'){
                $ChartTypeArr[] .= "{name:'".$rss->typename."',y:".$sum."}";
            }
        endforeach;
        $data['chartamphur'] = implode(",",$ChartAmphurArr);
        $data['charttype'] = implode(",",$ChartTypeArr);
        $data['ReportType'] = $ReportType;
        $this->output($data, $page, "ลงทะเบียน");
    }

    public function Formregister() {
        $page = "formregister";
        $data['type'] = $this->model->Type();
        $data['amphur'] = $this->model->Amphur();
        $this->output($data, $page, "ลงทะเบียน");
    }

    public function Register(){
        $page = "formcreate";
        $this->db->where("level","1");
        $data['occupation'] = $this->db->get("tobe_occupation");
        $data['education'] = $this->db->get("tobe_education");
        $data['smoking'] = $this->db->get("tobe_smoking");
        $data['alcohol'] = $this->db->get("tobe_alcohol");
        $data['changwat'] = $this->db->get("cchangwat");
        $this->output($data, $page, "ลงทะเบียน");
    }

    public function Checkcid(){
        $cid = $this->input->post('cid');
        $sql = "SELECT * FROM tobe_register WHERE cid = '$cid'";
        $result = $this->db->query($sql);
        $rs = $result->row();
        if(!empty($rs->cid)){
            echo "1";
        } else {
            echo "0";
        }
    }

    public function Save(){
        $cid = $this->input->post('cid');
        $changwat = $this->input->post('changwat');
        $ampur = $this->input->post('ampur');
        $tambon = $this->input->post('tambon');
        $village = $this->input->post('village');
        $sex = $this->input->post('sex');
        $name = $this->input->post('name');
        $lname = $this->input->post('lname');
        $address = $this->input->post('address');
        $reason = $this->input->post('reason');
        $occupation = $this->input->post('occupation');
        $level2 = $this->input->post('lv2');
        $level3 = $this->input->post('lv3');
        $classroom = $this->input->post('classroom');
        $education = $this->input->post('education');
        $birth = $this->input->post('birth');
        $smoking = $this->input->post('smoking');
        $alcohol = $this->input->post('alcohol');

        $columns = array(
                "cid" => $cid,
                "name" => $name,
                "lname" => $lname,
                "address" => $address,
                "changwat" => $changwat,
                "ampur" => $ampur,
                "tambon" => $tambon,
                "village" => $village,
                "sex" => $sex,
                "birth" => $birth,
                "education" => $education,
                "occupation" => $occupation,
                "level2" => $level2,
                "level3" => $level3,
                "classroom" => $classroom,
                "smoking" => $smoking,
                "alcohol" => $alcohol,
                "reason" => $reason,
                "createdate" => date("Y-m-d")
        );

        $this->db->insert("tobe_register",$columns);
    }

    public function getampur(){
        $changwatcode = $this->input->post('changwatcode');
        $this->db->where("changwatcode",$changwatcode);
        $query = $this->db->get("campur");
        $data['ampur'] = $query;
        $this->load->view("ampur",$data);
    }

    public function gettambon(){
        $ampurcodefull= $this->input->post('ampurcodefull');
        $this->db->where("ampurcode",$ampurcodefull);
        $query = $this->db->get("ctambon");
        $data['tambon'] = $query;
        $this->load->view("tambon",$data);
    }

    public function getvillage(){
        $tamboncodefull= $this->input->post('tamboncodefull');
        $this->db->where("tamboncode",$tamboncodefull);
        $query = $this->db->get("cvillage");
        $data['village'] = $query;
        $this->load->view("village",$data);
    }

    public function success(){
        $page = "success";
        $data = "";
        $this->output($data, $page, "Success");
    }

    public function views($eid){
        $id = $this->takmoph_libraries->url_decode($eid);
        if($this->Auth() == TRUE){
            $page = "views";
            $this->db->where("id",$id);
            $data['datas'] = $this->db->get("tobe_register")->row();

            $data['occupation'] = $this->db->get("tobe_occupation");
            $data['education'] = $this->db->get("tobe_education");
            $data['smoking'] = $this->db->get("tobe_smoking");
            $data['alcohol'] = $this->db->get("tobe_alcohol");
            $data['changwat'] = $this->db->get("cchangwat");
            $data['level2'] = $this->occupation($data['datas']->level2);
            $data['level3'] = $this->occupation($data['datas']->level3);
            $this->output($data, $page, "ข้อมูลสมาชิก");
           
        }
    }

    function occupation($occ) {
        $this->db->where('id',$occ);
        $q = $this->db->get("tobe_occupation")->row();
        if($q){
            return $q->name;
        } else {
            return FALSE;
        }
    }

    
}
