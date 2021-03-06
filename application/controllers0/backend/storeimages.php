<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class storeimages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('storeimages_model', 'model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function output($deta = '', $page = '', $head = '') {
        if (!empty($this->session->userdata['status']) && ($this->session->userdata['status'] == "S" || $this->session->userdata['status'] == "A")) {
            $data['detail'] = $deta;
            $data['page'] = $page;
            $data['head'] = $head;
            $this->load->view('template_admin', $data);
        } else {
            echo "<script>window.location='" . site_url('takmoph2014') . "'</script>";
        }
    }

    public function index() {
        $user_id = $this->session->userdata['user_id'];
        $data['folder'] = $this->model->get_folder_all($user_id);
        $page = "backend/storeimages/index";
        $head = "คลังรูปภาพ";

        $this->output($data, $page, $head);
    }

    public function createfolder() {
        $userid = $this->session->userdata('user_id');
        $foldername = $this->input->post('foldername');
        $pathFolder = "upload_images/" . $userid . "_" . $foldername;
        if (!is_dir($pathFolder)) {//เช็คว่ามีชื่อโฟล์เดอร์นี้หรือไม่
            mkdir($pathFolder, 0777, true);
            $columns = array(
                "folder_name" => $userid . "_" . $foldername,
                "user_id" => $userid,
                "create_date" => date("Y-m-d H:i:s")
            );
            $this->db->insert("storeimages_folder", $columns);
            echo "1";
        } else {
            echo "0";
        }
    }

    public function view() {
        $data['banner'] = $this->tak->get_banner();
        $page = "backend/banner/from_banner";
        $head = "BANNER";

        $this->output($data, $page, $head);
    }

    public function update_banner() {
        $data = array('status' => $_POST['status']);
        $this->db->where('id', $_POST['id']);
        $this->db->update('banner', $data);
    }

    public function delete_banner($id = '', $banner = '') {
        if ($banner != '') {
            unlink('images/images_slide/' . $banner);
        }

        $this->db->where('id', $id);
        $this->db->delete('banner');
        echo $this->tak->redir('backend/banner/view');
    }

    public function delete() {
        $id = $this->input->post('id');
        $result = $this->db->query("SELECT banner FROM banner WHERE id = '$id' ");
        $rs = $result->row();
        if ($rs->banner != '') {
            unlink('images/images_slide/' . $rs->banner);
        }

        $this->db->where('id', $id);
        $this->db->delete('banner');
    }

    public function upload() {
        //$targetFolder = base_url() . "images/images_slide";
        $targetFolder = 'images/images_slide'; // Relative to the root

        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $Name = "banner_" . random_string('alnum', 30) . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;
            //$targetFile = $targetFolder . '/' . $Name;
            // Validate the file type
            $fileTypes = array('jpg', 'png', 'gif', 'jpeg'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array($fileParts['extension'], $fileTypes)) {
                $file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $data = array(
                    'banner' => $Name
                );

                $this->db->insert('banner', $data);

                move_uploaded_file($tempFile, $targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

}
