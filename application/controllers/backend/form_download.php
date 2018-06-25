<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class form_download extends CI_Controller {

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

    public function from_edit_menu() {
        $mas_id = $_POST['mas_id'];
        $data['icon'] = $this->form->get_icon();
        $data['mas_menu'] = $this->form->get_mas_menu_where($mas_id);
        $this->load->view('backend/form_download/from_edit_menu', $data);
    }

    public function save_from() {
        $data = array(
            'mas_from' => $_POST['mas_from'],
            'from_status' => $_POST['from_status']
        );
        $this->db->insert('mas_from', $data);

        $sql = "SELECT MAX(id) AS from_id FROM mas_from ";
        $result = $this->db->query($sql);
        $row = $result->row();

        if ($_POST['from_status'] == '0') {
            $type = "0";
        } else {
            $type = "1";
        }

        $setdata = array(
            "type" => $type,
            "id" => $row->from_id
        );
        $json = json_encode($setdata);

        echo $json;
    }

    public function from_upload_file_from($formId = null) {
        $form = new formdownload_model();
        $masform = $form->get_mas_from_where($formId);
        $data['from_id'] = $formId;
        $data['title'] = $masform->mas_from;
        
        $page = "backend/form_download/upload_file_from";
        $head = "อัพโหลดฟอร์มเอกสาร";

        $this->output($data, $page, $head);
    }

    public function delete_mas_from() {
        $from_id = $_POST['from_id'];
        $file = $_POST['file'];
        if ($file == "") {
            $sql = "SELECT * FROM sub_from WHERE mas_id = '$from_id' ";
            $result = $this->db->query($sql);
            foreach ($result->result() as $rs):
                unlink('file_download/' . $rs->file);
            endforeach;
            $this->db->where('mas_id', $from_id);
            $this->db->delete('sub_from');
        } else {
            unlink('file_download/' . $file);
        }

        $this->db->where('id', $from_id);
        $this->db->delete('mas_from');
    }

    /* ################# จัดการเมนูแบบฟอร์ม ########################### */

    public function get_sub_from($from_id = '') {
        $mas_menu = $this->form->get_mas_from_where($from_id);
        $data['mas_from'] = $this->form->get_sub_from($from_id);
        $data['from_id'] = $from_id;
        $page = "backend/form_download/sub_from";
        $head = $mas_menu->mas_from;
        $this->output($data, $page, $head);
    }

    public function save_sub_from() {
        $data = array(
            'sub_name' => $_POST['sub_name'],
            'mas_id' => $_POST['from_id']
        );
        $this->db->insert('sub_from', $data);

        $sql = "SELECT MAX(sub_id) AS sub_id FROM sub_from ";
        $result = $this->db->query($sql);
        $row = $result->row();
        echo $row->sub_id;
    }

    public function from_upload_file_sub_from($mas_id = null, $sub_id = null) {
        $mas_menu = $this->form->get_mas_from_where($mas_id);
        $subform = $this->form->get_sub_from_where($sub_id);
        $data['masform'] = $mas_menu->mas_from;
        $data['mas_id'] = $mas_id;
        $data['sub_id'] = $sub_id;
        $data['title'] = $subform->sub_name;
        $page = "backend/form_download/upload_file_sub_from";
        $head = "อัพโหลดฟอร์มเอกสาร";

        $this->output($data, $page, $head);
    }

    public function file_upload_sub_from($sub_id = '') {
        $targetFolder = 'file_download'; // Relative to the root
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $Name = "file_" . random_string('alnum',30) . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;

            //$targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            $targetFile = $targetFolder . '/' . $Name;

            // Validate the file type
            $fileTypes = array('rar', 'zip', 'doc', 'ppt', 'pdf'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array($fileParts['extension'], $fileTypes)) {
                //$file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $data = array(
                    'file' => $Name
                );
                $this->db->where('sub_id', $sub_id);
                $this->db->update('sub_from', $data);
                move_uploaded_file($tempFile, $targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function file_upload_from($from_id = '') {
        $targetFolder = 'file_download'; // Relative to the root

        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $Name = "file_" . date('YmdHis') . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;
            //$targetFile = $targetFolder . '/' . $Name;

            // Validate the file type
            $fileTypes = array('rar', 'zip', 'doc', 'ppt', 'pdf'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array($fileParts['extension'], $fileTypes)) {
                $file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $data = array(
                    'file' => $Name
                );
                $this->db->where('id', $from_id);
                $this->db->update('mas_from', $data);

                move_uploaded_file($tempFile, $targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function delete_sub_from() {
        $sub_id = $_POST['sub_id'];
        $file = $_POST['file'];
        if ($file != '') {
            unlink('file_download/' . $file);
        }

        $this->db->where('sub_id', $sub_id);
        $this->db->delete('sub_from');
    }

    public function edit_mas_form() {
        $Id = $_POST['id'];
        $sql = "SELECT * FROM mas_from WHERE id = '$Id' ";
        $form = $this->db->query($sql)->row();
        $data['model'] = $form;
        $page = "backend/form_download/edit_mas_form";
        $this->load->view($page, $data);
        //$head = 'แบบฟอร์มดาวส์โหลด';
        //$this->output($data, $page, $head);
    }

    public function save_edit_mas_form() {
        $Id = $_POST['id'];
        $colimns = array("mas_from" => $_POST['mas_from']);
        $this->db->update("mas_from", $colimns, "id = '$Id' ");
    }

}
