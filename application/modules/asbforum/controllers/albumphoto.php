<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class albumphoto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        //$template = $this->template_model->get_template();
        $this->load->view("asbforum/template", $data);
    }

    public function Aut() {
        $user = $this->session->userdata('forum_user_id');
        if (!empty($user)) {
            return true;
        } else {
            redirect('asbforum/users/login');
        }
    }

    public function Index() {
        $page = "index";
        $data['category'] = $this->db->get_where("forum_category", array("active" => "Y"));
        $this->output($data, $page, "ลงทะเบียน");
    }

    public function Formuploads() {
        
    }

    public function Getalbum() {
        $this->Aut();
        $user_id = $this->session->userdata('forum_user_id');
        $this->db->where("user_id", $user_id);
        $this->db->select("*");
        $this->db->from("forum_images");
        $this->db->order_by("id", "desc");
        $data['images'] = $this->db->get();
        $this->load->view("asbforum/albumphoto/gallery", $data);
    }
    
    public function Getalbumrecomment() {
        $this->Aut();
        $user_id = $this->session->userdata('forum_user_id');
        $this->db->where("user_id", $user_id);
        $this->db->select("*");
        $this->db->from("forum_images");
        $this->db->order_by("id", "desc");
        $data['images'] = $this->db->get();
        $this->load->view("asbforum/albumphoto/gallery-recomment", $data);
    }

    public function Delete_images() {
        $id = $this->input->post("id");
        $result = $this->db->get_where("forum_images", array("id" => $id))->row();
        $link = "assets/module/asbforum/albumphoto/";
        if (file_exists($link . $result->images)) {
            unlink($link . $result->images);
            $this->db->where("id", $id);
            $this->db->delete("forum_images");
        }
    }

    public function Delete_images_all() {
        $user_id = $this->session->userdata("forum_user_id");
        $result = $this->db->get_where("forum_images", array("user_id" => $user_id));
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $rs) {
                $link = "assets/module/asbforum/albumphoto/";
                if (file_exists($link . $rs->images)) {
                    unlink($link . $rs->images);
                }
            }
            $this->db->where("user_id", $user_id);
            $this->db->delete("forum_images");
        }
    }

}
