<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class storeimg extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('storeimages_model', 'model');
        $this->load->model('resizeimages', 'imgmodel');
        $this->load->helper('url');
        $this->load->library('session');
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

    public function index($type) {
        $user_id = $this->session->userdata['user_id'];
        $data['folder'] = $this->model->get_folder_all_type($user_id, $type);
        if ($type == "0") {
            $text = "รูปภาพ";
        } else {
            $text = "ไฟล์";
        }
        $sql = "select * from storeimages_folder where user_id = '$user_id' AND type = '$type' limit 1";
        $rs = $this->db->query($sql)->row();
        if($rs){
            $dfolder = $rs->id;
        } else {
            $dfolder = "";
        }
        $data['folder_default'] = $dfolder;
        $data['head'] = $text;
        $data['type'] = $type;
        $page = "backend/storeimg/index";

        $this->load->view($page, $data);
    }

    public function createfolder() {
        $userid = $this->session->userdata('user_id');
        $foldername = $this->input->post('foldername');
        $type = $this->input->post('type');
        $ref = md5($userid . "_" . date("YmdHis") . $foldername);
        $pathFolder = "upload_images/" . $ref;
        if (!is_dir($pathFolder)) {//เช็คว่ามีชื่อโฟล์เดอร์นี้หรือไม่
            mkdir($pathFolder, 0777, true);
            mkdir($pathFolder . "/thumb", 0777, true);
            $columns = array(
                "folder_name" => $foldername,
                "ref" => $ref,
                "user_id" => $userid,
                "type" => $type,
                "create_date" => date("Y-m-d H:i:s")
            );
            $this->db->insert("storeimages_folder", $columns);
            echo "1";
        } else {
            echo "0";
        }
    }

    public function updatefolder() {
        $id = $this->input->post('folder_id');
        $folder_name = $this->input->post('foldername');

        $columns = array("folder_name" => $folder_name);
        $this->db->where("id", $id);
        $this->db->update("storeimages_folder", $columns);
    }

    public function viewfolder() {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $this->db->select_sum('size_mb');
        $result = $this->db->get_where('storeimages_list', array("folder_id" => $id))->row();
        $data['sum'] = "<em>size " . number_format($result->size_mb, 2) . "MB</em>";
        $data['folder'] = $this->db->get_where('storeimages_folder', array('id' => $id))->row();
        $sql = "select * from storeimages_list WHERE folder_id = '$id'";
        $data['images'] = $this->db->query($sql);
        $data['type'] = $type;
        if ($type == "0") {
            $data['filetype'] = "*.gif; *.JPG; *.jpg; *.png;";
            $data['buttonText'] = "เลือกรูปภาพ...";
            $data['upload'] = "upload";
        } else {
            $data['filetype'] = "*.zip; *.rar; *.pdf;";
            $data['buttonText'] = "เลือกไฟล์...";
            $data['upload'] = "uploadfile";
        }
        $this->load->view('backend/storeimg/listimages', $data);
    }

    public function uploadfile($folder_id) {
        $row = $this->db->get_where("storeimages_folder", array("id" => $folder_id))->row();
        $targetFolder = 'upload_images/' . $row->ref; // Relative to the root

        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = addslashes($_FILES['Filedata']['name']);
            $size = $_FILES['Filedata']['size'];
            $type = substr($FULLNAME, -3);
            $Name = "file_" . md5($FULLNAME) . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;
            $fileTypes = array('zip', 'rar', 'pdf'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);

            $sizeKB = ($size / 1024);
            $sizeMB = ($sizeKB / 1024);

            $imagesName = str_replace(".$type", "", $FULLNAME);
            if (in_array($fileParts['extension'], $fileTypes)) {
                $data = array(
                    'images' => $Name,
                    'images_name' => $imagesName,
                    'folder_id' => $folder_id,
                    'size_kb' => $sizeKB,
                    'size_mb' => $sizeMB
                );

                $this->db->insert('storeimages_list', $data);

                move_uploaded_file($tempFile, $targetFile);

                //$this->Thumnail($targetFolder . "/" . $Name, $targetFolder . "/thumb", $Name);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function upload($folder_id) {

        $row = $this->db->get_where("storeimages_folder", array("id" => $folder_id))->row();
        $targetFolder = 'upload_images/' . $row->ref; // Relative to the root

        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = addslashes($_FILES['Filedata']['name']);
            $size = $_FILES['Filedata']['size'];
            $type = substr($FULLNAME, -3);
            $Name = "img_" . md5($FULLNAME) . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;
            $fileTypes = array('jpg', 'png', 'gif'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);

            $sizeKB = ($size / 1024);
            $sizeMB = ($sizeKB / 1024);

            $imagesName = str_replace(".$type", "", $FULLNAME);
            if (in_array($fileParts['extension'], $fileTypes)) {
                $data = array(
                    'images' => $Name,
                    'images_name' => $imagesName,
                    'folder_id' => $folder_id,
                    'size_kb' => $sizeKB,
                    'size_mb' => $sizeMB
                );

                $this->db->insert('storeimages_list', $data);

                //$file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));
                $width = 1000; //*** Fix Width & Heigh (Autu caculate) ***//
                //$new_images = "Thumbnails_".$_FILES["Filedata"]["name"];
                $size = getimagesize($_FILES['Filedata']['tmp_name']);
                $height = round($width * $size[1] / $size[0]);
                $images_orig = imagecreatefromjpeg($tempFile);
                $photoX = imagesx($images_orig);
                $photoY = imagesy($images_orig);
                if ($photoY >= $width) {
                    $images_fin = imagecreatetruecolor($width, $height);
                    imagecopyresampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
                    imagejpeg($images_fin, $targetFolder . "/" . $Name);
                    imagedestroy($images_orig);
                    imagedestroy($images_fin);
                } else {
                    move_uploaded_file($tempFile, $targetFile);
                }
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
        /*
          $ImgModel = new ResizeImages();
          $ImgModel->load($original);
          $ImgModel->resize(200);
          $ImgModel->save($originalPath . '/icon_' . $name);
          $ImgModel->resizeToWidth(200);
          $ImgModel->save($originalPath . '/thumb_' . $name);
          $ImgModel->resizeToWidth(500);
          $ImgModel->save($originalPath . '/large_' . $name);
         * 
         */
    }

    public function Getdata() {
        $id = $this->input->post('folder_id');
        if ($id != "") {
            $data['folder_id'] = $id;
            $data['row'] = $this->db->get_where("storeimages_folder", array("id" => $id))->row();
            $data['images'] = $this->db->get_where("storeimages_list", array("folder_id" => $id));
        }
        if ($data['row']->type == "0") {
            $page = "backend/storeimg/images";
        } else {
            $page = "backend/storeimg/file";
        }
        $this->load->view($page, $data);
    }

    public function editimagename() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $columns = array("images_name" => $name);
        $this->db->where("id", $id);
        $this->db->update("storeimages_list", $columns);
    }

    public function deleteimages() {
        $id = $this->input->post('id');
        $rs = $this->db->get_where('storeimages_list', array('id' => $id))->row();
        $folder = $this->db->get_where('storeimages_folder', array('id' => $rs->folder_id))->row();

        unlink('upload_images/' . $folder->ref . "/thumb/" . $rs->images);
        unlink('upload_images/' . $folder->ref . "/" . $rs->images);

        $this->db->where("id", $id);
        $this->db->delete("storeimages_list");
    }

    public function deletefolder() {
        $id = $this->input->post('id');
        $folder = $this->db->get_where('storeimages_folder', array('id' => $id))->row();
        $result = $this->db->get_where('storeimages_list', array('folder_id' => $id));
        foreach ($result->result() as $rs):
            if (file_exists('upload_images/' . $folder->ref . "/" . $rs->images)) {
                unlink('upload_images/' . $folder->ref . "/thumb/" . $rs->images);
                unlink('upload_images/' . $folder->ref . "/" . $rs->images);
            }
        endforeach;
        if (is_dir('upload_images/' . $folder->ref . "/thumb")) {
            rmdir('upload_images/' . $folder->ref . "/thumb");
        }
        if (is_dir('upload_images/' . $folder->ref)) {
            rmdir('upload_images/' . $folder->ref);
        }
        $this->db->where("folder_id", $id);
        $this->db->delete("storeimages_list");

        $this->db->where("id", $id);
        $this->db->delete("storeimages_folder");
    }

}
