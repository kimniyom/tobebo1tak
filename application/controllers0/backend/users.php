<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->model('news_model', 'news');
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

    public function index() {
        $data['user'] = $this->user->get_user();
        $head = "จัดการผู้ใช้งาน";
        $page = "backend/user/show_user";

        $this->output($data, $page, $head);
    }

    public function show_user() {
        $data['user'] = $this->user->get_user();
        $head = "จัดการผู้ใช้งาน";
        $page = "backend/user/show_user";

        $this->output($data, $page, $head);
    }

    public function save_user() {
        $data = array(
            'name' => $this->input->post('name'),
            'lname' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'card' => $this->input->post('card'),
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password')),
            'block' => '0',
            'status' => 'A',
            'create_date' => date("Y-m-d H:i:s"),
            'update_date' => date("Y-m-d H:i:s")
        );
        $this->db->insert('mas_user', $data);
        $user_id = $this->tak->max_id('mas_user', 'user_id');
        echo $this->tak->redir('backend/users/from_permissions/' . $user_id);
    }

    public function edit_user() {
        $user_id = $this->input->post('user_id');
        $password = $this->input->post('password');
        if ($password != "") {
            $data = array(
                'name' => $_POST['name'],
                'lname' => $_POST['lname'],
                'card' => $_POST['card'],
                'email' => $_POST['email'],
                'username' => $_POST['username'],
                'password' => md5($this->input->post('password')),
                'update_date' => date("Y-m-d H:i:s")
            );
        } else {
            $data = array(
                'name' => $_POST['name'],
                'lname' => $_POST['lname'],
                'card' => $_POST['card'],
                'email' => $_POST['email'],
                'username' => $_POST['username'],
                'update_date' => date("Y-m-d H:i:s")
            );
        }

        $this->db->where("user_id", $user_id);
        $this->db->update('mas_user', $data);
    }

    public function del_user() {
        $user_id = $this->input->post('id');
        $this->db->where('user_id', $user_id);
        $this->db->delete('mas_user');

        echo $this->tak->redir('takmoph_admin/show_user/');
    }

    public function from_permissions($user_id = null) {
        $data['user'] = $this->user->view($user_id);
        $data['menu_admin'] = $this->user->get_menu_permissions($user_id);
        $data['permission_homepage'] = $this->user->permissions_homepage($user_id);
        $data['permission_module'] = $this->user->permissions_module($user_id);
        $head = "สิทธิ์จัดการเมนูระบบไฟล์ Download";
        $page = "backend/user/show_permissions";

        $this->output($data, $page, $head);
    }

    public function add_permissions() {
        $data = array(
            'user_id' => $_POST['user_id'],
            'admin_menu_id' => $_POST['admin_menu_id']
        );
        $this->db->insert('permissions', $data);
    }

    public function del_permissions() {
        $id = $_POST['id'];
        $this->db->where('id', $id);
        $this->db->delete('permissions');
    }

    public function addpermission_homepage() {
        $input = $this->input;
        $columns = array(
            "homepage_id" => $input->post('homepage_id'),
            "user_id" => $input->post('user_id')
        );
        $this->db->insert("permission_homepage", $columns);
    }

    public function deletepermission_homepage() {
        $id = $this->input->post('id');
        $this->db->where("id", $id);
        $this->db->delete("permission_homepage");
    }

    public function addpermission_module() {
        $input = $this->input;
        $columns = array(
            "module" => $input->post('module_id'),
            "user_id" => $input->post('user_id')
        );
        $this->db->insert("permission_module", $columns);
    }

    public function deletepermission_module() {
        $id = $this->input->post('id');
        $this->db->where("id", $id);
        $this->db->delete("permission_module");
    }

    public function upload_images() {
        $user_id = $this->uri->segment(4);
        $users = $this->user->view($user_id);
        if ($users->images != "") {
            $checkfile = "upload_images/user/$users->images";
            if (file_exists($checkfile)) {
                unlink("upload_images/user/$users->images");
            }
        }
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
                $width = 120; //*** Fix Width & Heigh (Autu caculate) ***//
                //$new_images = "Thumbnails_".$_FILES["Filedata"]["name"];
                $size = getimagesize($_FILES['Filedata']['tmp_name']);
                $height = round($width * $size[1] / $size[0]);
                $images_orig = imagecreatefromjpeg($tempFile);
                $photoX = imagesx($images_orig);
                $photoY = imagesy($images_orig);
                $images_fin = imagecreatetruecolor($width, $height);
                imagecopyresampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
                imagejpeg($images_fin, "upload_images/user/" . $Name);
                imagedestroy($images_orig);
                imagedestroy($images_fin);

                $data = array(
                    'images' => $Name
                );
                $this->db->where('user_id', $user_id);
                $this->db->update('mas_user', $data);

                //move_uploaded_file($tempFile, $targetFile);
                echo $Name;
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function Getphoto() {
        $user_id = $this->input->post('user_id');
        $users = $this->user->view($user_id);
        if ($users->images != "") {
            echo "<img src='" . base_url() . "upload_images/user/" . $users->images . "' class='img-responsive'/>";
        }
    }

    public function Block() {
        $user_id = $this->input->post('user_id');
        $block = $this->input->post('type');

        $this->db->where("user_id", $user_id);
        $columns = array("block" => $block);
        $this->db->update("mas_user", $columns);
    }

    public function Updateprofile() {
        $user_id = $this->uri->segment(4);
        $data['user'] = $this->user->view($user_id);
        $head = "แก้ไข้ข้อมูล";
        $page = "backend/user/updateprofile";

        $this->output($data, $page, $head);
    }

    public function Profile($user_id = null) {
        $data['user'] = $this->user->view($user_id);
        $data['menu_admin'] = $this->user->get_menu_permissions($user_id);
        $data['permission_homepage'] = $this->user->permissions_homepage($user_id);
        $data['permission_module'] = $this->user->permissions_module($user_id);
        $head = "โปรไฟล์";
        $page = "backend/user/profile";

        $this->output($data, $page, $head);
    }

}
