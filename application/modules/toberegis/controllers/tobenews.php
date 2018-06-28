<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tobenews extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('tobeupload_model', 'upload');
        $this->load->model('tobenews_model', 'news');
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

    public function tobehome() {
        $type = $this->input->post('type');
        $data['news'] = $this->tobenews_model->GetnewsAll('10', $type);
        $page = "toberegis/tobenews/tobenewshome";
        $data['type'] = $type;
        $this->load->view($page, $data);
    }

    public function view($new_id = null, $typeID = null) {
        $new_ids = $this->takmoph_libraries->url_decode($new_id);
        $type = $this->news->Gettype($typeID);
        $data['type'] = $type;
        $maxread = $this->news->max_read($new_ids);
        $maxnew = ($maxread + 1);
        $columns = array("views" => $maxnew);
        $this->db->update("tobe_news", $columns, "id = '$new_ids' ");
        $data['near'] = $this->news->last_news();
        $data['hot'] = $this->news->hot();
        $data['news'] = $this->news->get_news_where($new_ids);
        $data['images'] = $this->news->get_images_news($new_ids);
        $data['images_first'] = $this->news->get_first_images_news($new_ids);
        $page = "toberegis/tobenews/view";
        $head = "ข่าว";
        $shareUrl = base_url() . "toberegis/tobenews/view/" . $new_id . "/" . $typeID;
        $imgfb = base_url() . "upload_images/news/" . $data['images_first'];
        $data['location'] = $this->tobeuser->Getlocation($data['news']->user_id, $data['news']->type);
        $this->session->set_userdata("fbtitle", $data['news']->title);
        $this->session->set_userdata("fbimages", $imgfb);
        $this->session->set_userdata("fburl", $shareUrl);

        $this->output($data, $page, $head);
    }

    public function newsall($typeID = "") {
        $types = $this->takmoph_libraries->url_decode($typeID);
        $type = $this->news->Gettype($types);
        $data['type'] = $type;
        $count = $this->news->countgroup($types);
        //$page = "web_page/news_all";
        $page = "toberegis/tobenews/index";
        
        if($typeID != ""){
            $data['type_id'] = $type->id;
            $head = $type->type;
        } else {
            $data['type_id'] = "";
            $head = "ทั้งหมด";
        }

        /*
          แบ่งหน้า
         */

        $config['total_rows'] = $count; //จำนวนอะไรบางอย่างทั้งหมดของเราโดยปกติจะใช้การนับจำนวนใน database เอา
        $config['per_page'] = 15; //จำนวนอะไรบางอย่างของเราต่อหนึ่งหน้า ซึ่งจะได้จำนวนหน้าทั้งหมดเท่ากับ total_rows/per_page
        $config['uri_segment'] = 5;

        $config['base_url'] = site_url("toberegis/tobenews/pagegroup/" . $this->uri->segment(5)); //url ของหน้าที่เราจะแบ่ง
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

        $data['new'] = $this->news->fetch_data_group($config['per_page'], $this->uri->segment(5), $types);

        $this->pagination->initialize($config);
        $data['s_pagination'] = $this->pagination->create_links();
        //$data['page'] = $page;
        //$this->load->view('pages/test', $a_data);

        $this->output($data, $page, $head);
    }

    public function pagegroup() {
        //$deta['new'] = $this->news->get_news();
        $typeID = $this->takmoph_libraries->url_decode($this->uri->segment(4));
        $type = $this->news->Gettype($typeID);
        $data['type'] = $type;
        $count = $this->news->countgroup($typeID);
        //$page = "web_page/news_all";
        $page = "toberegis/tobenews/index";
        $head = $type->type;

        /*
          แบ่งหน้า
         */

        $config['base_url'] = site_url("toberegis/tobenews/pagegroup/" . $this->uri->segment(4)); //url ของหน้าที่เราจะแบ่ง
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

        $data['new'] = $this->news->fetch_data_group($config['per_page'], $this->uri->segment(5), $types);

        $this->pagination->initialize($config);
        $data['s_pagination'] = $this->pagination->create_links();
        //$data['page'] = $page;
        //$this->load->view('pages/test', $a_data);

        $this->output($data, $page, $head);
    }

}
