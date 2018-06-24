<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('toberegis/toberegis_model', 'model');
        $this->load->model('toberegis/report_model', 'report');
        $this->load->model('toberegis/users_model', 'usermodel');
        $this->load->model('toberegis/report_model', 'report');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
        $this->load->library('Ciqrcode', 'ciqrcode');
        $this->load->library('takmoph_libraries');
        $this->load->helper('cookie');
    }

    public function Auth() {
        if ($this->session->userdata('status') == "S" || $this->session->userdata('user_register') != "" || !empty($this->session->userdata('user_register')) || $this->session->userdata('tobe_user_id') != "") {
            return TRUE;
        } else {
            redirect('users/login', 'refresh');
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
        if ($this->Auth() == TRUE) {
            $sql = "select u.*,t.type as typename from tobe_user u inner join tobe_user_type t on u.type = t.id";
            $data['user'] = $this->db->query($sql);
            $page = "users/index";
            $this->output($data, $page, "ผู้ใช้งาน");
        }
    }

    public function Login() {
        $page = "users/login";
        $this->output("", $page, "Login");
    }

    public function checklogin() {
        $ip = $this->input->ip_address();

        $sqllock = "SELECT * FROM tobe_lock_ip WHERE ip = '$ip' ";
        $resultlock = $this->db->query($sqllock);
        if ($resultlock->num_rows > 0) {
            echo "lock";
            return false;
        }

        $datenow = date("Y-m-d");
        $sql = "SELECT COUNT(*) AS TOTAL FROM tobe_log_login WHERE ip = '$ip' AND LEFT(d_date,10) = '$datenow' AND status = 'Flase'";
        $rs = $this->db->query($sql)->row();

        //นับจำนวนการเข้าต่อวัน
        if ($rs->TOTAL > 50) {
            $lock = array(
                "ip" => $this->input->ip_address(),
                "d_update" => date("Y-m-d H:i:s")
            );
            $this->db->insert("tobe_lock_ip", $lock);
        } else {
            //รับค่า
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->usermodel->login($username); //หา user คนนี้ก่อน

            if (!empty($user->username)) {
                // compare passwords
                $checkPassword = $this->usermodel->check_password($password, $user->password);

                if ($checkPassword == 1) {
                    // mark user as logged in
                    $this->usermodel->auth($user->id);
                    $eid = $this->takmoph_libraries->url_encode($user->id);
                    $json = array("id" => $eid);
                    echo json_encode($json);
                } else {
                    $this->usermodel->savelog_login_flase($username, $password);
                    echo "0";
                }
            } else {
                $this->usermodel->savelog_login_flase($username, $password);
                echo "0";
            }
        }
    }

    public function Checkprivilege() {
        $id = $this->session->userdata('user_register');
        if (empty($id)) {
            $page = "users/checkprivilege";
            $data = "";
            $this->output($data, $page, "ตรวจสอบข้อมูล");
        } else {
            $eid = $this->takmoph_libraries->url_encode($id);
            redirect('/toberegis/toberegis/views/' . $eid, 'location');
        }
    }

    public function Checkprivileges() {
        $cid = trim($this->input->post('cid'));
        $birth = trim($this->input->post('birth'));

        $sql = "select * from tobe_register where md5(cid) = '$cid'";
        $result = $this->db->query($sql);
        $row = $result->num_rows();
        if ($row > 0) {
            $sql .= " and birth='$birth'";
            $results = $this->db->query($sql);
            $rows = $results->num_rows();
            if ($rows > 0) {
                $data = $results->row();
                $this->session->set_userdata('user_register', $data->id);
                $this->session->set_userdata('user_register_name', $data->name);
                echo "1";
            } else {
                echo "0";
            }
        } else {
            echo "0";
        }
    }

    public function view() {
        if ($this->Auth() == TRUE) {
            $id = $this->session->userdata('user_register');
            $eid = $this->takmoph_libraries->url_encode($id);
            redirect('/toberegis/toberegis/views/' . $eid, 'location');
        }
        //$page = "users/view";
        //$data = "";
        //$this->output($data, $page, "ข้อมูลสมาชิก");
    }

    public function createuser() {
        $checkStatus = $this->Auth();
        if ($checkStatus == TRUE) {
            $page = "users/create";
            $data['ampur'] = $this->model->Amphur();
            $data['type'] = $this->usermodel->typeuser();
            $head = "สมาชิก";
            $this->output($data, $page, $head);
        }
    }

    public function saveuser() {
        $columns = array(
            "name" => $this->input->post('name'),
            "lname" => $this->input->post('lname'),
            "username" => $this->input->post('username'),
            "password" => $this->input->post('password'),
            "type" => $this->input->post('type')
        );
        $this->db->insert("tobe_user", $columns);

        $sql = "select max(id) as id from tobe_user";
        $query = $this->db->query($sql)->row();
        $id = $this->takmoph_libraries->url_encode($query->id);
        $data = array("id" => $id);
        echo json_encode($data);
    }

    public function detailuser($eid) {
        $id = $this->takmoph_libraries->url_decode($eid);
        $checkStatus = $this->Auth();
        if ($checkStatus == TRUE) {
            $this->db->where("id", $id);
            $data['user'] = $this->db->get("tobe_user")->row();

            $this->db->where("id", $data['user']->type);
            $data['type'] = $this->db->get("tobe_user_type")->row();
            if ($this->session->userdata('status') == "S") {
                $page = "users/detailuserview";
            } else {
                $page = "users/detailuser";
            }
            $head = $data['user']->name;
            $this->db->where("user_id", $data['user']->id);
            $privilege = $this->db->get("tobe_user_privilege")->row();
            $data['filter'] = $this->filter($data['user']->type, $privilege->ampur, $privilege->privilege);
            $data['news'] = $privilege->news;
            $data['activity'] = $privilege->activity;
            $this->output($data, $page, $head);
        }
    }

    public function Privilege($eid) {
        $id = $this->takmoph_libraries->url_decode($eid);
        $checkStatus = $this->Auth();
        if ($checkStatus == TRUE) {
            $userprivilege = $this->usermodel->Checkprivilege($id);
            if ($userprivilege == "0") {
                $page = "users/privilege";
                $data['user'] = $this->usermodel->DetilUser($id);
                $head = $data['user']->name;
                $data['filter'] = $this->filter($data['user']->type);
                $data['flag'] = "save";
                $data['news'] = "";
                $data['activity'] = "";
                $this->output($data, $page, $head);
            } else {
                redirect("toberegis/users/detailuser/" . $eid, "refresh");
            }
        }
    }

    public function Saveprivilege() {
        $user_id = $this->input->post('user_id');
        $ampur = $this->input->post('ampur');
        $privilege = $this->input->post('filter');
        $news = $this->input->post('news');
        $activity = $this->input->post('activity');
        $columns = array(
            "user_id" => $user_id,
            "ampur" => $ampur,
            "privilege" => $privilege,
            "news" => $news,
            "activity" => $activity
        );
        $this->db->insert("tobe_user_privilege", $columns);
        $eid = $this->takmoph_libraries->url_encode($user_id);
        $json = array("id" => $eid);
        echo json_encode($json);
    }

    public function Privilegeupdate($eid) {
        $id = $this->takmoph_libraries->url_decode($eid);
        $checkStatus = $this->Auth();
        if ($checkStatus == TRUE) {
            $page = "users/privilege";
            $data['user'] = $this->usermodel->DetilUser($id);
            $head = $data['user']->name;
            $this->db->where("user_id", $data['user']->id);
            $privilege = $this->db->get("tobe_user_privilege")->row();
            $data['filter'] = $this->filter($data['user']->type, $privilege->ampur, $privilege->privilege);
            $data['flag'] = "update";
            $data['news'] = $privilege->news;
            $data['activity'] = $privilege->activity;
            $this->output($data, $page, $head);
        }
    }

    public function Updateprivilege() {
        $user_id = $this->input->post('user_id');
        $ampur = $this->input->post('ampur');
        $privilege = $this->input->post('filter');
        $news = $this->input->post('news');
        $activity = $this->input->post('activity');
        $columns = array(
            "user_id" => $user_id,
            "ampur" => $ampur,
            "privilege" => $privilege,
            "news" => $news,
            "activity" => $activity
        );
        $this->db->where("user_id", $user_id);
        $this->db->update("tobe_user_privilege", $columns);
        $eid = $this->takmoph_libraries->url_encode($user_id);
        $json = array("id" => $eid);
        echo json_encode($json);
    }

    public function checknulluser() {
        $username = $this->input->post('username');
        $this->db->where("username", $username);
        $query = $this->db->get("tobe_user");
        if ($query->num_rows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function filter($type, $ampur = null, $privilege = null) {
        $str = "";
        if ($type == 2) {
            $amphur = $this->model->Amphur();
            $str .= "<div class='col-md-3 col-lg-3'><label>อำเภอ</label>";
            $str .= "<select id='ampur' class='form-control'>";
            $str .= "<option value=''>== เลือกอำเภอ ==</option>";
            foreach ($amphur->result() as $rs):
                if ($ampur == $rs->ampurcodefull) {
                    $activeampur = "selected='selected'";
                } else {
                    $activeampur = "";
                }
                $str .= "<option value='" . $rs->ampurcodefull . "'" . $activeampur . ">" . $rs->ampurname . "</option>";
            endforeach;
            $str .= "</select>";
            $str .= "</div>";
        } else if ($type == 3) {
            $amphur = $this->model->Amphur();
            $str .= "<div class='col-md-3 col-lg-3'>";
            $str .= "<label>อำเภอ</label>";
            $str .= "<select id='ampur' class='form-control' onchange='getschool()'>";
            $str .= "<option value=''>== เลือกอำเภอ ==</option>";
            foreach ($amphur->result() as $rs):
                if ($ampur == $rs->ampurcodefull) {
                    $activeampur = "selected='selected'";
                } else {
                    $activeampur = "";
                }
                $str .= "<option value='" . $rs->ampurcodefull . "'" . $activeampur . ">" . $rs->ampurname . "</option>";
            endforeach;
            $str .= "</select>";
            $str .= "</div>";
            $str .= "<div class='col-md-4 col-lg-4'>";
            $str .= "<div id='filters'></div>";
            $str .= "</div>";
            $str .= "<script type='text/javascript'>";
            $str .= "$(document).ready(function(){getschool(" . $privilege . ");});";
            $str .= "</script>";
        } else if ($type == 4) {
            $amphur = $this->model->Amphur();
            $str .= "<div class='col-md-3 col-lg-3'>";
            $str .= "<label>อำเภอ</label>";
            $str .= "<select id='ampur' class='form-control' onchange='gettambon()'>";
            $str .= "<option value=''>== เลือกอำเภอ ==</option>";
            foreach ($amphur->result() as $rs):
                if ($ampur == $rs->ampurcodefull) {
                    $activeampur = "selected='selected'";
                } else {
                    $activeampur = "";
                }
                $str .= "<option value='" . $rs->ampurcodefull . "'" . $activeampur . ">" . $rs->ampurname . "</option>";
            endforeach;
            $str .= "</select>";
            $str .= "</div>";
            $str .= "<div class='col-md-4 col-lg-4'>";
            $str .= "<div id='filters'></div>";
            $str .= "</div>";
            $str .= "<script type='text/javascript'>";
            $str .= "$(document).ready(function(){gettambon(" . $privilege . ");});";
            $str .= "</script>";
        } else if ($type == 5) {
            $amphur = $this->model->Amphur();
            $str .= "<div class='col-md-3 col-lg-3'>";
            $str .= "<label>อำเภอ</label>";
            $str .= "<select id='ampur' class='form-control' onchange='getprisoner()'>";
            $str .= "<option value=''>== เลือกอำเภอ ==</option>";
            foreach ($amphur->result() as $rs):
                if ($ampur == $rs->ampurcodefull) {
                    $activeampur = "selected='selected'";
                } else {
                    $activeampur = "";
                }
                $str .= "<option value='" . $rs->ampurcodefull . "'" . $activeampur . ">" . $rs->ampurname . "</option>";
            endforeach;
            $str .= "</select>";
            $str .= "</div>";
            $str .= "<div class='col-md-4 col-lg-4'>";
            $str .= "<div id='filters'></div>";
            $str .= "</div>";
            $str .= "<script type='text/javascript'>";
            $str .= "$(document).ready(function(){getprisoner(" . $privilege . ");});";
            $str .= "</script>";
        } else if ($type == 6) {
            $amphur = $this->model->Amphur();
            $str .= "<div class='col-md-3 col-lg-3'>";
            $str .= "<label>อำเภอ</label>";
            $str .= "<select id='ampur' class='form-control' onchange='getcompany()'>";
            $str .= "<option value=''>== เลือกอำเภอ ==</option>";
            foreach ($amphur->result() as $rs):
                if ($ampur == $rs->ampurcodefull) {
                    $activeampur = "selected='selected'";
                } else {
                    $activeampur = "";
                }
                $str .= "<option value='" . $rs->ampurcodefull . "'" . $activeampur . ">" . $rs->ampurname . "</option>";
            endforeach;
            $str .= "</select>";
            $str .= "</div>";
            $str .= "<div class='col-md-4 col-lg-4'>";
            $str .= "<div id='filters'></div>";
            $str .= "</div>";
            $str .= "<script type='text/javascript'>";
            $str .= "$(document).ready(function(){getcompany(" . $privilege . ");});";
            $str .= "</script>";
        }

        return $str;
    }

    public function getschoolinampur() {
        $ampur = $this->input->post('ampur');
        $privilege = $this->input->post('privilege');
        $school = $this->model->GetSchoolInampur('63', $ampur);
        $str = "";
        $str .= "<label>โรงเรียน/สถานศึกษา</label>";
        $str .= "<select id='filter' class='form-control'>";
        foreach ($school->result() as $rs):
            if ($privilege == $rs->id) {
                $privilegeactive = "selected='selected'";
            } else {
                $privilegeactive = "";
            }
            $str .= "<option value='" . $rs->id . "'" . $privilegeactive . ">" . $rs->name . "</option>";
        endforeach;
        $str .= "</select>";
        echo $str;
    }

    public function gettamboninampur() {
        $ampur = $this->input->post('ampur');
        $privilege = $this->input->post('privilege');
        $school = $this->model->GetTambonInampur('63', $ampur);
        $str = "";
        $str .= "<label>ชุมชน</label>";
        $str .= "<select id='filter' class='form-control'>";
        foreach ($school->result() as $rs):
            if ($privilege == $rs->tamboncodefull) {
                $privilegeactive = "selected='selected'";
            } else {
                $privilegeactive = "";
            }
            $str .= "<option value='" . $rs->tamboncodefull . "'" . $privilegeactive . ">" . $rs->tambonname . "</option>";
        endforeach;
        $str .= "</select>";
        echo $str;
    }

    public function getprisonerinampur() {
        $ampur = $this->input->post('ampur');
        $privilege = $this->input->post('privilege');
        $prisoner = $this->model->GetPrisonerInampur('63', $ampur);
        $str = "";
        $str .= "<label>พฤตินิสัย</label>";
        $str .= "<select id='filter' class='form-control'>";
        foreach ($prisoner->result() as $rs):
            if ($privilege == $rs->id) {
                $privilegeactive = "selected='selected'";
            } else {
                $privilegeactive = "";
            }
            $str .= "<option value='" . $rs->id . "'" . $privilegeactive . ">" . $rs->name . "</option>";
        endforeach;
        $str .= "</select>";
        echo $str;
    }

    public function getcompanyinampur() {
        $ampur = $this->input->post('ampur');
        $privilege = $this->input->post('privilege');
        $company = $this->model->GetCompanyInampur('63', $ampur);
        $str = "";
        $str .= "<label>สถานประกอบการ/โรงงาน</label>";
        $str .= "<select id='filter' class='form-control'>";
        foreach ($company->result() as $rs):
            if ($privilege == $rs->id) {
                $privilegeactive = "selected='selected'";
            } else {
                $privilegeactive = "";
            }
            $str .= "<option value='" . $rs->id . "'" . $privilegeactive . ">" . $rs->name . "</option>";
        endforeach;
        $str .= "</select>";
        echo $str;
    }

    public function countperson() {
        $report = new report_model();
        $ampur = $this->input->post('ampur');
        $privilege = $this->input->post('privilege');
        $type = $this->input->post('type');
        if ($type != "2" || $type != "4") {
            $this->db->where("id", $privilege);
            $rs = $this->db->get("tobe_occupation")->row();
            $level = $rs->level;
            $levels = "level$level = '$privilege'";
            $total = $report->Countpersoninprivilege(63, $ampur, $levels, $type);
        } else if($type == "4"){
            
        }
        //echo $total;
        echo "จำนวน " . $total . " คน";
    }

}
