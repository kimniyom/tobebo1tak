<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class caching extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        $this->load->view('template_admin', $data);
    }

    public function index() {
        $this->db->cache_delete_all();
    }

}
