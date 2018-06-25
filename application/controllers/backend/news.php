<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class news extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->model('news_model', 'news');
        $this->load->model('groupnews_model', 'groupnews');
        $this->load->helper('url');
        $this->load->library('takmoph_libraries');
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->helper('string');
    }

    public function output($deta = '', $page = '', $head = '') {

        if (!empty($this->session->userdata['status']) && ($this->session->userdata['status'] == "S" || $this->session->userdata['status'] == "A")) {

            $data['detail'] = $deta;
            $data['page'] = $page;
            $data['head'] = $head;

            $this->load->view('template_admin', $data);
        } else {
            echo "<script>window.location='" . site_url('takmoph2014') . "'</script>";
        }
    }

    public function get_news($groupID = null) {
        $GroupNews = $this->groupnews->get_groupnews_where($groupID);
        $data['groupnews'] = $GroupNews;
        $data['news'] = $this->news->get_news_ingroup($data['groupnews']->id);
        $page = "backend/news/show_news";
        $head = "ข่าวประชาสัมพันธ์";

        $this->output($data, $page, $head);
    }

    public function create($groupID = null) {
        $GroupNews = $this->groupnews->get_groupnews_where($groupID);
        $data['groupnews'] = $GroupNews;
        $page = "backend/news/create";
        $head = "เพิ่ม";

        $this->output($data, $page, $head);
    }

    public function save_news() {
        //header("Content-Type: image/png");
        //$Qrcode = new Ciqrcode();
        $id = $this->input->post('new_id');
        $group = $this->input->post('groupnews');
        $qrcodeName = md5($group . $id . date("His")) . ".png";
        $data = array(
            'groupnews' => $group,
            'id' => $id,
            'titel' => $this->input->post('title'),
            'detail' => $this->input->post('detail'),
            'user_id' => $this->session->userdata('user_id'),
            'qrcode' => $qrcodeName,
            'date' => date('Y-m-d H:i:s')
        );

        $news_id = $this->takmoph_libraries->encode($id);
        //QrCode

        $params['data'] = base_url() . 'news/view/' . $news_id . '/' . $group;
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = 'qrcode/' . $qrcodeName;
        $this->ciqrcode->generate($params);

        $this->db->insert('tb_news', $data);

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
        $new_id = $_POST['id'];
        $data['news'] = $this->news->get_news_where($new_id);
        $this->load->view("backend/news/from_edit_news", $data);
        //$head = "แก้ไขข้อมูลข่าว";
        //$this->output($data, $page, $head);
        //echo json_encode($json);
    }

    public function edit_news() {
        //header("Content-Type: image/png");
        $new_id = $this->input->post('_new_id');
        $results = $this->db->get_where("tb_news", array("id" => $new_id));
        $rs = $results->row();
        if ($rs->qrcode == "") {
            $qrcodeName = md5($rs->groupnews . $new_id . date("His")) . ".png";
            $news_id = $this->takmoph_libraries->encode($new_id);
            //QrCode
            $params['data'] = base_url() . 'news/view/' . $news_id . '/' . $rs->groupnews;
            $params['level'] = 'H';
            $params['size'] = 10;
            //$params['savename'] = FCPATH . 'tes.png';
            $params['savename'] = 'qrcode/' . $qrcodeName;
            $this->ciqrcode->generate($params);
            $data_update = array(
                'titel' => $_POST['_title'],
                'detail' => $_POST['_detail'],
                'qrcode' => $qrcodeName
            );
        } else {
            $data_update = array(
                'titel' => $_POST['_title'],
                'detail' => $_POST['_detail']
            );
        }
        $this->db->where('id', $new_id);
        $this->db->update('tb_news', $data_update);


        //echo $this->tak->redir('takmoph_admin/get_news/');
    }

    public function delete_news() {

        $new_id = $this->input->post('news_id');

        $sql = "SELECT * FROM images_news WHERE new_id = '" . $new_id . "'";
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
        $this->db->delete('images_news');

        $this->db->where('id', $new_id);
        $this->db->delete('tb_news');

        //echo $this->tak->redir('backend/news/get_news/');
    }

    public function delete_news_flag() {
        $news_id = $this->input->post('news_id');

        $column = array(
            "flag_delete" => "1",
            "flag_delete_user" => $this->session->userdata('user_id')
        );

        $this->db->where("id", $news_id);
        $this->db->update("tb_news", $column);
    }

    public function from_upload_images_news($new_id = '', $groupID = null) {
        $GroupNews = $this->groupnews->get_groupnews_where($groupID);
        $data['groupnews'] = $GroupNews;

        $new_model = new news_model();
        $data['news'] = $new_model->get_news_where($new_id);

        $data['new_id'] = $new_id;
        $page = "backend/news/upload_images_news";
        $head = "รูปภาพข่าว";

        $this->output($data, $page, $head);
    }

    public function album_news() {
        $new_id = $_POST['news_id'];
        $data['images'] = $this->news->get_images_news($new_id);
        $this->load->view("backend/news/album_news", $data);
    }

    public function delete_images_news() {
        $id = $_POST['id'];
        $images = $_POST['images'];

        if (!empty($images)) {
            if (file_exists("upload_images/news/thumb/" . $images)) {
                unlink("upload_images/news/thumb/" . $images);
            }
            if (file_exists("upload_images/news/" . $images)) {
                unlink("upload_images/news/" . $images);
            }
        }

        $this->db->where("id", $id);
        $this->db->delete("images_news");
    }

    public function upload_images_news($new_id = '') {
        $targetFolder = 'upload_images/news'; // Relative to the root
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $Name = "img_" . random_string('alnum', 30) . "." . $type;
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
                    imagejpeg($images_fin, "upload_images/news/" . $Name);
                    imagedestroy($images_orig);
                    imagedestroy($images_fin);
                } else {
                    move_uploaded_file($tempFile, $targetFile);
                }

                $data = array(
                    'new_id' => $new_id,
                    'images' => $Name
                );
                $this->db->insert('images_news', $data);
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

    public function view($id) {
        $data['news'] = $this->db->get_where("tb_news", array("id" => $id))->row();
        $data['groupnews'] = $this->db->get_where("groupnews", array("id" => $data['news']->groupnews))->row();
        $sql = "SELECT * FROM images_news WHERE new_id = '$id' ORDER BY id ASC LIMIT 1";
        $result = $this->db->query($sql);
        $rs = $result->row();
        if ($rs) {
            $data['firstIMG'] = $rs->images;
        } else {
            $data['firstIMG'] = "";
        }

        $page = "backend/news/view";
        $head = $data['news']->titel;

        $this->output($data, $page, $head);
    }

    public function update($id) {
        $data['news'] = $this->db->get_where("tb_news", array("id" => $id))->row();
        $data['groupnews'] = $this->db->get_where("groupnews", array("id" => $data['news']->groupnews))->row();

        $page = "backend/news/update";
        $head = $data['news']->titel;

        $this->output($data, $page, $head);
    }

}
