<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class menager_menu extends CI_Controller {
    /*
     *  Creart Code By kimniyom
     *  Date 27/05/2556 | Time 22.26.00
     *
     */

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('Ciqrcode', 'ciqrcode');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        $this->load->view('template_admin', $data);
    }

    public function get_mas_menu() {
        $data['mas_menu'] = $this->tak->get_mas_menu();
        $data['icon'] = $this->tak->get_icon();
        $page = "backend/menu/mas_menu";
        $head = 'จัดการเมนูเว็บไซต์';
        $this->output($data, $page, $head);
    }

    public function save_menu() {
        $level = $this->tak->max_id('mas_menu', 'level');
        $link = $_POST['_link'];
        if ($link != '') {
            //$linkmenu = "takmoph_admin/get_dengue";
            //updatecode 2016-01-22 By Kimniyom
            $linkmenu = "menu/filemenu";
        } else {
            $linkmenu = "";
        }
        $data = array(
            'mas_menu' => $_POST['mas_menu'],
            'mas_status' => $_POST['mas_status'],
            'icon_id' => $_POST['icon_id'],
            'bgcolor' => $_POST['bgcolor'],
            'textcolor' => $_POST['textcolor'],
            'link' => $linkmenu,
            'link_out' => $_POST['link_out'],
            'admin_menu_id' => $_POST['_link'],
            'level' => ($level + 1)
        );
        $this->db->insert('mas_menu', $data);
    }

    public function save_edit_menu() {
        $data = array(
            'mas_menu' => $_POST['mas_menu'],
            'icon_id' => $_POST['icon_id'],
            'bgcolor' => $_POST['bgcolor'],
            'textcolor' => $_POST['textcolor'],
            'link' => $_POST['_link']
        );
        $this->db->where('id', $_POST['mas_id']);
        $this->db->update('mas_menu', $data);
    }

    public function delete_mas_menu() {
        $mas_id = $_POST['mas_id'];
        $mas_menu = $this->tak->get_mas_menu_where($mas_id);

        if ($mas_menu->mas_status == '0') {
            unlink('./application/views/from/' . $mas_menu->link . ".php");
        } else {
            $sub_menu = $this->tak->get_sub_menu($mas_id);
            foreach ($sub_menu->result() as $sub):
                unlink('file_download/' . $sub->file);
            endforeach;
        }

        $this->db->where('id', $mas_id);
        $this->db->delete('mas_menu');
    }

    public function from_edit_menu() {
        $mas_id = $_POST['mas_id'];
        $data['icon'] = $this->tak->get_icon();
        $data['mas_menu'] = $this->tak->get_mas_menu_where($mas_id);
        $this->load->view('backend/menu/from_edit_menu', $data);
    }

    public function get_icon() {
        $icon_id = $_POST['icon_id'];
        $data['icon'] = $this->tak->get_icon_menu($icon_id);
        $this->load->view('backend/icon/show_icon', $data);
    }

    public function get_sub_menu($mas_id = '') {
        $data['mas_id'] = $mas_id;
        $data['sub_menu'] = $this->tak->get_sub_menu($mas_id);
        $page = 'backend/menu/show_sub_menu';
        $data['row'] = $this->tak->get_mas_menu_where($mas_id);
        $head = $data['row']->mas_menu;

        $this->output($data, $page, $head);
    }

    public function add_sub_menu() {
        $data_save = array(
            'sub_name' => $_POST['sub_name'],
            'link' => $_POST['_link'],
            'mas_id' => $_POST['mas_id'],
            "owner" => $this->session->userdata('user_id'),
            'd_update' => date("Y-m-d H:i:s")
        );
        $this->db->insert('sub_menu', $data_save);

        if ($_POST['type_sub_menu'] == 0) {
            $sql = "SELECT MAX(sub_id) AS sub_id FROM sub_menu";
            $result = $this->db->query($sql);
            $row = $result->row();
            echo $this->tak->redir('menager_menu/view/' . $row->sub_id . '/' . $_POST['mas_id']);
        } else {
            echo $this->tak->redir('menager_menu/get_sub_menu/' . $_POST['mas_id']);
        }
    }

    public function view($sub_id = '', $mas_id = '') {
        $data['mas_id'] = $mas_id;
        $data['sub_id'] = $sub_id;

        $sql = "SELECT *
                    FROM sub_menu_file s 
                    WHERE s.submenu_id = '$sub_id' ";
        $data['file'] = $this->db->query($sql);

        $data['sub_menu'] = $this->tak->get_sub_menu_where($sub_id);
        $data['mas_menu'] = $this->tak->get_mas_menu_where($mas_id);
        $data['title'] = $data['sub_menu']->sub_name;
        $page = "backend/menu/view";
        $head = $data['sub_menu']->sub_name;

        $this->output($data, $page, $head);
    }

    public function file_upload_submenu($sub_id = '') {
        $targetFolder = 'file_download'; // Relative to the root

        $toDatabase = true;
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $NameFile = "file_" . date('YmdHis');
            $Name = $NameFile . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;

            //$targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            $targetFile = $targetFolder . '/' . $Name;
            // Validate the file type
            $fileTypes = array('rar', 'zip', 'doc', 'ppt', 'pdf', 'PDF'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            //$file = $_FILES['Filedata']['name'];
            if (in_array($fileParts['extension'], $fileTypes)) {
                $file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $data = array(
                    'submenu_id' => $sub_id,
                    'file' => $Name,
                    'qrcode' => $NameFile.'.png'
                );
                //$this->db->where('sub_id', $sub_id);
                $this->db->insert('sub_menu_file', $data);
                move_uploaded_file($tempFile, $targetFile);

                //QrCode
                $params['data'] = base_url() . 'qrcode/' . $Name;
                $params['level'] = 'H';
                $params['size'] = 10;
                //$params['savename'] = FCPATH . 'tes.png';
                $params['savename'] = 'qrcode/' . $NameFile . '.png';
                $this->ciqrcode->generate($params);

                //echo '<img src="' . base_url() . 'tes.png" />';

                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function from_edit_sub_menu() {
        $sub_id = $_POST['sub_id'];
        $data['mas_menu'] = $this->tak->get_sub_menu_where($sub_id);
        $this->load->view('backend/menu/from_edit_submenu', $data);
    }

    public function save_edit_submenu() {
        $data = array(
            'sub_name' => $_POST['sub_name']
        );

        $this->db->where('sub_id', $_POST['sub_id']);
        $this->db->update('sub_menu', $data);
    }

    public function delete_submenu() {
        $id = $this->input->post('sub_id');
        $sql = "SELECT * FROM sub_menu WHERE sub_id = '$id' ";
        $result = $this->db->query($sql)->row();

        if ($result->file != "") {
            unlink('file_download/' . $result->file);
            unlink('qrcode/' . $result->qrcode);
        }

        $sqlFile = "SELECT * FROM sub_menu_file WHERE submenu_id = '$id' ";
        $resultFile = $this->db->query($sqlFile);
        foreach ($resultFile->result() as $rs) {
            if ($rs->file) {
                unlink('file_download/' . $rs->file);
                unlink('qrcode/' . $rs->qrcode);
            }
        }
        $this->db->where('sub_id', $id);
        $this->db->delete('sub_menu');

        $this->db->where('submenu_id', $id);
        $this->db->delete('sub_menu_file');
    }

    public function deletefileold() {
        $id = $this->input->post('id');

        $sqlFile = "SELECT * FROM sub_menu WHERE sub_id = '$id' ";
        $resultFile = $this->db->query($sqlFile)->row();

        if ($resultFile->file) {
            unlink('file_download/' . $resultFile->file);
        }

        $culumn = array("file" => '');
        $this->db->where('sub_id', $id);
        $this->db->update('sub_menu', $culumn);
    }

    public function deletefile() {
        $id = $this->input->post('id');

        $sqlFile = "SELECT * FROM sub_menu_file WHERE id = '$id' ";
        $resultFile = $this->db->query($sqlFile)->row();

        if ($resultFile->file) {
            unlink('file_download/' . $resultFile->file);
            unlink('qrcode/' . $resultFile->qrcode);
        }
        $this->db->where('id', $id);
        $this->db->delete('sub_menu_file');
    }

    /* ################# จัดการเมนูแบบฟอร์ม ########################### */

    public function icon() {
        $data['icon'] = $this->tak->get_icon();
        $page = "backend/icon/from_icon";
        $head = "icons";

        $this->output($data, $page, $head);
    }

    public function GetUncheckMenu() {
        $tak = new takmoph_model();
        $result = $tak->GetMasMenuAdmin();
        $data['masmenu'] = $result;
        $this->load->view('backend/menu/GetConfigMenu', $data);
    }

    public function delete_admin_menu() {
        $id = $this->input->post('id');
        $this->db->select("*");
        $this->db->from("admin_menu");
        $this->db->where("admin_menu_id", $id);
        $adminmenu = $this->db->get()->row();

        //Delete Masmenu
        $this->db->where("admin_menu_id", $adminmenu->admin_menu_id);
        $this->db->delete("mas_menu");

        //Get File From dengue
        $this->db->select("*");
        $this->db->from("dengue");
        $this->db->where("admin_menu_id", $adminmenu->admin_menu_id);
        $dengue = $this->db->get();
        foreach ($dengue->result() as $file):
            //Delete File
            if(file_exists("file_download/" . $file->file)){
                unlink("file_download/" . $file->file);
            }
        endforeach;

        //Delete dengue
        $this->db->where("admin_menu_id", $adminmenu->admin_menu_id);
        $this->db->delete("dengue");

        //Delete Img adminmenu
        /*
        unlink("icon_menu/" . $adminmenu->admin_menu_images);
        */
        $this->db->where("admin_menu_id", $id);
        $this->db->delete("admin_menu");
    }

    public function set_level() {
        $id = $this->input->post('id');
        $level = $this->input->post('level');

        $columns = array(
            "level" => $level
        );

        $this->db->where("id", $id);
        $this->db->update("mas_menu", $columns);

        //echo "ID = ".$id." LEVEL = ".$level;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
