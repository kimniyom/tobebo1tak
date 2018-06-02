<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class icons extends CI_Controller {
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
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        $this->load->view('template_admin', $data);
    }

    public function get_icon() {
        $icon_id = $_POST['icon_id'];
        $data['icon'] = $this->tak->get_icon_menu($icon_id);
        $this->load->view('backend/icon/show_icon', $data);
    }

    public function uoload_icon() {
        $targetFolder = 'icon_menu'; // Relative to the root
        if (!empty($_FILES)) {

            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $Name = "icon_" . date('YmdHis') . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;

            //$targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            $targetFile = $targetFolder . '/' . $Name;
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array($fileParts['extension'], $fileTypes)) {
                $file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $data = array(
                    'icon' => $Name
                );
                $this->db->insert('menu_icon', $data);
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

    /* ################# จัดการเมนูแบบฟอร์ม ########################### */

    public function icon() {
        $data['icon'] = $this->tak->get_icon();
        $page = "backend/icon/from_icon";
        $head = "icons";

        $this->output($data, $page, $head);
    }

    public function delete_icon(){
        $id = $this->input->post("id");

        $this->db->select("*");
        $this->db->from("menu_icon");
        $this->db->where("icon_id",$id);

        $query = $this->db->get();
        $row = $query->row();

        if(!empty($row->icon)){
            unlink("icon_menu/".$row->icon);
        }

        $this->db->where("icon_id",$id);
        $this->db->delete("menu_icon");
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
