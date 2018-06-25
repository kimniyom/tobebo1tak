<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class upload_photo extends CI_Controller {
    /*
     *  Creart Code By kimniyom
     *  Date 27/05/2556 | Time 22.26.00
     *
     */

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('upload_model', 'upload');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function output($deta = '', $page = '', $head = '') {
        $data['detail'] = $deta;
        $data['page'] = $page;
        $data['head'] = $head;

        $this->load->view('template_admin', $data);
    }

    public function save_edit_album() {
        $data = array(
            'AlbumName' => $_POST['AlbumName'],
            'detail' => $_POST['detail']
        );
        $this->db->where('AlbumID', $_POST['AlbumID']);
        $this->db->update('album', $data);
    }

    public function del_album() {
        $AlbumID = $_POST['AlbumID'];

        $sql_gallert = "SELECT * FROM gallery WHERE AlbumID = '$AlbumID' ";
        $re = $this->db->query($sql_gallert);
        foreach ($re->result() as $dd):
            unlink('album/gallery/' . $dd->GalleryShot);
            $sql_del = "DELETE FROM gallery WHERE AlbumID = '$AlbumID' ";
            $this->db->query($sql_del);
        endforeach;

        /* สั่งลบตารางอัลบั้ม */
        $sql = "SELECT * FROM album WHERE AlbumID = '$AlbumID' ";
        $result = $this->db->query($sql);
        $row = $result->row();
        unlink('album/gallery/' . $row->AlbumShot);
        $sql_del_album = "DELETE FROM album WHERE AlbumID = '$AlbumID' ";
        $this->db->query($sql_del_album);
    }

    public function del_gallery() {
        $GalleryID = $_POST['GalleryID'];
        $GalleryShot = $_POST['GalleryShot'];
        if ($GalleryShot != '') {
            unlink('album/gallery/' . $GalleryShot);
        }
        $sql_del_gallery = "DELETE FROM gallery WHERE GalleryID = '$GalleryID' ";
        $this->db->query($sql_del_gallery);
    }

    public function from_show_album() {
        $head = "อัลบั้มภาพทั้งหมด";
        $page = "photo/from_show_album";
        $data['album'] = $this->upload->get_album_all();

        $this->output($data, $page, $head);
    }

    public function from_create_album() {
        $head = "สร้างอัลบั้มภาพใหม่";
        $page = "photo/upload_shot_album";
        $AlbumID = $this->upload->get_id_album();
        $data['Album_id'] = ($AlbumID + 1);

        $this->output($data, $page, $head);
    }

    /* #################################### Crop Images ##################################### */

    public function upload_shot_photo() {
        $valid_exts = array('jpeg', 'jpg', 'png', 'gif', 'JPG');
        $max_file_size = 400 * 1024; #200kb
        $nw = $nh = 400; # image with # height

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['image'])) {
                if (!$_FILES['image']['error'] && $_FILES['image']['size'] < $max_file_size) {
                    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, $valid_exts)) {
                        $path = 'album/gallery/' . $_FILES['image']['name'];
                        $size = getimagesize($_FILES['image']['tmp_name']);

                        $x = (int) $_POST['x'];
                        $y = (int) $_POST['y'];
                        $w = (int) $_POST['w'] ? $_POST['w'] : $size[0];
                        $h = (int) $_POST['h'] ? $_POST['h'] : $size[1];

                        $data = file_get_contents($_FILES['image']['tmp_name']);
                        $vImg = imagecreatefromstring($data);
                        $dstImg = imagecreatetruecolor($nw, $nh);
                        imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh, $w, $h);
                        imagejpeg($dstImg, $path);
                        imagedestroy($dstImg);

                        /* ############ Insert File ############# */
                        $AlbumID = $_POST['AlbumID'];
                        $AlbumShot = $_FILES['image']['name'];

                        $data_up = array(
                            'AlbumID' => $AlbumID,
                            'AlbumShot' => $AlbumShot,
                            'AlbumName' => $_POST['AlbumName'],
                            'detail' => $_POST['detail'],
                            'date' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('album', $data_up);

                        $deta['album'] = $this->upload->get_album($AlbumID);
                        $deta['gallery'] = $this->upload->get_gallery($AlbumID);
                        $page = "photo/from_show_gallery";
                        $head = "";

                        $this->output($deta, $page, $head);
                    } else {
                        echo 'unknown problem!';
                    }
                } else {
                    echo 'file is too small or large';
                }
            } else {
                echo 'file not set';
            }
        } else {
            echo 'bad request!';
        }
    }

    public function show_gallery($AlbumID = '') {
        $head = "";
        $page = "photo/from_show_gallery";
        $data['album'] = $this->upload->get_album($AlbumID);
        $data['gallery'] = $this->upload->get_gallery($AlbumID);

        $this->output($data, $page, $head);
    }

    public function from_upload_gallery($AlbumID = '') {
        $head = "อัพโหลดรูปภาพ";
        $page = "photo/upload_gallery";
        $data['AlbumID'] = $AlbumID;

        $this->output($data, $page, $head);
    }

    public function upload_gallery($AlbumID = '') {
        $targetFolder = 'album/gallery'; // Relative to the root
        $toDatabase = true;
        if (!empty($_FILES)) {

            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $targetFolder;
            $targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            $GalleryShot = $_FILES['Filedata']['name'];
            if (in_array($fileParts['extension'], $fileTypes)) {
                $file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $data = array(
                    'AlbumID' => $AlbumID,
                    'GalleryName' => "0",
                    'GalleryShot' => $GalleryShot
                );
                $this->db->insert('gallery', $data);
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

    public function file_upload_submenu($sub_id = '') {
        $targetFolder = 'file_download'; // Relative to the root
        $toDatabase = true;
        if (!empty($_FILES)) {

            $tempFile = $_FILES['Filedata']['tmp_name'];

            $targetPath = $targetFolder;
            $targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            // Validate the file type
            $fileTypes = array('rar', 'zip', 'doc', 'ppt', 'pdf', 'PDF'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            $file = $_FILES['Filedata']['name'];
            if (in_array($fileParts['extension'], $fileTypes)) {
                $file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $data = array(
                    'file' => $file
                );
                $this->db->where('sub_id', $sub_id);
                $this->db->update('sub_menu', $data);
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

    

    public function file_upload_dengue($id = '') {
        $targetFolder = 'file_download'; // Relative to the root
        $toDatabase = true;
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $Name = "file_" . date('YmdHis') . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;

            //$targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            $targetFile = $targetFolder . '/' . $Name;
            // Validate the file type
            $fileTypes = array('rar', 'zip', 'doc', 'ppt', 'pdf'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array($fileParts['extension'], $fileTypes)) {
                $file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $data = array(
                    'file' => $Name
                );
                $this->db->where('id', $id);
                $this->db->update('dengue', $data);
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

    public function upload_banner() {
        $targetFolder = 'images/images_slide'; // Relative to the root
        $toDatabase = true;
        if (!empty($_FILES)) {

            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $targetFolder;
            $targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            $GalleryShot = $_FILES['Filedata']['name'];
            if (in_array($fileParts['extension'], $fileTypes)) {
                $file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $data = array(
                    'banner' => $GalleryShot
                );
                $this->db->insert('banner', $data);
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

    public function upload_icon_menu_admin($admin_menu_id = '') {
        $targetFolder = 'icon_menu'; // Relative to the root
        $toDatabase = true;
        if (!empty($_FILES)) {

            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $targetFolder;
            $targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            $GalleryShot = $_FILES['Filedata']['name'];
            if (in_array($fileParts['extension'], $fileTypes)) {
                $file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));
                $data = array(
                    'admin_menu_images' => $GalleryShot
                );
                $this->db->where('admin_menu_id', $admin_menu_id);
                $this->db->update('admin_menu', $data);
                move_uploaded_file($tempFile, $targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function upload_img_menu_admin() {
        $targetFolder = 'icon_menu'; // Relative to the root
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $Name = "menu_" . date('YmdHis') . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;

            //$targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            $targetFile = $targetFolder . '/' . $Name;
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);

            if (in_array($fileParts['extension'], $fileTypes)) {
                //$file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));
                $data = array(
                    'admin_menu_images' => $Name
                );
                $this->db->insert('admin_menu', $data);
                move_uploaded_file($tempFile, $targetFile);

                echo "1";
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function GetImg() {
        $tak = new takmoph_model();
        $data['datas'] = $tak->GetMenuId();
        $this->load->view('admin/GetImg', $data);
    }

    public function DelImgAdminMenu() {
        $admin_menu_id = $_POST['admin_menu_id'];
        $sql = "SELECT admin_menu_images FROM admin_menu WHERE admin_menu_id = '$admin_menu_id' ";
        $result = $this->db->query($sql)->row();
        if (isset($result)) {
            unlink('icon_menu/' . $result->admin_menu_images);
        }

        $this->db->where("admin_menu_id = '$admin_menu_id' ");
        $this->db->delete(admin_menu);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
