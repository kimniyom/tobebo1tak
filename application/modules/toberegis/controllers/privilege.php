<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class privilege extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('toberegis/toberegis_model', 'model');
        $this->load->model('toberegis/report_model', 'report');
        $this->load->model('toberegis/users_model', 'usermodel');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('takmoph_libraries');
    }

    public function Auth(){
        if($this->session->userdata('status') == "S" || $this->session->userdata('user_register') != "" || !empty($this->session->userdata('user_register'))){
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
        $this->Auth();
        /*
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
        */
    }

    public function Checkprivilege(){
        $id = $this->session->userdata('user_register');
        if(empty($id)){
            $page = "users/checkprivilege";
            $data = "";
            $this->output($data, $page, "ตรวจสอบข้อมูล");
        } else {
            $eid = $this->takmoph_libraries->url_encode($id);
            redirect('/toberegis/toberegis/views/'.$eid, 'location');
        }
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
                    $this->session->set_userdata('user_register_name',$data->name);
                    echo "1";
                } else {
                    echo "0";
                }
            } else {
                echo "0";
            }
        
    }

    public function view(){
        if($this->Auth() == TRUE){
            $id = $this->session->userdata('user_register');
            $eid = $this->takmoph_libraries->url_encode($id);
            redirect('/toberegis/toberegis/views/'.$eid, 'location');
        }
        //$page = "users/view";
        //$data = "";
        //$this->output($data, $page, "ข้อมูลสมาชิก");
    }

    public function createuser(){
        $page = "users/create";
        $data['ampur'] = $this->model->Amphur();
        $data['type'] = $this->usermodel->typeuser();
        $head = "สมาชิก";
        $this->output($data,$page,$head);
    }

    public function saveuser(){
        $columns = array(
            "name" => $this->input->post('name'),
            "lname" => $this->input->post('lname'),
            "username" => $this->input->post('username'),
            "password" => $this->input->post('password'),
            "type" => $this->input->post('type')
        );
        $this->db->insert("tobe_user",$columns);

        $sql = "select max(id) as id from tobe_user";
        $query = $this->db->query($sql)->row();
        $data = array("id" => $query->id);
        echo json_encode($data);
    }

    public function detailuser($id){
        $this->db->where("id",$id);
        $data['user'] = $this->db->get("tobe_user")->row();

        $this->db->where("id",$data['user']->type);
        $data['type'] = $this->db->get("tobe_user_type")->row();
        $page = "users/detailuser";
        $head = $data['user']->name;
        $data['filter'] = $this->filter($data['user']->type);
        $this->output($data,$page,$head);
    }

    public function filter($type){
        $str = "";
        if($type == 2){
            $amphur = $this->model->Amphur();
            $str .= "<div class='col-md-3 col-lg-3'><label>อำเภอ</label>"; 
            $str .= "<select id='filter' class='form-control'>";
            foreach($amphur->result() as $rs):
                $str .= "<option value='".$rs->ampurcodefull."'>".$rs->ampurname."</option>";
            endforeach;
            $str .= "</select>";
            $str .= "</div>";
        } else if($type == 3){
             $amphur = $this->model->Amphur();
            $str .= "<div class='col-md-3 col-lg-3'>"; 
            $str .= "<select id='filter'>";
            foreach($amphur->result() as $rs):
                $str .= "<option value='".$rs->ampurcodefull."'>".$rs->ampurname."</option>";
            endforeach;
            $str .= "</select>";
            $str .= "</div>";
        } else if($type == 4){
            $amphur = $this->model->Amphur();
            $str .= "<div class='col-md-3 col-lg-3'>"; 
            $str .= "<select id='filter'>";
            foreach($amphur->result() as $rs):
                $str .= "<option value='".$rs->ampurcodefull."'>".$rs->ampurname."</option>";
            endforeach;
            $str .= "</select>";
            $str .= "</div>";
        }

        return $str;
    }

}
