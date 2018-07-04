<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tobeactivity extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('tobeupload_model', 'upload');
        $this->load->model('tobeactivity_model', 'activity');
        $this->load->model('users_model', 'tobeuser');
        $this->load->helper('url');
        $this->load->library('takmoph_libraries');
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->helper('string');
        $this->load->library('pagination');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        $template = $this->template_model->get_template();
        $this->load->view($template['template'], $data);
    }

    public function index() {
        $data['activity'] = $this->activity->getactivitylast(10);
        $page = "toberegis/tobeactivity/index";
        $this->load->view($page, $data);
        //$head = "รูปภาพกิจกรรม";
        //$this->output($data, $page, $head);
    }

    public function album_activity() {
        $activity_id = $this->input->post('activity_id');
        $data['images'] = $this->activity->get_images_activity($activity_id);
        $this->load->view("toberegis/activity/album_activity", $data);
    }

    public function view($eid) {
        $id = $this->takmoph_libraries->url_decode($eid);
        $data['activity'] = $this->db->get_where("tobe_activity", array("id" => $id))->row();
        $page = "toberegis/activity/view";
        $head = $data['activity']->title;
        $this->output($data, $page, $head);
    }

    public function all($typeID = "") {
        $types = $this->takmoph_libraries->url_decode($typeID);
        $type = $this->activity->Gettype($types);
        $data['type'] = $type;
        $count = $this->activity->countgroup($types);

        $page = "toberegis/tobeactivity/all";

        if ($typeID != "") {
            $data['type_id'] = $type->id;
            $head = $type->type;
            $pages = site_url("toberegis/tobeactivity/pagegroup/" . $typeID);
        } else {
            $data['type_id'] = "";
            $head = "ทั้งหมด";
            $pages = site_url("toberegis/tobeactivity/pageall/1");
        }

        /*แบ่งหน้า*/
        $config['total_rows'] = $count; //จำนวนอะไรบางอย่างทั้งหมดของเราโดยปกติจะใช้การนับจำนวนใน database เอา
        $config['per_page'] = 15; //จำนวนอะไรบางอย่างของเราต่อหนึ่งหน้า ซึ่งจะได้จำนวนหน้าทั้งหมดเท่ากับ total_rows/per_page
        $config['uri_segment'] = 5;

        $config['base_url'] = $pages; //url ของหน้าที่เราจะแบ่ง
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'หน้าแรก';
        $config['last_link'] = 'หน้าสุดท้าย';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $data['activity'] = $this->activity->fetch_data_group($config['per_page'], $this->uri->segment(5), $types);
        $this->pagination->initialize($config);
        $data['s_pagination'] = $this->pagination->create_links();
        //$data['page'] = $page;
        //$this->load->view('pages/test', $a_data);

        $this->output($data, $page, $head);
    }

    public function pagegroup() {
        //$deta['new'] = $this->news->get_news();
        $typeID = $this->takmoph_libraries->url_decode($this->uri->segment(4));
        $type = $this->activity->Gettype($typeID);
        $data['type'] = $type;
        $count = $this->activity->countgroup($typeID);
        //$page = "web_page/news_all";
        $page = "toberegis/tobeactivity/all";
        $head = $type->type;
        $data['type_id'] = $type->id;

        /*แบ่งหน้า*/

        $config['base_url'] = site_url("toberegis/tobeactivity/pagegroup/" . $this->uri->segment(4)); //url ของหน้าที่เราจะแบ่ง
        $config['total_rows'] = $count; //จำนวนอะไรบางอย่างทั้งหมดของเราโดยปกติจะใช้การนับจำนวนใน database เอา
        $config['per_page'] = 15; //จำนวนอะไรบางอย่างของเราต่อหนึ่งหน้า ซึ่งจะได้จำนวนหน้าทั้งหมดเท่ากับ total_rows/per_page
        $config['uri_segment'] = 5;
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'หน้าแรก';
        $config['last_link'] = 'หน้าสุดท้าย';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $data['activity'] = $this->activity->fetch_data_group($config['per_page'], $this->uri->segment(5), $typeID);

        $this->pagination->initialize($config);
        $data['s_pagination'] = $this->pagination->create_links();
        //$data['page'] = $page;
        //$this->load->view('pages/test', $a_data);

        $this->output($data, $page, $head);
    }

    public function pageall() {
        $count = $this->activity->countgroup("");
        $page = "toberegis/tobeactivity/all";
        $head = "ทั้งหมด";
        $data['type_id'] = "";

        /*
          แบ่งหน้า
         */

        $config['base_url'] = site_url("toberegis/tobeactivity/pageall/" . $this->uri->segment(4)); //url ของหน้าที่เราจะแบ่ง
        $config['total_rows'] = $count; //จำนวนอะไรบางอย่างทั้งหมดของเราโดยปกติจะใช้การนับจำนวนใน database เอา
        $config['per_page'] = 15; //จำนวนอะไรบางอย่างของเราต่อหนึ่งหน้า ซึ่งจะได้จำนวนหน้าทั้งหมดเท่ากับ total_rows/per_page
        $config['uri_segment'] = 5;
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'หน้าแรก';
        $config['last_link'] = 'หน้าสุดท้าย';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $data['activity'] = $this->activity->fetch_data_group($config['per_page'], $this->uri->segment(5), "");

        $this->pagination->initialize($config);
        $data['s_pagination'] = $this->pagination->create_links();
        //$data['page'] = $page;
        //$this->load->view('pages/test', $a_data);

        $this->output($data, $page, $head);
    }

}
