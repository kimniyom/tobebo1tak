<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class occupation extends CI_Controller {
    //public $levelold = 1;
    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
        $this->load->library('grocery_CRUD');
        
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        //$template = $this->template_model->get_template();
        $this->load->view("toberegis/template", $data);
    }

    public function Index($upper="0") {
        $page = "occupation/index";
        $data['upper'] = $upper;
        if($upper != 0){
            $this->db->where("id",$upper);
            $occupationname = $this->db->get_where("tobe_occupation")->row()->name;
        } else {
            $occupationname = "อาชีพ,สถานบริการ,หน่วยงาน,โรงเรียน";
        }
        $this->db->where("upper",$upper);
        $data['occupation'] = $this->db->get_where("tobe_occupation");
        $this->output($data, $page, $occupationname);
    }

    public function Create($upper="0") {
        $page = "occupation/create";
        $data['upper'] = $upper;
        
        if($upper != 0){
            $this->db->where("id",$upper);
            $occupationname = $this->db->get_where("tobe_occupation")->row()->name;
        } else {
            $occupationname = "เพิ่ม";
        }
        $sql = "select max(level) as maxlevel from tobe_occupation where id = '$upper'";
        $rs = $this->db->query($sql)->row();
        if($rs->maxlevel == 0){
            $data['level'] = 1;
        } else {
            $data['level'] = ($rs->maxlevel + 1);
        }
        $this->output($data, $page, $occupationname);
    }

    public function Save(){
        $code = $this->input->post('code');
        $name = $this->input->post('name');
        $final = $this->input->post('final');
        $upper = $this->input->post('upper');
        $level = $this->input->post('level');

        $columns = array(
            "code" => $code,
            "name" => $name,
            "final" => $final,
            "upper" => $upper,
            "level" => $level
        );
        $this->db->insert("tobe_occupation",$columns);
        //ดึงupper ไปเพิ่ม
        $sql = "select * from tobe_occupation order by id desc limit 1";
        $rs = $this->db->query($sql)->row();
        $json = array("id" => $rs->id,"upper" => $rs->upper);
        echo json_encode($json);
    }

    public function Filter(){
        $id = $this->input->post('id');
        $level = $this->input->post('level');
        $levels = ($level + 1);
        $levelID = "lv".$levels;
        //echo "<script type='text/javascript'>$('.".$levelID."').html('');</script>";
        if($id != ""){
        $str = "";
        $sql = "select * from tobe_occupation where upper = '$id' and upper != '0'";
        $query = $this->db->query($sql);
        $sqlfinal = "select final from tobe_occupation where id = '$id'";
        $row = $this->db->query($sqlfinal)->row();
            if($row->final == 0){
            $str .= "<select id='".$levelID."' class='form-control' onchange='getfilter(this.value,".$levels.")'>";
                $str .= "<option value=''>== กรุณาเลือก ==</option>";
                foreach($query->result() as $rs):
                    $str .= "<option value='".$rs->id."'>".$rs->name."</option>";
                endforeach;
                $str .= "</select>";
                echo $str;
            } else {
                echo "";
            }
        } else {
            echo "";
        }
    }

    function Checkmaxlevel($id){
        $sql = "select * from tobe_occupation where upper = '$id' group by upper";
        $query = $this->db->query($sql);
        $maxlevel = "";
        foreach($query->result() as $rs):
            if($rs->final == "0"){
                $this->Checkmaxlevel($rs->id);
            } else {
                $maxlevel = $rs->level;
                break;
            }
        endforeach;

        echo $maxlevel;
    }

    function getlevel(){
        $id = $this->input->post('id');
        $this->db->where("id",$id);
        $result = $this->db->get("tobe_occupation")->row();
        if(!empty($result) && $result->final == 0){
            $sql = "select * from tobe_occupation where upper = '$id' group by upper";
            $query = $this->db->query($sql);
            $maxlevel = "";
            $i=0;
            foreach($query->result() as $rs):
                $i++;
                if($rs->final == 0){
                    $this->getlevel($rs->id);
                } else {
                    $maxlevel = $rs->level;
                    break;
                    //echo $rs->id."Level".$rs->level;
                }
                if($i>3){
                    echo 1;
                    break;
                }
            endforeach;
            echo $maxlevel;
        } else {
            echo 1;
        }
    }


    public function createfilter($level){
        $str = "";
        for($i=1;$i<=$level;$i++):
        $str .= "<div class='col-md-3 col-lg-3'>";
        $str .= "<div id='level".$i."'>44444</div>";
        $str .= "</div>";
        endfor;

        echo $str;
    }

}
?>
