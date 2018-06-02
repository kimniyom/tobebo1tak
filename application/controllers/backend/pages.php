<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->model('news_model', 'news');
        $this->load->model('page_model', 'page');
        $this->load->library('Ciqrcode', 'ciqrcode');

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
            echo "<script>window.location='" . site_url('users/login') . "'</script>";
        }
    }

    public function index() {
        $data['menu_admin'] = $this->tak->get_menu_admin();
        $data['menu_admin_type'] = $this->tak->get_menu_admin_type('0');
        $page = "home_admin";
        $this->output($data, $page, '');
    }

    public function output_user($deta = '', $page = '', $head = '') {

        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;

        $this->load->view('template_admin', $data);
    }

    public function getpage($id = '') {
        $TakModel = new takmoph_model();
        $data['pageid'] = $TakModel->GetMaxId("dengue", "id") + 1;
        $data['admin_menu_id'] = $id;
        $data['dengue'] = $this->tak->get_dengue($id);
        $page = "backend/pages/index";
        $head = $this->tak->Get_name_group($id);

        if ($this->session->userdata('status') != '') {
            $this->output($data, $page, $head);
        } else {
            $this->output_user($data, $page, $head);
        }
    }

    public function save() {
        //$group = $this->input->post('group');
        $admin_menu_id = $this->input->post('admin_menu_id');
        $data = array(
            'id' => $this->input->post('id'),
            'title' => $this->input->post('title'),
            'admin_menu_id' => $admin_menu_id,
            'user_id' => $this->session->userdata('user_id'),
            'detail' => $this->input->post('detail'),
            'd_update' => date("Y-m-d H:i:s")
        );
        $this->db->insert('dengue', $data);

        /*
          $sql = "SELECT MAX(id) AS id FROM dengue";
          $result = $this->db->query($sql);
          $row = $result->row();
         */
        //$json = array("id" => $row->id,"admin_menu_id" => $admin_menu_id);
        //echo json_encode($json);
        //echo $this->tak->redir('takmoph_admin/from_upload_file_dengue/' . $row->id . '/' . $_POST['admin_menu_id']);
    }

    public function uploadfile($id = '') {
        $targetFolder = 'file_download'; // Relative to the root
        //$toDatabase = true;
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $NameFile = "file_" . date('YmdHis');
            $Name = $NameFile . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;

            //$targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            $targetFile = $targetFolder . '/' . $Name;
            // Validate the file type
            $fileTypes = array('rar', 'zip', 'doc', 'ppt', 'pdf'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array($fileParts['extension'], $fileTypes)) {
                //$file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $data = array(
                    'file' => $Name,
                    'qrcode' => $NameFile . '.png'
                );
                $this->db->where('id', $id);
                $this->db->update('dengue', $data);

                //QrCode
                $params['data'] = base_url() . 'qrcode/' . $Name;
                $params['level'] = 'H';
                $params['size'] = 10;
                //$params['savename'] = FCPATH . 'tes.png';
                $params['savename'] = 'qrcode/' . $NameFile . '.png';
                $this->ciqrcode->generate($params);

                //$query="INSERT INTO gallery (AlbumID,GalleryShot) VALUES ('$AlbumID','".$_FILES['Filedata']['name']."')";
                //$result = mysql_query($query);
                //mysql_free_result($result);
                move_uploaded_file($tempFile, $targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function saveupdate() {
        $id = $this->input->post('id');
        //$admin_menu_id = $this->input->post('admin_menu_id');
        $data = array(
            'title' => $this->input->post('title'),
            //'admin_menu_id' => $admin_menu_id,
            'user_id' => $this->session->userdata('user_id'),
            'detail' => $this->input->post('detail')
        );
        $this->db->where("id", $id);
        $this->db->update('dengue', $data);

        /*
          $sql = "SELECT MAX(id) AS id FROM dengue";
          $result = $this->db->query($sql);
          $row = $result->row();
         */
        //$json = array("id" => $row->id,"admin_menu_id" => $admin_menu_id);
        //echo json_encode($json);
        //echo $this->tak->redir('takmoph_admin/from_upload_file_dengue/' . $row->id . '/' . $_POST['admin_menu_id']);
    }

    public function updateuploadfile($id = '') {
        $Model = new page_model();
        $rs = $Model->getpagebyid($id);

        $targetFolder = 'file_download'; // Relative to the root

        if ($rs->file) {
            unlink($targetFolder . "/" . $rs->file);
            if (file_exists("qrcode/" . $rs->qrcode)) {
                unlink("qrcode/" . $rs->qrcode);
            }
        }

        //$toDatabase = true;
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $NameFile = "file_" . date('YmdHis');
            $Name = $NameFile . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;

            //$targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            $targetFile = $targetFolder . '/' . $Name;
            // Validate the file type
            $fileTypes = array('rar', 'zip', 'doc', 'ppt', 'pdf'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array($fileParts['extension'], $fileTypes)) {
                //$file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $data = array(
                    'file' => $Name,
                    'qrcode' => $NameFile . '.png'
                );
                $this->db->where('id', $id);
                $this->db->update('dengue', $data);

                //QrCode
                $params['data'] = base_url() . 'qrcode/' . $Name;
                $params['level'] = 'H';
                $params['size'] = 10;
                //$params['savename'] = FCPATH . 'tes.png';
                $params['savename'] = 'qrcode/' . $NameFile . '.png';
                $this->ciqrcode->generate($params);
                //$query="INSERT INTO gallery (AlbumID,GalleryShot) VALUES ('$AlbumID','".$_FILES['Filedata']['name']."')";
                //$result = mysql_query($query);
                //mysql_free_result($result);
                move_uploaded_file($tempFile, $targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function view($id = '', $admin_menu_id = '') {
        $Model = new page_model();
        $data['datas'] = $Model->getpagebyid($id);
        $data['group'] = $this->tak->Get_name_group($admin_menu_id);
        $data['admin_menu_id'] = $admin_menu_id;
        $data['id'] = $id;
        $page = "backend/pages/view";
        $head = $data['datas']->title;

        $this->output($data, $page, $head);
    }

    public function create($id = '', $admin_menu_id = '') {
        $data['group'] = $this->tak->Get_name_group($admin_menu_id);
        $data['admin_menu_id'] = $admin_menu_id;
        $data['id'] = $id;
        $page = "backend/pages/create";
        $head = "เพิ่มหัวข้อ";

        $this->output($data, $page, $head);
    }

    public function update($id = '', $admin_menu_id = '') {
        $Model = new page_model();
        $data['datas'] = $Model->getpagebyid($id);
        $data['group'] = $this->tak->Get_name_group($admin_menu_id);
        $data['admin_menu_id'] = $admin_menu_id;
        $data['id'] = $id;
        $page = "backend/pages/update";
        $head = $data['datas']->title;

        $this->output($data, $page, $head);
    }

    public function delete() {

        $id = $this->input->post('id');
        //$admin_menu = $this->input->post('admin_menu');
        //ดึงข้อมูลไฟล์ขึ้มา
        $sql = "SELECT * FROM dengue WHERE id = '$id' ";
        $rs = $this->db->query($sql)->row();

        if (!empty($rs->file)) {
            unlink('file_download/' . $rs->file);
            if (file_exists("qrcode/" . $rs->qrcode)) {
                unlink("qrcode/" . $rs->qrcode);
            }
        }

        $this->db->where('id', $id);
        $this->db->delete('dengue');
    }

    public function delete_file() {

        $id = $this->input->post('id');
        //$admin_menu = $this->input->post('admin_menu');
        //ดึงข้อมูลไฟล์ขึ้มา
        $sql = "SELECT * FROM dengue WHERE id = '$id' ";
        $rs = $this->db->query($sql)->row();

        if (!empty($rs->file)) {
            unlink('file_download/' . $rs->file);
            if (file_exists("qrcode/" . $rs->qrcode)) {
                unlink("qrcode/" . $rs->qrcode);
            }
        }

        $this->db->where('id', $id);
        $this->db->delete('dengue');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */