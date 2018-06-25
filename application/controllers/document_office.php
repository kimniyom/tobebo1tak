<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class document_office extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        //$this->load->model('upload_model', 'upload');
        //$this->load->model('news_model', 'news');
        $this->load->model('document_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;

        $this->load->view('template2015', $data);
    }

    public function Index() {
        $model = new document_model();
        $page = "document_office/index";
        $data['echomoph'] = $model->get_archives(7); //ประกาศสำนักงานสาธารณสุขจังหวัด
        $data['echoprovince'] = $model->get_archives(8); //ประกาศจังหวัด
        $data['book_winding_in'] = $model->get_archives(3); //หนังสือเวียน ใน
        $data['book_winding_out'] = $model->get_archives(4); //หนังสือเวียน นอก
        $data['semina'] = $model->get_archives(9); //ประชุมสัมนา
        //$this->output($data, $page, "เรื่องร้องทุกข์");
        $this->load->view($page, $data);
    }

    public function Views($Id = null) {
        $model = new document_model();

        $page = "document_office/view";
        $d = $model->document_type($Id);
        $head = $d->DT_Name;
        $data['document'] = $model->get_archives_all($Id); //ประกาศสำนักงานสาธารณสุขจังหวัด

        $this->output($data, $page, $head);
    }

    public function Semina() {
        $model = new document_model();
        $page = "document_office/view";
        $data['document'] = $model->get_semina_all(); //ประกาศสำนักงานสาธารณสุขจังหวัด
        $head = "ประชุมสัมนา,อบรมระยะสั้น";
        $this->output($data, $page, $head);
    }

}
