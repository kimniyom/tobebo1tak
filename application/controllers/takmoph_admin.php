<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class takmoph_admin extends CI_Controller {
    /*
     *  Creart Code By kimniyom
     *  Date 27/05/2556 | Time 22.26.00
     *
     */

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->model('modulemanager/modulemanager_model');
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
            echo "<script>window.location='" . site_url('users/login') . "'</script>";
        }
    }

    public function index() {

        $data['menu_admin'] = $this->tak->get_menu_admin();
        $data['menu_admin_type'] = $this->tak->get_menu_admin_type('0');
        $data['module'] = $this->tak->get_menu_module();
        $page = "home_admin";
        $this->output($data, $page, '');
    }

    public function output_user($deta = '', $page = '', $head = '') {

        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;

        $this->load->view('template_admin', $data);
    }

    public function del_album() {
        //$sql = "DELETE FROM album WHERE LEFT(date,4) < '2014' ";
        //$result = $this->db->query($sql);
        /*
          foreach($result->result() as $rs):
          $sql_gallert = "SELECT * FROM gallery WHERE AlbumID = '".$rs->AlbumID."' ";
          $re = $this->db->query($sql_gallert);
          foreach($re->result() as $dd):
          unlink('album/gallery/'.$dd->GalleryShot);
          $sql_del = "DELETE FROM gallery WHERE AlbumID = '".$rs->AlbumID."' ";
          $this->db->query($sql_del);
          endforeach;
          endforeach;
         */
    }

    public function get_dengue($id = '') {
        $data['admin_menu_id'] = $id;
        $data['dengue'] = $this->tak->get_dengue($id);
        $page = "admin/show_dengue";
        $head = $this->tak->Get_name_group($id);

        if ($this->session->userdata('status') != '') {
            $this->output($data, $page, $head);
        } else {
            $this->output_user($data, $page, $head);
        }
    }

    public function save_dengue() {
        $group = $this->input->post('group');
        $data = array(
            'title' => $_POST['title'],
            'admin_menu_id' => $_POST['admin_menu_id']
        );
        $this->db->insert('dengue', $data);

        $sql = "SELECT MAX(id) AS id FROM dengue";
        $result = $this->db->query($sql);
        $row = $result->row();

        echo $this->tak->redir('takmoph_admin/from_upload_file_dengue/' . $row->id . '/' . $_POST['admin_menu_id']);
    }

    public function from_upload_file_dengue($id = '', $admin_menu_id = '') {
        $data['group'] = $this->tak->Get_name_group($admin_menu_id);
        $data['admin_menu_id'] = $admin_menu_id;
        $data['id'] = $id;
        $page = "admin/upload_file_dengue";
        $head = "เพิ่มไฟล์";

        $this->output($data, $page, $head);
    }

    public function delete_dendue() {

        $id = $this->input->post('id');
        //$admin_menu = $this->input->post('admin_menu');
        //ดึงข้อมูลไฟล์ขึ้มา
        $sql = "SELECT * FROM dengue WHERE id = '$id' ";
        $rs = $this->db->query($sql)->row();

        if (!empty($rs->file)) {
            unlink('file_download/' . $rs->file);
        }

        $this->db->where('id', $id);
        $this->db->delete('dengue');
    }

    public function get_menu_system() {
        $data['menu_system'] = $this->tak->get_menu_systemAll();
        $page = "menu_system/show_menu_system";
        $head = "จัดการระบบงาน/ลิงค์ภายนอก";

        $this->output($data, $page, $head);
    }

    public function save_menu_system() {
        $data = array(
            'system_title' => $_POST['system_title'],
            'link' => $_POST['link'],
            'status_show' => 'Yes'
        );
        $this->db->insert('menu_system', $data);

        $sql = "SELECT MAX(system_id) AS system_id FROM menu_system";
        $result = $this->db->query($sql);
        $row = $result->row();

        echo $this->tak->redir('takmoph_admin/from_upload_images_menu_system/' . $row->system_id);
    }

    public function edit_menu_system() {
        $menu_id = $_POST['menu_id'];
        $sql = "SELECT * FROM menu_system WHERE system_id = '$menu_id' ";
        $result = $this->db->query($sql)->row();
        $data['menu_id'] = $menu_id;
        $data['result'] = $result;

        $page = "menu_system/edit_menu_system";
        $this->load->view($page, $data);
    }

    public function save_edit_menu_system() {
        $menu_id = $_POST['menu_id'];
        $data = array(
            'system_title' => $_POST['menu_name'],
            'link' => $_POST['menu_link']
        );
        $this->db->update('menu_system', $data, "system_id = '$menu_id' ");
    }

    public function check_menu_system() {
        $system_id = $_POST['system_id'];
        $status = $_POST['status'];
        if ($status == "1") {
            $check = "No";
        } else {
            $check = "Yes";
        }

        $data = array(
            'status_show' => $check
        );
        $this->db->update('menu_system', $data, "system_id = '$system_id' ");
    }

    public function from_upload_images_menu_system($system_id = '') {
        $sql = "SELECT * FROM menu_system WHERE system_id = '$system_id' ";
        $result = $this->db->query($sql)->row();
        $data['title'] = $result->system_title;
        $data['images'] = $result->system_images;
        $data['system_id'] = $system_id;

        $page = "menu_system/upload_images_menu_system";
        $head = "เพิ่มรูปภาพ";

        $this->output($data, $page, $head);
    }

    public function delete_menu_system($system_id = '', $file = '') {
        if ($file != '') {
            unlink('icon_menu/' . $file);
        }

        $this->db->where('system_id', $system_id);
        $this->db->delete('menu_system');

        echo $this->tak->redir('takmoph_admin/get_menu_system/');
    }

    public function save_level() {
        $data = array('level' => $_POST['level']);

        $this->db->where('id', $_POST['menu_id']);
        $this->db->update('mas_menu', $data);
    }

    public function from_admin_menu() {
        $head = "เพิ่มเมนูระบบ";
        $page = "admin/admin_menu";
        $data = "";
        $this->output($data, $page, $head);
    }

    public function save_admin_menu() {
        $data = array(
            'admin_menu_name' => $_POST['admin_menu_name'],
            'admin_menu_link' => $_POST['admin_menu_link']
        );
        $this->db->insert('admin_menu', $data);

        $sql = "SELECT MAX(admin_menu_id) AS id FROM admin_menu";
        $result = $this->db->query($sql);
        $row = $result->row();

        echo $this->tak->redir('takmoph_admin/from_upload_icon_admin_menu/' . $row->id);
    }

    public function from_upload_icon_admin_menu($id = '') {
        $data['id'] = $id;
        $page = "admin/upload_icon_admin_menu";
        $head = "เพิ่ม icon";

        $this->output($data, $page, $head);
    }

    public function SaveMenuAdmin() {
        //$admin_menu_id = $this->input->post('admin_menu_id');
        $admin_menu_name = $this->input->post('admin_menu_name');
        $admin_menu_link = $this->input->post('admin_menu_link');
        $icon = $this->input->post('icon');
        $data = array(
            'admin_menu_name' => $admin_menu_name,
            'admin_menu_link' => $admin_menu_link,
            'admin_menu_images' => $icon,
            'typelink' => '1'
        );

        $this->db->insert("admin_menu",$data);
    }

    public function SaveUpdateMenu(){
        $admin_menu_id = $this->input->post('admin_menu_id');
        $admin_menu_name = $this->input->post('admin_menu_name');
        $admin_menu_link = $this->input->post('admin_menu_link');
        $icon = $this->input->post('icon');
        $data = array(
            'admin_menu_name' => $admin_menu_name,
            'admin_menu_images' => $icon
        );
        $this->db->where("admin_menu_id",$admin_menu_id);
        $this->db->update("admin_menu",$data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
