<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class news extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->model('news_model', 'news');
        $this->load->model('groupnews_model', 'groupnews');
        $this->load->helper('url');
        $this->load->library('session');
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
        //$deta['new'] = $this->news->get_news();

        $count = $this->news->count();
        //$page = "web_page/news_all";
        $page = "news/index";
        $head = "ข่าวทั้งหมด";

        /*
          แบ่งหน้า
         */

        $config['base_url'] = site_url("news/page"); //url ของหน้าที่เราจะแบ่ง
        $config['total_rows'] = $count; //จำนวนอะไรบางอย่างทั้งหมดของเราโดยปกติจะใช้การนับจำนวนใน database เอา
        $config['per_page'] = 8; //จำนวนอะไรบางอย่างของเราต่อหนึ่งหน้า ซึ่งจะได้จำนวนหน้าทั้งหมดเท่ากับ total_rows/per_page
        $config['uri_segment'] = 3;

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

        $data['new'] = $this->news->fetch_data($config['per_page'], $this->uri->segment(3));

        $this->pagination->initialize($config);
        $data['s_pagination'] = $this->pagination->create_links();
        //$data['page'] = $page;
        //$this->load->view('pages/test', $a_data);

        $this->output($data, $page, $head);
    }

    public function page() {
        //$deta['new'] = $this->news->get_news();

        $count = $this->news->count();
        //$page = "web_page/news_all";
        $page = "news/index";
        $head = "ข่าวทั้งหมด";

        /*
          แบ่งหน้า
         */

        $config['base_url'] = site_url("news/page"); //url ของหน้าที่เราจะแบ่ง
        $config['total_rows'] = $count; //จำนวนอะไรบางอย่างทั้งหมดของเราโดยปกติจะใช้การนับจำนวนใน database เอา
        $config['per_page'] = 8; //จำนวนอะไรบางอย่างของเราต่อหนึ่งหน้า ซึ่งจะได้จำนวนหน้าทั้งหมดเท่ากับ total_rows/per_page
        $config['uri_segment'] = 3;

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

        $data['new'] = $this->news->fetch_data($config['per_page'], $this->uri->segment(3));

        $this->pagination->initialize($config);
        $data['s_pagination'] = $this->pagination->create_links();
        //$data['page'] = $page;
        //$this->load->view('pages/test', $a_data);

        $this->output($data, $page, $head);
    }

    public function show_detail_news($new_id = '') {
        $data['news'] = $this->news->get_news_where($new_id);
        $data['images'] = $this->news->get_images_news($new_id);
        $data['images_first'] = $this->news->get_first_images_news($new_id);
        $page = "web_page/detail_news";
        $head = "ข่าวประชาสัมพันธ์";

        $this->output($data, $page, $head);
    }

    public function view($new_id = null, $group_id = null) {
        $new_ids = $this->takmoph_libraries->decode($new_id);
        /*
        $group_ids = $this->takmoph_libraries->decode($group_id);
         * 
         */
        $group_ids  = $group_id;
        $group = $this->groupnews->get_groupnews_where($group_ids);
        $data['group'] = $group;
        $maxread = $this->news->max_read($new_ids);
        $maxnew = ($maxread + 1);
        $columns = array("views" => $maxnew);
        $this->db->update("tb_news", $columns, "id = '$new_ids' ");
        $data['near'] = $this->news->last_news();
        $data['hot'] = $this->news->hot();
        $data['news'] = $this->news->get_news_where($new_ids);
        $data['images'] = $this->news->get_images_news($new_ids);
        $data['images_first'] = $this->news->get_first_images_news($new_ids);
        $page = "news/view";
        $head = "ข่าว";

        $shareUrl = base_url()."new/view/".$new_id."/".$group_id;
        $imgfb = base_url() . "upload_images/news/" . $data['images_first'];
        
        $this->session->set_userdata("fbtitle", $data['news']->titel);
        //$this->session->set_userdata("fbdetail", mb_substr($data['news']->detail, 0, 300, 'UTF-8') . "...");
        $this->session->set_userdata("fbimages", $imgfb);
        $this->session->set_userdata("fburl", $shareUrl);

        $this->output($data, $page, $head);
    }

    public function page_news() {
        $this->load->view('from/page_news');
    }

    public function newsall($groupids) {
        //$deta['new'] = $this->news->get_news();
        $groupid = $this->takmoph_libraries->decode($groupids);
        $group = $this->groupnews->get_groupnews_where($groupid);
        $data['group'] = $group;
        $count = $this->news->countgroup($groupid);
        //$page = "web_page/news_all";
        $page = "news/index";
        $head = $group->groupname;

        /*
          แบ่งหน้า
         */

        $config['total_rows'] = $count; //จำนวนอะไรบางอย่างทั้งหมดของเราโดยปกติจะใช้การนับจำนวนใน database เอา
        $config['per_page'] = 15; //จำนวนอะไรบางอย่างของเราต่อหนึ่งหน้า ซึ่งจะได้จำนวนหน้าทั้งหมดเท่ากับ total_rows/per_page
        $config['uri_segment'] = 4;

        $config['base_url'] = site_url("news/pagegroup/" . $this->uri->segment(3)); //url ของหน้าที่เราจะแบ่ง
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

        $data['new'] = $this->news->fetch_data_group($config['per_page'], $this->uri->segment(4), $groupid);

        $this->pagination->initialize($config);
        $data['s_pagination'] = $this->pagination->create_links();
        //$data['page'] = $page;
        //$this->load->view('pages/test', $a_data);

        $this->output($data, $page, $head);
    }

    public function pagegroup() {
        //$deta['new'] = $this->news->get_news();
        $groupID = $this->takmoph_libraries->decode($this->uri->segment(3));
        $group = $this->groupnews->get_groupnews_where($groupID);
        $data['group'] = $group;
        $count = $this->news->countgroup($groupID);
        //$page = "web_page/news_all";
        $page = "news/index";
        $head = $group->groupname;

        /*
          แบ่งหน้า
         */

        $config['base_url'] = site_url("news/pagegroup/" . $this->uri->segment(3)); //url ของหน้าที่เราจะแบ่ง
        $config['total_rows'] = $count; //จำนวนอะไรบางอย่างทั้งหมดของเราโดยปกติจะใช้การนับจำนวนใน database เอา
        $config['per_page'] = 15; //จำนวนอะไรบางอย่างของเราต่อหนึ่งหน้า ซึ่งจะได้จำนวนหน้าทั้งหมดเท่ากับ total_rows/per_page
        $config['uri_segment'] = 4;
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

        $data['new'] = $this->news->fetch_data_group($config['per_page'], $this->uri->segment(4), $groupID);

        $this->pagination->initialize($config);
        $data['s_pagination'] = $this->pagination->create_links();
        //$data['page'] = $page;
        //$this->load->view('pages/test', $a_data);

        $this->output($data, $page, $head);
    }

}
