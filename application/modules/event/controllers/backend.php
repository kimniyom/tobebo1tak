<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class backend extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        //$this->load->model('upload_model', 'upload');
        //$this->load->model('event_model', 'event');

        $this->load->helper('url');
        $this->load->library('takmoph_libraries');
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
        $data[] = "";
        $this->output($data, $page, "ปฏิทินกิจกรรม");
    }

    public function Getevent() {
        $gData = $this->input->get('gData');
        $start = $this->input->get('start');
        $end = $this->input->get('end');
        /*
          $gData = $this->uri->segment(3);
          $start = $this->uri->segment(4);
          $end = $this->uri->segment(5);
         * 
         */
        if ($gData) {
            $q = "SELECT * FROM tbl_event WHERE date(event_start)>='$start'  ";
            $q.=" AND date(event_end)<='$end' ORDER by event_id";
            $result = $this->db->query($q);
            $json_data = array();
            foreach ($result->result() as $rs) {
                $json_data[] = array(
                    "id" => $rs->event_id,
                    "title" => $rs->event_title,
                    "start" => $rs->event_start,
                    "end" => $rs->event_end,
                    "color" => $rs->event_color,
                    "url" => "javascript:updateevent('" . $rs->event_id . "')",
                    "allDay" => ($rs->event_allDay == true) ? true : false

                        // กำหนด event object property อื่นๆ ที่ต้องการ
                );
            }
        }
        $json = json_encode($json_data);
        if (isset($_GET['callback']) && $_GET['callback'] != "") {
            echo $_GET['callback'] . "(" . $json . ");";
        } else {
            echo $json;
        }
    }

    public function Detail() {
        $event_id = $this->uri->segment(3);
        echo $event_id;
    }

    public function Thaidate() {
        $date = $this->uri->segment(4);
        $thisdate = $this->takmoph_libraries->thaidate($date);
        echo $thisdate;
    }

    public function Addevent() {
        $input = $this->input;
        $columns = array(
            "event_title" => $input->post('event_title'),
            "event_detail" => $input->post('event_detail'),
            "event_start" => $input->post('event_start'),
            "event_end" => $input->post('event_end'),
            "event_color" => $input->post('event_color'),
            "event_allDay" => true,
            "event_author" => $input->post('event_author'),
            "create_date" => date("Y-m-d H:i:s"),
            "d_update" => date("Y-m-d H:i:s")
        );

        $this->db->insert("tbl_event", $columns);

        $this->db->select_max('event_id');
        $result = $this->db->get('tbl_event')->row();

        $Author = $input->post('event_author');
        $columnlog = array(
            "event_id" => $result->event_id,
            "log" => $Author . " เพิ่ม event " . $input->post('event_title'),
            "author" => $Author,
            "user_id" => $this->session->userdata("user_id"),
            "ip" => $this->input->ip_address(),
            "d_update" => date("Y-m-d H:i:s")
        );

        $this->db->insert("tbl_event_log", $columnlog);
    }

    public function Updateevent() {
        $event_id = $this->input->post('event_id');
        $sql = "SELECT * FROM tbl_event WHERE event_id = '$event_id' ";
        $rs = $this->db->query($sql)->row();
        $data['event'] = $rs;
        $this->load->view("backend/update", $data);
    }

    public function Saveupdateevent() {
        $input = $this->input;
        $event_id = $input->post('event_id');
        $columns = array(
            "event_title" => $input->post('event_title'),
            "event_detail" => $input->post('event_detail'),
            "event_start" => $input->post('event_start'),
            "event_end" => $input->post('event_end'),
            "event_color" => $input->post('event_color'),
            "d_update" => date("Y-m-d H:i:s")
        );
        $this->db->where("event_id", $event_id);
        $this->db->update("tbl_event", $columns);
        
        $Author = $input->post('event_author');
        $columnlog = array(
            "event_id" => $event_id,
            "log" => $Author . " แก้ไข event ",
            "author" => $Author,
            "user_id" => $this->session->userdata("user_id"),
            "ip" => $this->input->ip_address(),
            "d_update" => date("Y-m-d H:i:s")
        );
        
        $this->db->insert("tbl_event_log", $columnlog);

    }

    public function Deleteevent() {
        $event_id = $this->input->post('event_id');
        
        $rs = $this->db->get_where("tbl_event",array("event_id" => $event_id))->row();
        $columnlog = array(
            "event_id" => $event_id,
            "log" => $rs->event_author . " ลบ event ",
            "author" => $rs->event_author,
            "user_id" => $this->session->userdata("user_id"),
            "ip" => $this->input->ip_address(),
            "d_update" => date("Y-m-d H:i:s")
        );
        
        $this->db->insert("tbl_event_log", $columnlog);
        
        $this->db->where('event_id', $event_id);
        $this->db->delete('tbl_event');
    }

    public function Log() {
        $data['result'] = $this->db->get("tbl_event_log");
        $this->load->view("backend/log",$data);
    }

}
