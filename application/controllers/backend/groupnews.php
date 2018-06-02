<?php

/**
 * CreateModule : 28/06/2559
 * Author By kmniyom
 * Email : kimniyomclub@gmail.com
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class groupnews extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->model('news_model', 'news');
        $this->load->model('groupnews_model', 'groupnews');
        $this->load->helper('url');
        $this->load->library('session');
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

    public function index() {
        $sql = "SELECT * FROM style ";
        $rs = $this->db->query($sql)->row();
        $data['lastnewshow'] = $rs->showlastnews;
        $data['groupnews'] = $this->groupnews->get_groupnews_all();
        $page = "backend/groupnews/index";
        $head = "กลุ่มข่าวประชาสัมพันธ์";

        $this->output($data, $page, $head);
    }

    public function get_news() {
        $data['news'] = $this->groupnews->get_groupnews_all();
        $page = "backend/news/show_news";
        $head = "กลุ่มข่าวประชาสัมพันธ์";

        $this->output($data, $page, $head);
    }

    public function save() {
        $level = $this->tak->max_id("groupnews", "level");
        $column = $this->input->post('column');
        //$columns = $this->getcolumns($column);
        $data = array(
            'groupname' => $this->input->post('groupname'),
            'headcolor' => $this->input->post('headcolor'),
            'background' => $this->input->post('background'),
            'column' => $column,
            'create_date' => date('Y-m-d H:i:s'),
            'level' => $level
        );
        $this->db->insert('groupnews', $data);

        //echo $this->tak->redir('backend/news/from_upload_images_news/' . $_POST['new_id']);
    }

    public function update() {
        $Id = $this->input->post('id');
        $data['groupnews'] = $this->groupnews->get_groupnews_where($Id);
        $this->load->view("backend/groupnews/update", $data);
        //$head = "แก้ไขข้อมูลข่าว";
        //$this->output($data, $page, $head);
        //echo json_encode($json);
    }

    public function save_update() {
        $id = $this->input->post('id');
        $column = $this->input->post('column');
        //$columns = $this->getcolumns($column);
        $datas = array(
            'groupname' => $this->input->post('groupname'),
            'headcolor' => $this->input->post('headcolor'),
            'background' => $this->input->post('background'),
            'column' => $column
        );
        $this->db->where('id', $id);
        $this->db->update('groupnews', $datas);
        //echo $this->tak->redir('takmoph_admin/get_news/');
    }

    public function delete() {

        $groupID = $this->input->post('id');
        $groupnews = $this->news->get_news_ingroup($groupID);
        foreach ($groupnews->result() as $rs):
            $new_id = $rs->id;
            $sql = "SELECT * FROM images_news WHERE new_id = '" . $new_id . "'";
            $result = $this->db->query($sql);
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $rss):
                    unlink('upload_images/news/' . $rss->images);
                endforeach;
            }
            $this->db->where('new_id', $new_id);
            $this->db->delete('images_news');
        endforeach;

        $this->db->where('groupnews', $groupID);
        $this->db->delete('tb_news');

        $this->db->where('id', $groupID);
        $this->db->delete('groupnews');
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

    public function from_upload_images_news($new_id = '') {

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
            unlink("upload_images/news/" . $images);
        }

        $this->db->where("id", $id);
        $this->db->delete("images_news");
    }

    public function upload_images_news($new_id = '') {
        $targetFolder = 'upload_images/news'; // Relative to the root
        $toDatabase = true;
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $Name = "img_" . random_string('alnum', 30) . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;

            //$targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            $targetFile = $targetFolder . '/' . $Name;
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            //$GalleryShot = $_FILES['Filedata']['name'];
            if (in_array($fileParts['extension'], $fileTypes)) {
                $file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));
                $data = array(
                    'new_id' => $new_id,
                    'images' => $Name
                );
                $this->db->insert('images_news', $data);
                move_uploaded_file($tempFile, $targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function set_level() {
        $id = $this->input->post('id');
        $level = $this->input->post('level');

        $columns = array(
            "level" => $level
        );

        $this->db->where("id", $id);
        $this->db->update("groupnews", $columns);

        //echo "ID = ".$id." LEVEL = ".$level;
    }

    public function set_active() {
        $id = $this->input->post('id');
        $active = $this->input->post('active');

        $columns = array("active" => $active);
        $this->db->where("id", $id);
        $this->db->update("groupnews", $columns);
    }

    public function set_unactive() {
        $id = $this->input->post('id');
        $active = $this->input->post('active');

        $columns = array("active" => $active);
        $this->db->where("id", $id);
        $this->db->update("groupnews", $columns);
    }

    public function getcolumns($columns = null) {
        if ($columns == 1) {
            $c = "12";
        } else if ($columns == 2) {
            $c = "6";
        } else if ($columns == 3) {
            $c = "4";
        } else {
            $c = "4";
        }

        return $c;
    }
    
    public function setlastnews(){
        $val = $this->input->post('val');
        $columns = array("showlastnews" => $val);
        $this->db->update("style",$columns,'id = 1');
    }

}
