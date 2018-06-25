<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class background extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('menubar_model', 'menu');
        $this->load->model('background_model', 'bg');
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
        //$page = "web_page/news_all";
        $background = $this->bg->background_active_backend();
        if (substr($background, 0, 1) == "#") {
            $data['background'] = substr($background, 0, 1);
            $data['background'] = "<div class='img-responsive img-polaroi' style='height:150px; background:" . $background . "'</div>";
        } else {
            $base = base_url();
            $data['background'] = "<img src='" . $base . "upload_images/bg/" . $background . "' class='img-responsive img-polaroid' style='height:150px;'/>";
        }
        $page = "backend/background/index";
        $head = "ภาพพื้นหลัง";
        $data['bgname'] = $background;
        $this->output($data, $page, $head);
    }

    public function page() {
        $page = "backend/background/background";
        $data['bg'] = $this->bg->get_data();

        $this->load->view($page, $data);
    }

    public function bg_color() {
        $page = "backend/background/color";
        $data['bg'] = $this->bg->get_bg_color();

        $this->load->view($page, $data);
    }

    public function upload() {
        if ($this->session->userdata('user_id') != '') {
            $targetFolder = 'upload_images/bg'; // Relative to the root
            if (!empty($_FILES)) {

                $tempFile = $_FILES['Filedata']['tmp_name'];
                $FULLNAME = $_FILES['Filedata']['name'];
                $type = substr($FULLNAME, -3);
                $Name = "bg" . random_string('alnum', 30) . "." . $type;
                $targetFile = $targetFolder . '/' . $Name;

                //$targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
                $targetFile = $targetFolder . '/' . $Name;
                // Validate the file type
                $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG'); // File extensions
                $fileParts = pathinfo($_FILES['Filedata']['name']);
                if (in_array($fileParts['extension'], $fileTypes)) {
                    $file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                    $data = array(
                        'background' => $Name
                    );
                    $this->db->insert('background', $data);
                    move_uploaded_file($tempFile, $targetFile);
                    echo $Name;
                } else {
                    echo 'Invalid file type.';
                }
            }
        } else {
            echo "0";
        }
    }

    public function set_bg() {
        $id = $this->input->post('id');

        $clearConfig = array(
            "active" => "0"
        );
        $this->db->where("active", "1");
        $this->db->update("background", $clearConfig);

        $columns = array(
            "active" => '1'
        );
        $this->db->where("id", $id);
        $this->db->update("background", $columns);
    }

    public function add_color() {
        $color = $this->input->post('color');
        $columns = array("color" => $color);
        $this->db->insert("background_color", $columns);
    }

    public function delete_color() {
        $id = $this->input->post('id');
        $this->db->where("id", $id);
        $this->db->delete("background_color");
    }

    public function set_background() {
        $id = $this->input->post('id');
        $bg = $this->input->post('bg');
        if (substr($bg, 0, 1) == "#") {
            $data['background'] = "<div class='img-responsive img-polaroid' style='height:150px; background:" . $bg . "'</div>";
            $update = array("active" => '0');
            $this->db->where("active", "1");
            $this->db->update("background", $update);

            //set bg 
            $unset_color = array("active" => '0');
            $this->db->where("active", "1");
            $this->db->update("background_color", $unset_color);

            $set_color = array("active" => '1');
            $this->db->where("id", $id);
            $this->db->update("background_color", $set_color);
        } else {
            $base = base_url();
            $data['background'] = "<img src='" . $base . "upload_images/bg/" . $bg . "' class='img-responsive img-polaroid' style='height:150px;'/>";
            $update = array("active" => '0');
            $this->db->where("active", "1");
            $this->db->update("background_color", $update);

            //set bg 
            $unset_color = array("active" => '0');
            $this->db->where("active", "1");
            $this->db->update("background", $unset_color);

            $set_color = array("active" => '1');
            $this->db->where("id", $id);
            $this->db->update("background", $set_color);
        }

        $this->load->view("backend/background/example", $data);
    }
    
    public function delete(){
        $id = $this->input->post('id');
        $bg = $this->input->post('bg');
        
        unlink("upload_images/bg/".$bg);
        $this->db->where("id",$id);
        $this->db->delete("background");
    }

}
