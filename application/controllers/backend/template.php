<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class template extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('unzip');
        $this->load->helper('file');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;

        $this->load->view("template_admin", $data);
    }

    public function index() {
        $page = "backend/template/index";
        $head = "Template";
        $this->output($data = '', $page, $head);
    }

    public function set_template() {
        $id = $this->input->post('id');
        $this->db->select("template");
        $this->db->from("template");
        $this->db->where("id", $id);
        $query = $this->db->get();
        $rs = $query->row();
        $columns = array("active" => '0');
        $this->db->update("template", $columns, "active = 1");

        $themes = $rs->template;
        $columnsSet = array("active" => '1');
        $this->db->update("template", $columnsSet, "id = '$id' ");
        $this->session->set_userdata("pathThemes", "themes/" . $themes);
        $this->session->set_userdata("template", 'template/' . $themes . '/index');
    }

    public function page() {
        $page = "backend/template/themes";
        $Model = new template_model();
        $data['themes'] = $Model->get_template_setup();

        $this->load->view($page, $data);
    }

    public function upload() {
        if ($this->session->userdata('user_id') != '') {
            $targetFolder = 'themes'; // Relative to the root
            if (!empty($_FILES)) {

                $tempFile = $_FILES['Filedata']['tmp_name'];
                $FULLNAME = $_FILES['Filedata']['name'];
//$type = substr($FULLNAME, -3);
                $Name = $FULLNAME;
                $targetFile = $targetFolder . '/' . $Name;
                $FileName = explode('.', $Name);
                $nof = substr($Name, 0, -(strlen($FileName[count($FileName) - 1]) + 1));

//$targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
                $targetFile = $targetFolder . '/' . $Name;
// Validate the file type
                $fileTypes = array('zip', 'rar'); // File extensions
                $fileParts = pathinfo($_FILES['Filedata']['name']);
                if (in_array($fileParts['extension'], $fileTypes)) {
                    if (!is_dir($targetFolder . '/' . $nof)) {
                        /*
                          $data = array(
                          'template' => $nof
                          );
                          $this->db->insert('template', $data);
                         */
                        move_uploaded_file($tempFile, $targetFile);
//$this->unzip->allow(array('css', 'js', 'png', 'gif', 'jpeg', 'jpg', 'tpl', 'html', 'swf'));
                        $this->unzip->extract($targetFolder . '/' . $Name);
                        unlink($targetFolder . '/' . $Name);


//$this->unzip->extract('uploads/my_archive.zip', '/path/to/directory/');
//เช็คว่ามีไฟล์ Index ใน Folder ไหม 
                        if (file_exists($targetFolder . '/' . $nof . '/index.php')) {
//สร้าง Folder ใน views
                            $pathTemplate = "application/views/template/" . $nof;
                            if (!is_dir($pathTemplate)) {//เช็คว่ามีชื่อโฟล์เดอร์นี้หรือไม่
                                mkdir($pathTemplate, 0777, true);
//เอาไฟล์ Index เข้าไปใน Folder

                                copy($targetFolder . '/' . $nof . '/index.php', $pathTemplate . '/index.php');
                                $NewName = $rest = substr($Name, 0, -4);  // returns "cde" 
                                $columns = array("template" => $NewName, "active" => '0');
                                $this->db->insert("template", $columns);
                            } else {
                                echo "error";
                            }
                        } else {
                            echo "error";
                        }
                        echo $Name;
                    } else {
                        echo "error";
                    }
                } else {
                    echo 'Invalid file type.';
                }
            }
        } else {
            echo "0";
        }
    }

    public function Deletetemplate() {
        $id = $this->input->post('id');
        $sql = "SELECT * FROM template WHERE id = '$id' ";
        $rs = $this->db->query($sql)->row();

        if (!empty($rs->template)) {
            $dirtemplate = "themes/" . $rs->template;
            exec("rm -r -f $dirtemplate");
            $dirindex = "application/views/template/" . $rs->template;
            exec("rm -r -f $dirindex");

            $this->db->delete("template", "id = '$id' ");
        }
    }

    function delete_directory() {
        $id = $this->input->post('id');
        //$id = 17;
        $sql = "SELECT * FROM template WHERE id = '$id' ";
        $rs = $this->db->query($sql)->row();

        if ($rs->template) {
            $dirname = "themes/" . $rs->template;
            $this->Deletetemplates($dirname);

            $dirindex = "application/views/template/" . $rs->template;
            unlink($dirindex . "/index.php");
            rmdir($dirindex);

            $this->db->delete("template", "id = '$id' ");
        }
    }

    function Deletetemplates($dirname) {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        if (!$dir_handle)
            return false;

        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file))
                    unlink($dirname . "/" . $file);
                //echo $dirname . "/" . $file . "<br/>";
                else
                    $this->Deletetemplates($dirname . '/' . $file);
            }
        }

        closedir($dir_handle);
        rmdir($dirname);

        return true;
    }

}
