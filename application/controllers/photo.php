<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class photo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('photo_model','photo');
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

        $count = $this->photo->count();
        //$page = "web_page/news_all";
        $page = "album/index";
        $head = "อัลบั้ม / กิจกรรม";

        /*
          แบ่งหน้า
        */

        $config['base_url'] = site_url("photo/page");//url ของหน้าที่เราจะแบ่ง
        $config['total_rows'] = $count;//จำนวนอะไรบางอย่างทั้งหมดของเราโดยปกติจะใช้การนับจำนวนใน database เอา
        $config['per_page'] = 8;//จำนวนอะไรบางอย่างของเราต่อหนึ่งหน้า ซึ่งจะได้จำนวนหน้าทั้งหมดเท่ากับ total_rows/per_page
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

        $data['album'] = $this->photo->fetch_data($config['per_page'],0);

        $this->pagination->initialize($config);
        $data['s_pagination'] = $this->pagination->create_links();
        //$data['page'] = $page;

        //$this->load->view('pages/test', $a_data);

        $this->output($data, $page, $head);
    }

    public function page() {
        //$deta['new'] = $this->news->get_news();

        $count = $this->photo->count();
        //$page = "web_page/news_all";
        $page = "album/index";
        $head = "อัลบั้ม / กิจกรรม";

        /*
          แบ่งหน้า
        */

        $config['base_url'] = site_url("photo/page");//url ของหน้าที่เราจะแบ่ง
        $config['total_rows'] = $count;//จำนวนอะไรบางอย่างทั้งหมดของเราโดยปกติจะใช้การนับจำนวนใน database เอา
        $config['per_page'] = 8;//จำนวนอะไรบางอย่างของเราต่อหนึ่งหน้า ซึ่งจะได้จำนวนหน้าทั้งหมดเท่ากับ total_rows/per_page
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

        $data['album'] = $this->photo->fetch_data($config['per_page'],$this->uri->segment(3));

        $this->pagination->initialize($config);
        $data['s_pagination'] = $this->pagination->create_links();
        //$data['page'] = $page;

        //$this->load->view('pages/test', $a_data);

        $this->output($data, $page, $head);
    }

    public function get_album(){
      $id = $this->input->post('id');
      $rs = $this->photo->get_album($id);

      $json = array(
        "title" => $rs->title,
        "detail" => $rs->detail
      );

      echo json_encode($json);
    }

    public function gallery($album_id = null){
      $views = $this->photo->read_album($album_id);
      $newviews = ($views + 1);
      $columns = array("views" => $newviews);
      $this->db->where("id",$album_id);
      $this->db->update("album",$columns);

      $data['gallery'] = $this->photo->get_gallery($album_id);
      $data['album'] = $this->photo->get_album($album_id);
      $data['album_id'] = $album_id;
      $page = "gallery/show_gallery";
      $head = $data['album']->title;
      $this->output($data,$page,$head);

    }

}
