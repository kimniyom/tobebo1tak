<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class homepage extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->model('homepage_model', 'model');
        $this->load->model('sub_homepage_model');
        $this->load->model('user');
        $this->load->library('takmoph_libraries');
        $this->load->helper('url');
        $this->load->library('session');

        $user = $this->session->userdata('user_id');
        if (empty($user)) {
            echo $this->tak->redir('takmoph_admin');
        }
    }

    public function output($deta = '', $page = '', $head = '') {

        if (!empty($this->session->userdata['status']) && ($this->session->userdata['status'] == "S" || $this->session->userdata['status'] == "A")) {

            $data['detail'] = $deta;
            $data['page'] = $page;
            $data['head'] = $head;

            $this->load->view('template_admin', $data);
        } else {
            echo "<script>window.location='" . site_url('takmoph_admin') . "'</script>";
        }
    }

    public function index() {
        $model = new homepage_model();
        $data['type'] = $model->get_type();
        $data['mas_homepage'] = $model->get_menu();
        $page = "backend/homepage/index";
        $head = "ข้อมูลหน้าเว็บ";

        $this->output($data, $page, $head);
    }

    public function save() {
        $lib = new takmoph_model();
        $level = $lib->GetMaxId("menu_homepage", "level");
        $new_level = ($level + 1);
        $columns = array(
            "title_name" => $_POST['title_name'],
            "owner" => $_POST['owner'],
            "level" => $new_level,
            "create_date" => date("Y-m-d H:i:s"),
            "type_id" => $_POST['type_id'],
            "limit" => $_POST['limit'],
            "box_color" => $_POST['box_color'],
            "head_color" => $_POST['head_color']
        );

        $this->db->insert("menu_homepage", $columns);
    }

    public function update() {
        $Id = $this->input->post('id');
        $homepage = new homepage_model();

        $data['type'] = $homepage->get_type();
        $page = "backend/homepage/update";
        $data['result'] = $homepage->get_menu_where($Id)->row();
        //$head = $data['result']->title_name;
        $this->load->view($page, $data);
        //$this->output($data, $page, $head);
    }

    public function save_update_homepage() {
        $id = $_POST['id'];
        $columns = array(
            "title_name" => $_POST['title_name'],
            "type_id" => $_POST['type_id'],
            "limit" => $_POST['limit'],
            "box_color" => $_POST['box_color'],
            "head_color" => $_POST['head_color']
        );
        $this->db->update("menu_homepage", $columns, "id = '$id'");
    }

    public function upload() {
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

    public function delete() {
        $id = $this->input->post('id');
        $sql = "SELECT * FROM sub_homepage WHERE homepage_id = '$id' ";
        $homepage = $this->db->query($sql);
        if (!empty($homepage)) {
            foreach ($homepage->result() as $rs):
                $this->db->where("upper", $rs->id);
                $this->db->delete("sub_homepage");
            endforeach;
            //Delete Sub Homepage
            $this->db->where("homepage_id", $id);
            $this->db->delete("sub_homepage");
        }
        //Delete Homepage
        $this->db->where("id", $id);
        $this->db->delete("menu_homepage");
    }

    public function all() {
        $model = new homepage_model();
        $data['homepage'] = $model->get_menu();
        $page = "backend/homepage/all";
        $this->load->view($page, $data);
    }

    public function set_level() {
        $id = $this->input->post('id');
        $level = $this->input->post('level');

        $columns = array(
            "level" => $level
        );

        $this->db->where("id", $id);
        $this->db->update("menu_homepage", $columns);

        echo "ID = " . $id . " LEVEL = " . $level;
    }

}
