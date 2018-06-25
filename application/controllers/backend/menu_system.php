<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class menu_system extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('formdownload_model', 'form');
        $this->load->model('upload_model', 'upload');
        $this->load->model('news_model', 'news');
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

    public function get_mas_from() {
        $data['mas_from'] = $this->form->get_mas_from();
        $page = "backend/form_download/mas_from";
        $head = 'แบบฟอร์มดาวส์โหลด';
        $this->output($data, $page, $head);
    }

    public function upload_images_system($system_id = '') {

        $sql = "SELECT * FROM menu_system WHERE system_id = '$system_id' ";
        $result = $this->db->query($sql)->row();

        if (!empty($result->system_images)) {
            unlink("icon_menu/" . $result->system_images);
        }

        $targetFolder = 'icon_menu'; // Relative to the root
        $toDatabase = true;
        if (!empty($_FILES)) {

            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $Name = "img_" . date('YmdHis') . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);

            if (in_array($fileParts['extension'], $fileTypes)) {
                $file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $data = array(
                    'system_images' => $Name
                );
                $this->db->where('system_id', $system_id);
                $this->db->update('menu_system', $data);
                //$query="INSERT INTO gallery (AlbumID,GalleryShot) VALUES ('$AlbumID','".$_FILES['Filedata']['name']."')";
                //$result = mysql_query($query);
                //mysql_free_result($result);
                move_uploaded_file($tempFile, $targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

}
