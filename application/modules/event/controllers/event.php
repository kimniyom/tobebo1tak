<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class event extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        //$this->load->model('upload_model', 'upload');
        //$this->load->model('event_model', 'event');
        $this->load->helper('url');
        $this->load->library('takmoph_libraries');
        $this->load->library('session');
        $this->load->helper('captcha');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        $template = $this->template_model->get_template();
        $this->load->view($template['template'], $data);
    }

    public function Index() {
        $page = "index";
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
            $q .= " AND date(event_end)<='$end' ORDER by event_id";
            $result = $this->db->query($q);
            $json_data = array();
            foreach ($result->result() as $rs) {
                if ($rs->event_end > $rs->event_start) {
                    $enddate = substr($rs->event_end, -2);
                    $enddates = substr($rs->event_end, 0, 7) . "-" . ($enddate + 1);
                } else {
                    $enddates = $rs->event_end;
                }
                $json_data[] = array(
                    "color" => $rs->event_color,
                    "id" => $rs->event_id,
                    "title" => $rs->event_title,
                    "start" => $rs->event_start,
                    "end" => $enddates,
                    "url" => "javascript:detailevent('" . $rs->event_id . "')",
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

    public function Detailevent() {
        $event_id = $this->input->post('event_id');
        $sql = "SELECT * FROM tbl_event WHERE event_id = '$event_id' ";
        $rs = $this->db->query($sql)->row();
        $data['event'] = $rs;
        $this->load->view("detail", $data);
    }

}
