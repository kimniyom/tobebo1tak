<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class photo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('photo_model', 'photo');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->helper('string');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;

        $this->load->view('template_admin', $data);
    }

    public function index() {
        //$deta['new'] = $this->news->get_news();
        $count = $this->photo->count();
        //$page = "web_page/news_all";
        $page = "backend/album/index";
        $head = "อัลบั้มทั้งหมด";

        /*
          แบ่งหน้า
         */

        $config['base_url'] = site_url("backend/photo/page"); //url ของหน้าที่เราจะแบ่ง
        $config['total_rows'] = $count; //จำนวนอะไรบางอย่างทั้งหมดของเราโดยปกติจะใช้การนับจำนวนใน database เอา
        $config['per_page'] = 8; //จำนวนอะไรบางอย่างของเราต่อหนึ่งหน้า ซึ่งจะได้จำนวนหน้าทั้งหมดเท่ากับ total_rows/per_page
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

        $data['album'] = $this->photo->fetch_data($config['per_page'], 0);

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
        $page = "backend/album/index";
        $head = "อัลบั้มทั้งหมด";

        /*
          แบ่งหน้า
         */

        $config['base_url'] = site_url("backend/photo/page"); //url ของหน้าที่เราจะแบ่ง
        $config['total_rows'] = $count; //จำนวนอะไรบางอย่างทั้งหมดของเราโดยปกติจะใช้การนับจำนวนใน database เอา
        $config['per_page'] = 8; //จำนวนอะไรบางอย่างของเราต่อหนึ่งหน้า ซึ่งจะได้จำนวนหน้าทั้งหมดเท่ากับ total_rows/per_page
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

        $data['album'] = $this->photo->fetch_data($config['per_page'], $this->uri->segment(4));

        $this->pagination->initialize($config);
        $data['s_pagination'] = $this->pagination->create_links();
        //$data['page'] = $page;
        //$this->load->view('pages/test', $a_data);

        $this->output($data, $page, $head);
    }

    public function save_album() {
        $columns = array(
            "title" => $this->input->post('title'),
            "detail" => $this->input->post('detail'),
            "owner" => $this->session->userdata('user_id'),
            "create_date" => date("Y-m-d")
        );

        $this->db->insert("album", $columns);

        //Get Last album
        $this->db->select("id");
        $this->db->from("album");
        $this->db->order_by("id", "DESC");
        $this->db->limit("1");
        $query = $this->db->get();
        $rs = $query->row();

        $json = array("id" => $rs->id);
        echo json_encode($json);
    }

    public function create_gallery($album_id = null) {
        $data['album'] = $this->photo->get_album($album_id);
        $data['first_album'] = $this->photo->get_first_album($album_id);
        $data['gallery'] = $this->photo->get_gallery($album_id);
        $data['album_id'] = $album_id;
        $page = "backend/gallery/create_gallery";
        $head = $data['album']->title;

        $this->output($data, $page, $head);
    }

    public function get_album() {
        $id = $this->input->post('id');
        $rs = $this->photo->get_album($id);

        $json = array(
            "title" => $rs->title,
            "detail" => $rs->detail
        );

        echo json_encode($json);
    }

    public function save_edit() {
        $id = $this->input->post('id');
        $columns = array(
            "title" => $this->input->post('title'),
            "detail" => $this->input->post('detail'),
            "owner" => $this->session->userdata('user_id')
        );
        $this->db->where("id", $id);
        $this->db->update("album", $columns);
    }

    public function uoload_gallery($album_id = null) {
        if ($this->session->userdata('user_id') != '') {
            //$targetFolder = 'upload_images/photo'; // Relative to the root
            if (!empty($_FILES)) {

                $tempFile = $_FILES['Filedata']['tmp_name'];
                $FULLNAME = $_FILES['Filedata']['name'];
                $type = substr($FULLNAME, -3);
                $Name = "photo_" . random_string('alnum', 30) . "." . $type;
                //$targetFile = $targetFolder . '/' . $Name;

                // Validate the file type
                $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG'); // File extensions
                $fileParts = pathinfo($_FILES['Filedata']['name']);
                if (in_array($fileParts['extension'], $fileTypes)) {
                    //$file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));
                    $width = 1280; //*** Fix Width & Heigh (Autu caculate) ***//
                    //$new_images = "Thumbnails_".$_FILES["Filedata"]["name"];
                    $size = getimagesize($_FILES['Filedata']['tmp_name']);
                    $height = round($width * $size[1] / $size[0]);
                    $images_orig = imagecreatefromjpeg($tempFile);
                    $photoX = imagesx($images_orig);
                    $photoY = imagesy($images_orig);
                    $images_fin = imagecreatetruecolor($width, $height);
                    imagecopyresampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
                    imagejpeg($images_fin, "upload_images/photo/" . $Name);
                    imagedestroy($images_orig);
                    imagedestroy($images_fin);

                    $data = array(
                        'images' => $Name,
                        'album_id' => $album_id
                    );
                    $this->db->insert('gallery', $data);

                    //move_uploaded_file($tempFile, $targetFile);
                    echo $Name;
                } else {
                    echo 'Invalid file type.';
                }
            }
        } else {
            echo "0";
        }
    }

    public function get_gallery() {
        $album_id = $this->input->post('album_id');
        $data['gallery'] = $this->photo->get_gallery($album_id);
        $data['album_id'] = $album_id;
        $this->load->view("backend/gallery/show_gallery", $data);
    }

    public function delete_images() {
        $id = $this->input->post('id');
        $this->db->select("images");
        $this->db->from("gallery");
        $this->db->where("id", $id);
        $this->db->limit("1");

        $rs = $this->db->get()->row();
        $images = $rs->images;
        if (!empty($images)) {
            unlink("upload_images/photo/" . $images);
        }

        $this->db->where("id", $id);
        $this->db->delete("gallery");

        echo $images;
    }

    public function delete_images_all() {
        $album_id = $this->input->post('album_id');
        $gallery = $this->photo->get_gallery($album_id);
        foreach ($gallery->result() as $rs):
            unlink("upload_images/photo/" . $rs->images);
        endforeach;
        $this->db->where("album_id", $album_id);
        $this->db->delete("gallery");
    }

    public function delete_album() {
        $album_id = $this->input->post('album_id');
        $gallery = $this->photo->get_gallery($album_id);
        foreach ($gallery->result() as $rs):
            unlink("upload_images/photo/" . $rs->images);
        endforeach;
        $this->db->where("album_id", $album_id);
        $this->db->delete("gallery");

        $this->db->where("id", $album_id);
        $this->db->delete("album");
    }

}
