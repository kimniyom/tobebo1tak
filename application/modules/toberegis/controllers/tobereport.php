<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tobereport extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('toberegis/toberegis_model', 'model');
        $this->load->model('toberegis/report_model', 'report');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
        $this->load->library('Ciqrcode', 'ciqrcode');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        //$template = $this->template_model->get_template();
        $this->load->view("toberegis/template", $data);
    }

    public function Index($type=null) {
        $page = "report/index";
        $ReportAmphur = $this->report->GetreportAmphur($type);
        $data['type'] = $this->model->TypeRow($type);
        $data['countType'] = $this->report->CountType($type);
        foreach($ReportAmphur->result() as $rs):
            $ChartAmphurArr[] = "['".$rs->ampurname."',".$rs->total."]";
        endforeach;
        $data['table'] = $ReportAmphur;
        $data['chartamphur'] = implode(",",$ChartAmphurArr);
        $this->output($data, $page, $data['type']->name);
    }

    public function Office($type=null,$amphur = null) {
        $page = "report/office";
        $ReportOffice = $this->report->GetreportOffice($type,$amphur);
        $data['type'] = $this->model->TypeRow($type);
        $data['amphur'] = $this->model->AmphurRow($amphur);
        $data['countType'] = $this->report->CountType($type,$amphur);
        /*
        foreach($ReportAmphur->result() as $rs):
            $ChartAmphurArr[] = "['".$rs->distname."',".$rs->total."]";
        endforeach;
        */
        $data['table'] = $ReportOffice;
        //$data['chartamphur'] = implode(",",$ChartAmphurArr);
        $this->output($data, $page, $data['type']->typename);
    }

    public function Viewlist($type=null,$amphur = null,$office = null) {
        $page = "report/viewlist";
        $ReportList = $this->report->GetreportList($type,$amphur,$office);
        $data['type'] = $this->model->TypeRow($type);
        $data['amphur'] = $this->model->AmphurRow($amphur);
        $data['countType'] = $this->report->CountType($type,$amphur);
       
        $data['table'] = $ReportList;
        //$data['chartamphur'] = implode(",",$ChartAmphurArr);
        $this->output($data, $page, $data['type']->typename);
    }


}
