<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class backend extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
        $this->load->library('grocery_CRUD');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        //$template = $this->template_model->get_template();
        $this->load->view("template_admin", $data);
    }

    public function Index() {
        $page = "backend/index";
        $data = "";
        $this->output($data, $page, "ลงทะเบียน");
    }

    public function Category($catid = null) {
        if ($catid != "") {
            $result = $this->db->select('*')->from('forum_category')->where("id = $catid")->get();
            $rs = $result->row();
            $head = $rs->title;
            $data['category'] = $this->db->select('*')
                    ->from("forum_category")
                    ->where("upper = $catid")
                    ->get();
        } else {
            $head = "หมวดกระทู้";
            $data['category'] = $this->db->select("*")->from("forum_category")->where("upper = '0' ")->get();
        }
        $data['catID'] = $catid;

        /*
          $crud = new grocery_CRUD();
          $crud->set_theme('flexigrid');
          $crud->set_table('forum_category');
          $output = $crud->render();

          $data['output'] = $output;
         */

        $page = "backend/category";

        $this->output($data, $page, $head);
    }

    public function Createcategory($catID = null) {
        $page = "backend/createcategory";
        $data['catID'] = $catID;
        $this->output($data, $page, "สร้างหมวดกระทู้");
    }

    public function Savecategory() {
        $title = $this->input->post('title');
        $detail = $this->input->post('detail');
        $level = $this->input->post('level');
        $catid = $this->input->post('catid');
        //echo $title;
        $columns = array(
            "title" => $title,
            "detail" => $detail,
            "level" => $level,
            "upper" => $catid,
            "create_date" => date("Y-m-d H:i:s")
        );

        $this->db->insert("forum_category", $columns);
    }

    public function Updatecategory($id = null) {
        $page = "backend/updatecategory";
        //$data['catID'] = $id;
        $data['model'] = $this->db->select("*")->from("forum_category")->where("id = $id")->get()->row();
        $this->output($data, $page, "แก้ไขหมวดกระทู้");
    }

    public function Saveupdatecategory() {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $detail = $this->input->post('detail');
        $level = $this->input->post('level');
        $catid = $this->input->post('catid');
        $active = $this->input->post('active');
        //echo $title;
        $columns = array(
            "title" => $title,
            "detail" => $detail,
            "level" => $level,
            "upper" => $catid,
            "active" => $active,
            "d_update" => date("Y-m-d H:i:s")
        );
        $this->db->where("id", $id);
        $this->db->update("forum_category", $columns);
    }

    public function Deletecategory() {
        $id = $this->input->post('id');
        $result = $this->db->get_where("forum_category", array('id' => $id))->row();
        if ($result->level == '1') {
            $this->db->where("upper", $id);
            $this->db->delete("forum_category");

            $this->db->where("id", $id);
            $this->db->delete("forum_category");
        } else {
            $this->db->where("id", $id);
            $this->db->delete("forum_category");
        }
    }

    public function Agreement() {
        $data['agreement'] = $this->db->get('forum_agreement');
        $page = "backend/agreement";
        $this->output($data, $page, "ข้อตกลงการใช้งาน");
    }

    public function Saveagreement() {
        $agreement = $this->input->post('agreement');
        $columns = array("agreement" => $agreement);
        $this->db->insert("forum_agreement", $columns);
    }

    public function Saveupdateagreement() {
        $id = $this->input->post('id');
        $agreement = $this->input->post('agreement');
        $columns = array("agreement" => $agreement);
        $this->db->where("id", $id);
        $this->db->update("forum_agreement", $columns);
    }

    public function Deleteagreement() {
        $id = $this->input->post('id');
        $this->db->where("id", $id);
        $this->db->delete("forum_agreement");
    }

    public function Typealert() {
        $data['typealert'] = $this->db->get('forum_typealert');
        $page = "backend/typealert";
        $this->output($data, $page, "ประเภทแจ้งเตือน");
    }

    public function Savetypealert() {
        $typealert = $this->input->post('typealert');
        $columns = array("typealert" => $typealert);
        $this->db->insert("forum_typealert", $columns);
    }

    public function Saveupdatetypealert() {
        $id = $this->input->post('id');
        $typealert = $this->input->post('typealert');
        $columns = array("typealert" => $typealert);
        $this->db->where("id", $id);
        $this->db->update("forum_typealert", $columns);
    }

    public function Deletetypealert() {
        $id = $this->input->post('id');
        $this->db->where("id", $id);
        $this->db->delete("forum_typealert");
    }

    public function User() {
        $this->db->select("*");
        $this->db->from("forum_register");
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        $data['user'] = $query;
        $page = "backend/user";

        $this->output($data, $page, "ผู้ใช้งาน");
    }

    public function Userview() {

        $id = $this->uri->segment(4);
        $this->db->select("*");
        $this->db->from("forum_register");
        $this->db->where("id", $id);
        $query = $this->db->get();
        $data['user'] = $query->row();
        $page = "backend/userview";
        $this->output($data, $page, $data['user']->username);
    }

    public function Alertdelpost() {
        $sql = "SELECT p.*,i.post_id,i.d_update AS datesend,r.alias,rs.alias AS aliassend 
                FROM forum_inform_post i 
                INNER JOIN forum_post p ON i.post_id = p.id
                INNER JOIN forum_register r ON p.user_id = r.id 
                INNER JOIN forum_register rs ON i.user_id = rs.id 
                WHERE p.flag = '1' ";

        $data['post'] = $this->db->query($sql);
        $page = "backend/alertdelpost";
        $this->output($data, $page, "กระทู้แจ้งลบ");
    }

    public function Alertdelcomment() {
        $sql = "SELECT p.*,i.comment_id,i.d_update AS datesend,r.alias,rs.alias AS aliassend 
                FROM forum_inform_comment i 
                INNER JOIN forum_comment p ON i.comment_id = p.id
                INNER JOIN forum_register r ON i.user_id = r.id 
                INNER JOIN forum_register rs ON i.user_id = rs.id ";

        $data['comment'] = $this->db->query($sql);
        $page = "backend/alertdelcomment";
        $this->output($data, $page, "คอมเม้นแจ้งลบ");
    }

    public function Viewpost() {
        $postID = $this->uri->segment('4');
        $sql = "SELECT p.*,r.alias,c.title AS categorytitle
                FROM forum_post p 
                INNER JOIN forum_register r ON p.user_id = r.id
                INNER JOIN forum_category c ON p.category = c.id
                WHERE p.id = '$postID'";
        $data['post'] = $this->db->query($sql)->row();
        $page = "backend/viewpost";
        $this->output($data, $page, $postID);
    }

    public function Viewcomment() {
        $ID = $this->uri->segment('4');
        $sql = "SELECT p.*,i.comment_id,i.d_update AS datesend,r.alias,rs.alias AS aliassend 
                FROM forum_inform_comment i 
                INNER JOIN forum_comment p ON i.comment_id = p.id
                INNER JOIN forum_register r ON i.user_id = r.id 
                INNER JOIN forum_register rs ON i.user_id = rs.id 
                WHERE i.comment_id = '$ID' ";
        $data['comment'] = $this->db->query($sql)->row();
        $page = "backend/viewcomment";
        $this->output($data, $page, $ID);
    }

    //ลบโพสต์จากการแจ้ง
    public function Deletepost() {
        $postID = $this->input->post('post_id');
        $columns = array("flag" => 1);
        $this->db->where("post_id", $postID);
        $this->db->update("forum_inform_post", $columns);

        $columnspost = array("flag" => 1);
        $this->db->where("id", $postID);
        $this->db->update("forum_post", $columnspost);
    }

    //ยกเลิกการ block
    public function Cancelpost() {
        $postID = $this->input->post('post_id');
        $this->db->where("id", $postID);
        $this->db->delete("forum_inform_post");

        $columnspost = array("flag" => 0);
        $this->db->where("id", $postID);
        $this->db->update("forum_post", $columnspost);
    }

}
