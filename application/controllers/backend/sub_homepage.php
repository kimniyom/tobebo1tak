<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class sub_homepage extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
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

    public function all($menu_id = null) {
        $homepage = new homepage_model();
        $subhomepage = new sub_homepage_model();
        $data['homepage'] = $homepage->get_menu_where($menu_id)->row();
        $data['result'] = $subhomepage->get_subhomepage($menu_id);
        $page = "backend/sub_homepage/all";
        $head = $data['homepage']->title_name;
        $this->output($data, $page, $head);
    }

    public function view($Id = null, $subhomepage_id = null, $homepage_id = null) {
        $subhomepage = new sub_homepage_model();
        $data['result'] = $subhomepage->get_subhomepage_where($Id)->row();
        $data['subhomepage_id'] = $subhomepage_id;
        $data['subhomepage'] = $subhomepage->get_subhomepage_where($subhomepage_id)->row();
        $data['homepage_id'] = $homepage_id;
        $head = "view";
        $page = "backend/sub_homepage/view";
        $this->output($data, $page, $head);
    }

    public function create_subhomepage($Id = null, $type = null) {
        $homepage = new homepage_model();
        if (empty($type)) {
            $data['menu'] = $homepage->get_menu_where($Id)->row();
        } else {
            $data['menu'] = $homepage->get_subhomepage_where($Id)->row();
        }
        $page = "backend/sub_homepage/create";
        $head = $data['menu']->title_name;
        $this->output($data, $page, $head);
    }

    public function save_subhomepage() {
        $input = $this->input;
        $columns = array(
            "title" => $input->post("title"),
            "detail" => $input->post("detail"),
            "homepage_id" => $input->post("homepage_id"),
            "final" => '1',
            "owner" => $this->session->userdata('user_id'),
            "create_date" => $input->post("create_date")
        );

        $this->db->insert("sub_homepage", $columns);
    }

    public function update($Id = null, $type = null) {
        $sub_homepage = new sub_homepage_model();
        $page = "backend/sub_homepage/update";
        $data['result'] = $sub_homepage->get_subhomepage_where($Id)->row();
        $data['type'] = $type;
        $data['subhomepage_id'] = $Id;
        $head = $data['result']->title;
        $this->output($data, $page, $head);
    }

    public function save_update() {
        $input = $this->input;
        $id = $input->post('id');
        $columns = array(
            "title" => $input->post("title"),
            "detail" => $input->post("detail"),
            "create_date" => $input->post("create_date"),
        );
        $this->db->update("sub_homepage", $columns, "id = '$id'");
    }

    public function delete() {
        $Id = $this->input->post('id');
        $sql = "SELECT * FROM sub_homepage WHERE upper = '$Id' ";
        $result = $this->db->query($sql);
        if (!empty($result)) {
            $this->db->where("upper", $Id);
            $this->db->delete("sub_homepage");
        }
        $this->db->where("id", $Id);
        $this->db->delete("sub_homepage");
    }

    public function create_subhomepage_upper() {
        $input = $this->input;
        $columns = array(
            "title" => $input->post("title"),
            "homepage_id" => $input->post("homepage_id"),
            "owner" => $this->session->userdata('user_id'),
            "final" => '0',
            "create_date" => date("Y-m-d H:i:s")
        );

        $this->db->insert("sub_homepage", $columns);

        $sql = "SELECT id,homepage_id FROM sub_homepage ORDER BY id DESC LIMIT 1";
        $result = $this->db->query($sql)->row();
        $json = array("id" => $result->id, "homepage_id" => $result->homepage_id);
        echo json_encode($json);
    }

    public function viewpper($subid, $menuID) {
        $sub_homepage = new sub_homepage_model();
        $page = "backend/sub_homepage/viewupper";
        $data['menu'] = $this->model->get_menu_where($menuID)->row();
        $data['result'] = $sub_homepage->get_subhomepage_where($subid)->row();
        $data['upper'] = $sub_homepage->getupper($subid);
        $head = $data['result']->title;
        $this->output($data, $page, $head);
    }

    public function create_upper($subid = null, $homepageId = null) {
        $homepage = new homepage_model();
        $data['menu'] = $homepage->get_subhomepage_where($subid)->row();
        $page = "backend/sub_homepage/create_upper";
        $head = $data['menu']->title_name;
        $data['homepage_id'] = $homepageId;
        $this->output($data, $page, $head);
    }

    public function save_upper() {
        $input = $this->input;
        $columns = array(
            "title" => $input->post("title"),
            "detail" => $input->post("detail"),
            "upper" => $input->post("upper"),
            "homepage_id" => $input->post('homepage_id'),
            "final" => '1',
            "owner" => $this->session->userdata('user_id'),
            "create_date" => $input->post("create_date")
        );

        $this->db->insert("sub_homepage", $columns);
    }

}
