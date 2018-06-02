<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class complain extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->model('news_model', 'news');
        $this->load->model('complain_model', 'complain');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;
        $template = $this->template_model->get_template();
        $this->load->view($template['template'], $data);
    }

    public function Index() {
        $page = "complain/index";
        /*
          $sql = "SELECT * FROM captcha ORDER BY captcha_id DESC LIMIT 1";
          $rs = $this->db->query($sql)->row();
          $data['images'] = $rs->captcha_time;
          $data['word'] = $rs->word;
         * 
         */
        //echo 'พิมพ์ตัวอักษรที่เห็นในรูปด้านล่าง:';
        //echo $cap['image'];
        //$data['cap'] = $cap['image'];
        $data[] = "";
        //$this->SetCaptcha();
        $this->output($data, $page, "เรื่องร้องทุกข์");
    }

    public function SetCaptcha() {
        //$path = './captcha/';
        /*
          $delete = "DELETE FROM captcha";
          $this->db->query($delete);

          $files = glob($path . '*'); // get all file names
          foreach ($files as $file) { // iterate files
          if (is_file($file))
          unlink($file); // delete file
          }
         */
        $vals = array(
            /*
              'img_path' => './captcha/',
              'img_url' => 'http://example.com/captcha/',
              'img_height' => 100,
              'expiration' => 7200,
              'font_size' => 20,
             */
            'img_path' => 'captcha/',
            'img_url' => base_url() . 'captcha/',
            'img_width' => 190,
            'img_height' => 60,
            'font_size' => 40,
            'font_path' => FCPATH . 'captcha/font/Verdana.ttf',
            'expiration' => 7200
        );
        $cap = create_captcha($vals);
        $data = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $cap['word'],
        );
        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);
        $captchar = $cap['word'];
        //$this->session->set_userdata('captcha', $cap['word']);
        echo "<img src='".base_url().'captcha/'.$cap['time']. ".jpg' />";
        echo '<input type="hidden" id="recaptcha" value="' . $captchar . '"/>';
    }

    public function Send_complain() {
        $data = array(
            "name" => $this->input->post("name"),
            "email" => $this->input->post("email"),
            "card" => $this->input->post("card"),
            "tel" => $this->input->post("tel"),
            "head_complain" => $this->input->post("head_complain"),
            "detail" => $this->input->post("detail"),
            "d_update" => date("Y-m-d H:i:s"),
            "ip" => $this->input->ip_address()
        );

        $this->db->insert("complain", $data);
        $this->db->select_max('id');
        $result = $this->db->get('complain')->row();
        $json = array("complain_id" => $result->id);
        echo json_encode($json);
        /*
          $client = new SoapClient("http://tools.modoeye.com/thid/ws/?WSDL");
          $result = $client->Check(new SoapParam("1234567891011", "id"));
          var_dump($result);
         * 
         */
    }
    
    public function upload_images($complain_id = '') {
        $targetFolder = 'assets/module/complain/uploads'; // Relative to the root
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
                
                $width = 800; //*** Fix Width & Heigh (Autu caculate) ***//
                //$new_images = "Thumbnails_".$_FILES["Filedata"]["name"];
                $size = getimagesize($_FILES['Filedata']['tmp_name']);
                $height = round($width * $size[1] / $size[0]);
                $images_orig = imagecreatefromjpeg($tempFile);
                $photoX = imagesx($images_orig);
                $photoY = imagesy($images_orig);
                $images_fin = imagecreatetruecolor($width, $height);
                imagecopyresampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
                imagejpeg($images_fin, "assets/module/complain/uploads/" . $Name);
                imagedestroy($images_orig);
                imagedestroy($images_fin);
                
                $data = array(
                    'complain_id' => $complain_id,
                    'images' => $Name
                );
                $this->db->insert('complain_images', $data);
                //move_uploaded_file($tempFile, $targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }
    
    public function Getimages(){
        $complain_id = $this->input->post('complain_id');
        //$this->db->where("complain_id",$complain_id);
        $query = $this->db->get_where('complain_images', array('complain_id' => $complain_id));
        foreach($query->result() as $rs):
            echo "<img src='".base_url()."assets/module/complain/uploads/".$rs->images."' class='img-responsive'/><br/>";
        endforeach;
    }

    public function Success() {
        $page = "complain/success";
        $this->output("", $page, "เรื่องร้องทุกข์");
    }

    public function View() {
        $complain = new complain_model();
        $data['complain'] = $complain->Get_complainAll();
        $page = "complain/view";
        $this->output($data, $page, "เรื่องร้องทุกข์");
    }

    public function Detail() {
        $id = $this->uri->segment(3);
        $complain = new complain_model();
        $data['complain'] = $complain->Get_complain_By_id($id);

        $page = "complain/detail";
        $this->output($data, $page, "เรื่องร้องทุกข์");
    }

    public function Delet() {
        $id = $this->input->post("id");

        $query = $this->db->get_where('complain_images', array('complain_id' => $id));
        foreach($query->result() as $rs):
            unlink("assets/module/complain/uploads/".$rs->images);
        endforeach;
        
        
        $this->db->where("id", $id);
        $this->db->delete("complain");

    }

}
