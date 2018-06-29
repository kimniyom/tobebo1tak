<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class activity extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('tobeupload_model', 'upload');
        $this->load->model('tobeactivity_model', 'activity');
        $this->load->helper('url');
        $this->load->library('takmoph_libraries');
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->helper('string');
        
    }

    public function Auth() {
        if ($this->session->userdata('status') == "S" || $this->session->userdata('user_register') != "" || $this->session->userdata('tobe_user_id') != "") {
            return TRUE;
        } else {
            redirect('users/login', 'refresh');
        }
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        $this->load->view("toberegis/template", $data);
    }

    public function index() {
        if ($this->Auth() == TRUE) {
            $user_id = $this->session->userdata('tobe_user_id');
            $data['activity'] = $this->activity->get_activity_user($user_id);
            $page = "toberegis/activity/index";
            $head = "รูปภาพกิจกรรม";

            $this->output($data, $page, $head);
        }
    }

    public function create() {
        $page = "toberegis/activity/create";
        $head = "สร้างรูปภาพกิจกรรม";

        $this->output("", $page, $head);
    }

    public function save() {
        //header("Content-Type: image/png");
        //$Qrcode = new Ciqrcode();
        $qrcodeName = md5("tobeactivity_" . date("His")) . ".png";
        $data = array(
            'title' => $this->input->post('title'),
            'detail' => $this->input->post('detail'),
            'user_id' => $this->session->userdata('tobe_user_id'),
            'type' => $this->session->userdata('tobe_type'),
            'qrcode' => $qrcodeName,
            'date' => date('Y-m-d H:i:s')
        );
        $this->db->insert('tobe_activity', $data);
        
        $sql = "select MAX(id) as id from tobe_activity ";
        $rs = $this->db->query($sql)->row();
        $activity_id = $this->takmoph_libraries->url_encode($rs->id);
        //QrCode

        $params['data'] = base_url() . 'toberegis/tobeactivity/view/' . $activity_id;
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = 'qrcode/tobeactivity/' . $qrcodeName;
        $this->ciqrcode->generate($params);

        
        
        $json = array("id" => $activity_id);
        echo json_encode($json);
        //echo $this->tak->redir('backend/news/from_upload_images_news/' . $_POST['new_id']);
    }

    public function GenQrcode() {
        header("Content-Type: image/png");

        $params['data'] = 'This is a text to encode become QR Code';
        //$params['level'] = 'H';
        //$params['size'] = 10;
        $this->ciqrcode->generate($params);
    }

    public function from_edit_news() {
        $new_id = $this->input->post('id');
        $data['news'] = $this->news->get_news_where($new_id);
        $this->load->view("toberegis/news/from_edit_news", $data);
        //$head = "แก้ไขข้อมูลข่าว";
        //$this->output($data, $page, $head);
        //echo json_encode($json);
    }

    public function edit_activity() {
        //header("Content-Type: image/png");
        $activity_id = $this->input->post('_activity_id');
        $results = $this->db->get_where("tobe_activity", array("id" => $activity_id));
        $rs = $results->row();
        if ($rs->qrcode == "") {
            $qrcodeName = md5($activity_id . "tobeactivity_".date("His")) . ".png";
            $activitys_id = $this->takmoph_libraries->url_encode($activity_id);
            //QrCode
            $params['data'] = base_url() . 'toberegis/tobeactivity/view/' . $activitys_id;
            $params['level'] = 'H';
            $params['size'] = 10;
            //$params['savename'] = FCPATH . 'tes.png';
            $params['savename'] = 'qrcode/tobeactivity/' . $qrcodeName;
            $this->ciqrcode->generate($params);
            $data_update = array(
                'title' => $this->input->post('_title'),
                'detail' => $this->input->post('_detail'),
                'qrcode' => $qrcodeName
            );
        } else {
            $data_update = array(
                'title' => $this->input->post('_title'),
                'detail' => $this->input->post('_detail')
            );
        }
        $this->db->where('id', $activity_id);
        $this->db->update('tobe_activity', $data_update);


        //echo $this->tak->redir('takmoph_admin/get_news/');
    }

    public function delete_news() {

        $new_id = $this->input->post('news_id');

        $sql = "SELECT * FROM tobeimages_news WHERE new_id = '" . $new_id . "'";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $rs):
                if (file_exists('upload_images/news/thumb/' . $rs->images)) {
                    unlink('upload_images/news/thumb/' . $rs->images);
                }
                if (file_exists('upload_images/news/' . $rs->images)) {
                    unlink('upload_images/news/' . $rs->images);
                }
                if (file_exists('qrcode/' . $rs->qrcode)) {
                    unlink('qrcode/' . $rs->qrcode);
                }
            endforeach;
        }

        $this->db->where('new_id', $new_id);
        $this->db->delete('tobeimages_news');

        $this->db->where('id', $new_id);
        $this->db->delete('tobe_news');

        //echo $this->tak->redir('backend/news/get_news/');
    }

    

    public function from_upload_images_news($new_id = '') {
        
        $new_model = new news_model();
        $data['news'] = $new_model->get_news_where($new_id);

        $data['new_id'] = $new_id;
        $page = "toberegis/news/upload_images_news";
        $head = "รูปภาพข่าว";

        $this->output($data, $page, $head);
    }

    public function album_activity() {
        $activity_id = $this->input->post('activity_id');
        $data['images'] = $this->activity->get_images_activity($activity_id);
        $this->load->view("toberegis/activity/album_activity", $data);
    }

    public function delete_images() {
        $id = $this->input->post('id');
        $images = $this->input->post('images');

        if (!empty($images)) {
            if (file_exists("upload_images/tobeactivity/thumb/" . $images)) {
                unlink("upload_images/tobeactivity/thumb/" . $images);
            }
            if (file_exists("upload_images/tobeactivity/" . $images)) {
                unlink("upload_images/tobeactivity/" . $images);
            }
        }

        $this->db->where("id", $id);
        $this->db->delete("tobe_activity_images");
    }

    public function upload_images($activity_id = '') {
        $targetFolder = 'upload_images/tobeactivity'; // Relative to the root
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $Name = "tobeimg_" . random_string('alnum', 30) . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            //$GalleryShot = $_FILES['Filedata']['name'];
            if (in_array($fileParts['extension'], $fileTypes)) {
                //$file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $width = 1280; //*** Fix Width & Heigh (Autu caculate) ***//
                //$new_images = "Thumbnails_".$_FILES["Filedata"]["name"];
                $size = getimagesize($_FILES['Filedata']['tmp_name']);
                $height = round($width * $size[1] / $size[0]);
                $images_orig = imagecreatefromjpeg($tempFile);
                $photoX = imagesx($images_orig);
                $photoY = imagesy($images_orig);

                if ($photoY >= $width) {
                    $images_fin = imagecreatetruecolor($width, $height);
                    imagecopyresampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
                    imagejpeg($images_fin, "upload_images/activity/" . $Name);
                    imagedestroy($images_orig);
                    imagedestroy($images_fin);
                } else {
                    move_uploaded_file($tempFile, $targetFile);
                }

                $data = array(
                    'activity_id' => $activity_id,
                    'images' => $Name
                );
                $this->db->insert('tobe_activity_images', $data);
                $this->Thumnail($targetFolder . "/" . $Name, $targetFolder . "/thumb", $Name);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function Thumnail($original, $originalPath, $name) {
        $this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['source_image'] = $original;
        $config['create_thumb'] = false;
        $config['maintain_ratio'] = true;
        $config['width'] = 250;
        $config['height'] = 250;
        $config['new_image'] = $originalPath . "/" . $name;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }

    public function view($eid) {
        $id = $this->takmoph_libraries->url_decode($eid);
        $data['activity'] = $this->db->get_where("tobe_activity", array("id" => $id))->row();
        $page = "toberegis/activity/view";
        $head = $data['activity']->title;
        $this->output($data, $page, $head);
    }

    public function update($id) {
        $data['activity'] = $this->db->get_where("tobe_activity", array("id" => $id))->row();
        $page = "toberegis/activity/update";
        $head = $data['activity']->title;

        $this->output($data, $page, $head);
    }

}
