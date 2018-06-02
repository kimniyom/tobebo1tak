<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class menu extends CI_Controller {
    /*
     *  Creart Code By kimniyom
     *  Date 27/05/2556 | Time 22.26.00 
     * 
     */

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('menu_model');
        $this->load->model('page_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('takmoph_libraries');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        $template = $this->template_model->get_template();
        $this->load->view($template['template'], $data);
    }

    public function get_menu() {
        $page = $this->uri->segment(3);
        $deta = '';
        $page = "from/$page";
        $head = '';
        $this->output($deta, $page, $head);
    }

    /* เมนูจากการสร้างใน เมนูเว็บไซต์ */

    public function submenu($ids = null) {
        $id = $this->takmoph_libraries->decode($ids);
        $menu = new menu_model();
        $data['masmenu'] = $menu->get_mas_menu($id);
        $data['submenu'] = $this->tak->get_sub_menu($id);
        $page = "menu/submenu";
        $head = $data['masmenu']->mas_menu;

        $this->output($data, $page, $head);
    }

    /* เมนูจากการสร้างใน ระบบฝ่าย ไฟล์ดาวน์โหลด */

    public function filemenu($ids = null) {
        $id = $this->takmoph_libraries->decode($ids);
        $menu = new menu_model();
        $data['file'] = $menu->get_filemenu_system($id);
        $page = "menu/filemenu";
        $groupmenu = $menu->get_detail_menu($id);
        $head = $groupmenu->mas_menu;
        $data['groupmenu'] = $id;
        $data['icon'] = $groupmenu->icon;
        $this->output($data, $page, $head);
    }

    public function view($ids, $groups) {
        $id = $this->takmoph_libraries->decode($ids);
        /*
        $group = $this->takmoph_libraries->decode($groups);
         * 
         */
        $group = $groups;
        $Model = new page_model();
        $data['datas'] = $Model->getpagebyid($id);
        $data['group'] = $this->tak->Get_name_group($group);
        $data['admin_menu_id'] = $group;
        $data['id'] = $id;
        $page = "menu/view";
        $head = $data['datas']->title;

        $this->output($data, $page, $head);
    }

    public function views($ids, $groups) {
        $id = $this->takmoph_libraries->decode($ids);
        /*
        $group = $this->takmoph_libraries->decode($groups);
         * 
         */
        $group = $groups;
        $Model = new menu_model();
        $data['datas'] = $Model->getmenubyid($id);
        $data['group'] = $Model->getgroupmenubyid($group);

        $sql = "SELECT *
                    FROM sub_menu_file s 
                    WHERE s.submenu_id = '$id' ";
        $data['file'] = $this->db->query($sql);

        $data['groupmenu'] = $data['group']->mas_menu;
        $data['id'] = $id;
        $page = "menu/views";
        $head = $data['datas']->sub_id;

        $this->output($data, $page, $head);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */