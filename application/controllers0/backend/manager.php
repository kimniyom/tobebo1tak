<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class manager extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->model('manager_model', 'model');
        $this->load->model('user', 'user');
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
            echo "<script>window.location='" . site_url('') . "'</script>";
        }
    }

    public function index(){
    	$result = $this->model->get_manager();
        $data['datas'] = $result->row();
        $page = "backend/manager/index";
        $head = 'ผู้บริหารองค์กร';
        $this->output($data, $page, $head);
    }

    public function upload() {

        if ($this->session->userdata('user_id') != '') {
            $targetFolder = 'upload_images/manager'; // Relative to the root
            $result = $this->model->get_manager();
            $rs = $result->row();
            if (!empty($_FILES)) {

                if(file_exists($targetFolder.'/'.$rs->images)){
                    unlink($targetFolder.'/'.$rs->images);
                }

                $tempFile = $_FILES['Filedata']['tmp_name'];
                $FULLNAME = $_FILES['Filedata']['name'];
                $type = substr($FULLNAME, -3);
                $Name = "IMG_" . random_string('alnum', 30) . "." . $type;
                $targetFile = $targetFolder . '/' . $Name;

                // Validate the file type
                $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG'); // File extensions
                $fileParts = pathinfo($_FILES['Filedata']['name']);
                if (in_array($fileParts['extension'], $fileTypes)) {
                    
                    $data = array(
                        'images' => $Name,
                    );
                    $this->db->where('id','1');
                    $this->db->update('manager', $data);

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

    public function loadmanager(){
        $data['datas'] = $this->model->get_manager();
        $page = "backend/manager/loadmanager";
        $this->load->view($page,$data);
    }

    public function save(){

        $columns = array(
            "name" => $this->input->post('name'),
            "position" => $this->input->post('position'),
            "detail" => $this->input->post('detail'),
            "active" => $this->input->post('active')
        );

        $this->db->update('manager',$columns,"id = '1'");
    }
}

?>