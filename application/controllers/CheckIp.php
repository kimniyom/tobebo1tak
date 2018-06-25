<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CheckIp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        /*
          $this->load->model('takmoph_model', 'tak');
          $this->load->model('upload_model', 'upload');
          $this->load->model('news_model', 'news');
          $this->load->model('complain_model', 'complain');
          $this->load->helper('url');
          $this->load->library('session');
          $this->load->helper('captcha');
         * 
         */
    }

    public function Index() {
        echo $this->input->ip_address();
    }

}
