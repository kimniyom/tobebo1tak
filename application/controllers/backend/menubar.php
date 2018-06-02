<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class menubar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('menubar_model', 'menu');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        $this->load->view('template_admin', $data);
    }

    public function index() {
        $model = new menubar_model();
        $sql = "SELECT * FROM style LIMIT 1";
        $result = $this->db->query($sql)->row();
        $data['navbar'] = $model->get_navbarmenu_all();
        $data['style'] = $result;
        $this->output($data, "backend/menubar/index", "MenuBar");
    }

    public function save_style() {
        $input = $this->input;
        $data = array(
            "webname_short" => $input->post('webname_short'),
            "webname_full" => $input->post('webname_full'),
            "color_navbar" => $input->post('color_navbar'),
            "color_text" => $input->post('color_text'),
            "color_head" => $input->post('color_head')
        );
        $this->db->where('id', '1');
        $this->db->update("style", $data);
    }

    public function save_navbar() {
        $data = array(
            'title' => $_POST['title'],
            'type' => $_POST['type']
        );
        $this->db->insert('navbarmenu', $data);
        $id = $this->tak->max_id('navbarmenu', 'id');
        $json = array("id" => $id);
        echo json_encode($json);
    }

    public function create_page($id = null) {
        $navbar = new menubar_model();
        $data['nav'] = $navbar->get_navbarmenu($id);
        $data['id'] = $id;
        $head = "สร้างหน้าเพจ";
        $page = "backend/menubar/create_page";

        $this->output($data, $page, $head);
    }

    public function save_page() {
        $data = array(
            'page' => $_POST['page']
        );
        $this->db->where("id", $_POST['id']);
        $this->db->update('navbarmenu', $data);
    }

    public function create_subpage($upper = null) {
        $data['upper'] = $upper;
        $head = "สร้างหน้าเพจ";
        $page = "backend/menubar/create_subpage";

        $this->output($data, $page, $head);
    }

    public function save_subpage() {
        $data = array(
            'title' => $_POST['title'],
            'page' => $_POST['page'],
            'upper' => $_POST['upper']
        );

        $this->db->insert('navbarmenu', $data);
    }

    public function view($Id = null) {
        $data['page'] = $this->menu->get_page($Id);
        $head = $data['page']->title;
        $page = "backend/menubar/view";
        $this->output($data, $page, $head);
    }

    public function update($Id = null) {
        $data['page'] = $this->menu->get_page($Id);
        $head = $data['page']->title;
        $page = "backend/menubar/update";
        $this->output($data, $page, $head);
    }

    public function save_update_page() {
        $input = $this->input;
        $columns = array(
            "title" => $input->post('title'),
            "page" => $input->post('page')
        );
        $this->db->where("id", $input->post('id'));
        $this->db->update("navbarmenu", $columns);
    }

    public function delete() {
        $id = $this->input->post('id');
        $sub = $this->menu->get_sub_navbarmenu($id);
        foreach ($sub->result() as $s):
            $this->db->where("id", $s->id);
            $this->db->delete("navbarmenu");
        endforeach;

        $this->db->where("id", $id);
        $this->db->delete("navbarmenu");
    }

    public function upload_logo() {
        $targetFolder = 'upload_images/logo'; // Relative to the root

        /* Remove File */
        $files = glob($targetFolder . '/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                unlink($file); // delete file
        }

        $toDatabase = true;
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $Name = "logo_" . date('YmdHis') . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;

            //$targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            $targetFile = $targetFolder . '/' . $Name;
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            //$GalleryShot = $_FILES['Filedata']['name'];
            if (in_array($fileParts['extension'], $fileTypes)) {
                $file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));
                $columns = array(
                    'logo' => $Name
                );
                $this->db->where('id', '1');
                $this->db->update('style', $columns);
                move_uploaded_file($tempFile, $targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function create_link($id = null) {
        $navbar = new menubar_model();
        $data['nav'] = $navbar->get_navbarmenu($id);
        $data['id'] = $id;
        $head = "สร้างลิงค์ไปยังเว็บไซต์ภายนอก";
        $page = "backend/menubar/create_link";

        $this->output($data, $page, $head);
    }

    public function save_link() {
        $data = array(
            'link' => $_POST['link']
        );
        $this->db->where("id", $_POST['id']);
        $this->db->update('navbarmenu', $data);
    }

    public function create_sublink($id = null) {
        $data['upper'] = $id;
        $head = "สร้างลิงค์ไปยังเว็บไซต์ภายนอก";
        $page = "backend/menubar/create_sublink";

        $this->output($data, $page, $head);
    }

    public function save_sublink() {
        $data = array(
            'title' => $_POST['title'],
            'link' => $_POST['link'],
            'upper' => $_POST['upper'],
            'type' => '2'
        );

        $this->db->insert('navbarmenu', $data);
    }

}
