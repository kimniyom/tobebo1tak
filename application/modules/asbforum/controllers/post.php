<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class post extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('asbforum/asbforum_model', 'forum');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('encrypt');
        //$this->load->library("security");
        $this->load->helper('captcha');
        $this->rand = random_string('numeric', 4);
        //$this->load->library('grocery_CRUD');
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
        $this->Aut();
        $page = "post/index";
        $data['lastpost'] = $this->Lastpost();
        $data['category'] = $this->db->get_where("forum_category", array("active" => "Y", "upper" => "0"));

        $this->output($data, $page, "ตั้งกระทู้");
    }

    public function Lastpost() {
        $sql = "SELECT p.*,u.alias,u.photo FROM forum_post p INNER JOIN forum_register u ON p.user_id = u.id WHERE p.flag = '0' ORDER BY p.id DESC LIMIT 100";
        $result = $this->db->query($sql);
        return $result;
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
            'word' => $this->rand,
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
        echo "<img src='" . base_url() . 'captcha/' . $cap['time'] . ".jpg' class='img img-responsive'/>";
        echo '<input type="hidden" id="recaptcha" value="' . $captchar . '"/>';
    }

    public function Getsubcategory() {
        $catid = $this->input->post('catid');
        $result = $this->db->get_where("forum_category", array("upper" => $catid));
        $rows = $result->num_rows();
        if ($rows > 0) {
            $str = "";
            $str .= "<div class='row' style='text-align: right;'><div class='col-md-3 col-lg-3'><label>ประเภทย่อย</label></div><div class='col-md-4 col-lg-4'>";
            $str .= "<select id='sub_cat' class='form-control select-box'>";
            foreach ($result->result() as $rs):
                $str .= "<option value='" . $rs->id . "'>" . $rs->title . "</option>";
            endforeach;
            $str .= "</select>";
            $str .= "</div></div>";
            echo $str;
        }
    }

    public function Getsubcategoryactive() {
        $catid = $this->input->post('catid');
        $active = $this->input->post('subcat_id');
        $result = $this->db->get_where("forum_category", array("upper" => $catid));
        $rows = $result->num_rows();
        if ($rows > 0) {
            $str = "";
            $str .= "<div class='row' style='text-align: right;'><div class='col-md-3 col-lg-3'><label>ประเภทย่อย</label></div><div class='col-md-4 col-lg-4'>";
            $str .= "<select id='sub_cat' class='form-control select-box'>";
            foreach ($result->result() as $rs):
                if ($rs->id == $active) {
                    $selected = "selected";
                } else {
                    $selected = "";
                };
                $str .= "<option value='" . $rs->id . "'" . $selected . ">" . $rs->title . "</option>";
            endforeach;
            $str .= "</select>";
            $str .= "</div></div>";
            echo $str;
        }
    }

    public function uoloads() {
        if ($this->session->userdata('forum_user_id') != '') {
            $targetFolder = 'assets/module/asbforum/albumphoto/'; // Relative to the root
            if (!empty($_FILES)) {

                $tempFile = $_FILES['Filedata']['tmp_name'];
                $FULLNAME = $_FILES['Filedata']['name'];
                $type = substr($FULLNAME, -3);
                $Name = "forum_" . random_string('alnum', 30) . "." . $type;
                //$targetFile = $targetFolder . '/' . $Name;
                // Validate the file type
                $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG'); // File extensions
                $fileParts = pathinfo($_FILES['Filedata']['name']);
                if (in_array($fileParts['extension'], $fileTypes)) {
                    //$file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));
                    $width = 1024; //*** Fix Width & Heigh (Autu caculate) ***//
                    //$new_images = "Thumbnails_".$_FILES["Filedata"]["name"];
                    $size = getimagesize($_FILES['Filedata']['tmp_name']);
                    $height = round($width * $size[1] / $size[0]);
                    $images_orig = imagecreatefromjpeg($tempFile);
                    $photoX = imagesx($images_orig);
                    $photoY = imagesy($images_orig);
                    $images_fin = imagecreatetruecolor($width, $height);
                    imagecopyresampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
                    imagejpeg($images_fin, $targetFolder . $Name);
                    imagedestroy($images_orig);
                    imagedestroy($images_fin);

                    $data = array(
                        'images' => $Name,
                        'user_id' => $this->session->userdata('forum_user_id')
                    );
                    $this->db->insert('forum_images', $data);

                    //move_uploaded_file($tempFile, $targetFile);
                    //echo $Name;
                    echo $Name;
                } else {
                    echo '0';
                }
            }
        } else {
            echo "0";
        }
    }

    public function Posts() {
        //$this->Aut();
        $user_id = $this->session->userdata("forum_user_id");
        if (!empty($this->input->post('subcategory'))) {
            $cat = $this->input->post('subcategory');
        } else {
            $cat = $this->input->post('category');
        }
        $columns = array(
            "title" => $this->input->post('title'),
            "category" => $cat,
            "detail" => $this->input->post('detail'),
            "privilege" => $this->input->post('privilege'),
            "user_id" => $user_id,
            "ip" => $this->input->ip_address(),
            "create_date" => date("Y-m-d H:i:s"),
            "d_update" => date("Y-m-d H:i:s")
        );

        $this->db->insert("forum_post", $columns);
        $this->db->select("MAX(id) AS maxid");
        $this->db->from("forum_post");
        $query = $this->db->get()->row();
        echo $query->maxid;
    }

    public function View() {
        //$this->Aut();
        $id = $this->uri->segment(4);
        $data['commnetID'] = $this->uri->segment(5);
        if ($data['commnetID'] != "") {
            $this->Updateflagrepost($data['commnetID']);
        }
        $result = $this->db->get_where("forum_post", array("id" => $id))->row();
        if (!empty($result->id)) {
            $data['users'] = $this->db->get_where("forum_register", array("id" => $result->user_id))->row();
            $data['post'] = $result;
            $catModel = $this->db->get_where("forum_category", array("id" => $result->category))->row();
            $data['category_name'] = $catModel->title;
            $data['typealert'] = $this->db->get("forum_typealert");
            $data['near'] = $this->Near($result->category, $id, 5);
            $this->Readpost($result->id);
            $this->output($data, "asbforum/post/view", $data['post']->id);
        } else {
            $this->Index();
        }
    }

    public function Updateflagrepost($commentID = null) {
        $columns = array("read_status" => "1");
        $this->db->where("comment_id", $commentID);
        $this->db->update("forum_repost", $columns);
    }

    public function Near($cat = null, $postID = null, $limit = null) {
        $sql = "SELECT * FROM forum_post WHERE category = '$cat' AND id != '$postID' AND flag='0' ORDER BY id DESC LIMIT $limit";
        $query = $this->db->query($sql);
        return $query;
    }

    public function Readpost($postID) {
        $this->db->select_max('readpost');
        $this->db->where('id', $postID);
        $result = $this->db->get('forum_post')->row();

        $Max = $result->readpost;
        $Read = ($Max + 1);

        $columns = array("readpost" => $Read);
        $this->db->where("id", $postID);
        $this->db->update("forum_post", $columns);
    }

    public function Informpost() {
        $post_id = $this->input->post('post_id');
        $user_id = $this->session->userdata("forum_user_id");
        $columns = array(
            "post_id" => $post_id,
            "user_id" => $user_id,
            "d_update" => date("Y-m-d H:i:s")
        );
        $this->db->insert("forum_inform_post", $columns);
    }

    public function Comment() {
        //$this->Aut();
        $user_id = $this->session->userdata("forum_user_id");
        $columns = array(
            "post_id" => $this->input->post('post_id'),
            "comment" => $this->input->post('comment'),
            "user_id" => $user_id,
            "ip" => $this->input->ip_address(),
            "create_date" => date("Y-m-d H:i:s")
        );

        $this->db->insert("forum_comment", $columns);

        $this->db->select("MAX(id) AS comment_id");
        $this->db->from("forum_comment");
        $rs = $this->db->get()->row();
        $comment_id = $rs->comment_id;

        $this->Saverepost($this->input->post('post_id'), $comment_id, $user_id);
    }

    public function Saverepost($post_id = null, $commnet_id = null, $user_id = null) {
        $rs = $this->db->get_where("forum_post", array("id" => $post_id))->row();
        if ($rs->user_id != $user_id) {
            $columns = array(
                "post_id" => $post_id,
                "comment_id" => $commnet_id,
                "user_id" => $user_id,
                "read_status" => "0",
                "d_update" => date("Y-m-d H:i:s")
            );

            $this->db->insert("forum_repost", $columns);
        }
    }

    public function loadcomment() {
        $post_id = $this->input->post('post_id');
        $user_id = $this->session->userdata('forum_user_id');
        $data['comment'] = $this->forum->Comment($post_id, $user_id);
        $data['commentActive'] = $this->input->post('comment_id');
        $data['post_id'] = $post_id;
        $this->load->view("asbforum/post/comment", $data);
    }

    public function deletecomment() {
        $id = $this->input->post('id');
        $this->db->where("id", $id);
        $this->db->delete("forum_comment");
    }

    public function deletecommentflag() {
        $id = $this->input->post('id');
        $user_id = $this->session->userdata("forum_user_id");
        $columns = array(
            "comment_id" => $id,
            "user_id" => $user_id,
            "d_update" => date("Y-m-d H:i:s")
        );
        $this->db->insert("forum_inform_comment", $columns);
    }

    public function Category() {
        $catID = $this->uri->segment('4');
        $Catmodel = $this->db->get_where("forum_category", array("id" => $catID))->row();
        if ($Catmodel->level == "1") {
            $getcat = $this->db->get_where("forum_category", array("upper" => $catID));
            $Subcat = array();
            foreach ($getcat->result() as $rs):
                $Subcat[] = $rs->id;
            endforeach;
            $subcatID = implode("','", $Subcat);
            $data['post'] = $this->forum->GetpostInCategory("'" . $subcatID . "'");
            $data['subcategory'] = $getcat;
        } else {
            $data['post'] = $this->forum->GetpostInCategory("'" . $catID . "'");
            $data['subcategory'] = "";
        }
        $data['upper'] = $Catmodel->upper;
        $head = $Catmodel->title;
        $data['category'] = $Catmodel;
        $page = "post/category";
        $this->output($data, $page, $head);
    }

    public function Editpost() {
        $id = $this->uri->segment(4);
        $result = $this->db->get_where("forum_post", array("id" => $id))->row();
        $data['post'] = $result;
        $catModel = $this->db->get_where("forum_category", array("id" => $result->category))->row();
        //เช็คหมวด

        if ($catModel->upper == "0") {
            $data['activecategory'] = $catModel->id;
            $data['activesubcategory'] = "";
        } else {
            $data['activecategory'] = $catModel->upper;
            $data['activesubcategory'] = $catModel->id;
        }
        $data['category_name'] = $catModel->title;
        $data['category'] = $this->db->get_where("forum_category", array("upper" => 0));
        $this->output($data, "asbforum/post/editpost", "แก้ไข");
    }

    public function Saveupdate() {
        $user_id = $this->session->userdata("forum_user_id");
        $post_id = $this->input->post("post_id");
        if (!empty($this->input->post('subcategory'))) {
            $cat = $this->input->post('subcategory');
        } else {
            $cat = $this->input->post('category');
        }
        $columns = array(
            "title" => $this->input->post('title'),
            "category" => $cat,
            "detail" => $this->input->post('detail'),
            "privilege" => $this->input->post('privilege'),
            "user_id" => $user_id,
            "ip" => $this->input->ip_address(),
            "d_update" => date("Y-m-d H:i:s")
        );
        $this->db->where("id", $post_id);
        $this->db->update("forum_post", $columns);
    }

    public function Forumrecomment() {
        //$this->Aut();
        $user_id = $this->session->userdata("forum_user_id");
        $columns = array(
            "post_id" => $this->input->post('post_id'),
            "comment" => $this->input->post('comment'),
            "comment_id" => $this->input->post('comment_id'),
            "user_id" => $user_id,
            "ip" => $this->input->ip_address(),
            "create_date" => date("Y-m-d H:i:s")
        );
        
        
        $this->db->insert("forum_recomment", $columns);

        $this->db->select("MAX(id) AS recomment_id");
        $this->db->from("forum_recomment");
        $rs = $this->db->get()->row();
        $recomment_id = $rs->recomment_id;
        $comment_id = $this->input->post('comment_id');
        $post_id = $this->input->post('post_id');
        $this->Saverecomment($post_id, $comment_id, $recomment_id,$user_id);
    }

    public function Saverecomment($post_id = null, $comment_id = null,$recomment_id = null, $user_id = null) {
        $rs = $this->db->get_where("forum_recomment", array("id" => $recomment_id))->row();
        
        if ($rs->user_id != $user_id) {
            $columns = array(
                "post_id" => $post_id,
                "comment_id" => $comment_id,
                "recomment_id" => $recomment_id,
                "user_id" => $user_id,
                "flag" => "1",
                "d_update" => date("Y-m-d H:i:s")
            );

            $this->db->insert("forum_inform_comment", $columns);
        }
  
    }
    
    public function Getrecomment(){
        $comment_id = $this->input->post('comment_id');
        $data['detailrecomment'] = "detailrecomment".$this->input->post('id');
        $data['recomment'] = $this->forum->Getrecomment($comment_id);
        $this->load->view('post/recomment',$data);
    }

}
