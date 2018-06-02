<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('asbforum/asbforum_model', 'forum');
        $this->load->model('asbforum/user_model', 'userModel');
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
        $page = "backend/index";
        $data = "";
        $this->output($data, $page, "ลงทะเบียน");
    }

    public function Register() {
        $page = "users/register";
        $data['agreement'] = $this->db->get("forum_agreement");
        $this->output($data, $page, "ลงทะเบียนใช้งาน");
    }

    public function Saveregister() {
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        $alias = $this->input->post('alias');

        //Check Email 
        $checkEmail = $this->db->get_where('forum_register', array('email' => $email))->row();
        if ($checkEmail->email != "") {
            echo "1";
        } else {
            $columns = array(
                "email" => $email,
                "username" => $username,
                "password" => $password,
                "alias" => $alias,
                "register_date" => date("Y-m-d H:i:s"),
                "register_update" => date("Y-m-d H:i:s")
            );
            $this->db->insert("forum_register", $columns);
            $this->db->where("email", $email);
            $this->db->where("password", $password);
            $query = $this->db->get('forum_register')->row();

            //AddTokenKey
            $Token = $this->encrypt->encode($query->id);
            $columnsUpdate = array("token_key" => $Token);
            $this->db->where("id", $query->id);
            $this->db->update("forum_register", $columnsUpdate);
            //ส่งอีเมล์
            $this->Sendmailer($query);

            echo "0";
        }
    }

    public function Sendmailer($users) {
        require("assets/module/asbforum/PHPMailer_v5.0.2/class.phpmailer.php");

        $this->db->select_max('id', 'ids');
        $result = $this->db->get('forum_config');
        $id = $result->row()->ids;
        $config = $this->db->get_where("forum_config", array("id" => $id))->row();

        $dates = date("Y-m-d");
        $times = date("H:i:s");
        $mail = new PHPMailer();

        $body = "คุณได้ทำการสมัครสมาชิกเข้ามาเมื่อวันที่  $dates เวลา $times <br/><br/>";
        $body .= "สมัคสมาชิก " . $config->title . "<br/>";
        $body .= "​Email : " . $users->email . "<br/>";
        $body .= "Alias: " . $users->alias . "<br/>";
        $body .= "<h3> <a href='" . base_url() . "asbforum/users/confirm/" . $users->token_key . "'> >> กดยืนยันที่นี้เพื่อเข้าใช้งาน << </a></h3>";
        $body .= "<hr/> ทีมพัฒนา : <a href='https://www.theassemblers.net'>theassemblers</a> | <a href='https://www.theassemblers.net/asbwebtools'>asbwebtools</a>";
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->Host = $config->smtp_server; // SMTP server
        $mail->Port = $config->port; // พอร์ท
        $mail->Username = $config->smtp_username; // account SMTP
        $mail->Password = $config->smtp_password; // รหัสผ่าน SMTP

        $mail->SetFrom($config->email_send, $config->name_send);
        $mail->AddReplyTo($users->email, $config->title);
        $mail->Subject = $config->title;
        $mail->MsgHTML($body);

        $mail->AddAddress($users->email, $users->alias); // ผู้รับคนที่หนึ่ง

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

    public function Login() {
        $page = "users/login";
        $data[''] = "";
        $this->output($data, $page, "Login");
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
        echo "<img src='" . base_url() . 'captcha/' . $cap['time'] . ".jpg' />";
        echo '<input type="hidden" id="recaptcha" value="' . $captchar . '"/>';
    }

    public function Checkloginforum() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $checkEmail = $this->db->get_where("forum_register", array("email" => $email))->num_rows();
        //$checkEmail = $this->db->num_rows();
        //$sql = "SELECT * FROM forum_register WHERE email = '$email'";
        //$checkEmail = $this->db->query($sql)->num_row();
        //echo $checkEmail;
        if ($checkEmail > 0) {
            $result = $this->db->get_where("forum_register", array("email" => $email))->row();
            if ($result->password == $password && $result->email == $email) {
                if ($result->active == 'Y') {
                    $this->session->set_userdata('forum_user_id', $result->id);
                    $this->session->set_userdata('forum_user_status', $result->status);
                    $this->session->set_userdata('forum_user_alias', $result->alias);
                    $this->session->set_userdata('forum_user_email', $result->email);
                    //Insert Log 
                    $columns = array(
                        "user_id" => $result->id,
                        "username" => $result->username,
                        "email" => $result->email,
                        "ip" => $this->input->ip_address(),
                        "d_update" => date("Y-m-d H:i:s")
                    );
                    $this->db->insert("forum_log", $columns);
                    echo "1"; //เข้าใช้งาน
                } else {
                    echo "2"; //ยังไม่ได้ยืนยันการใช้งาน
                }
            }
        } else {
            echo "0"; //ไม่ได้ลงทะเบียน
        }
    }

    // สร้างฟังก์ชั่นสำหรับส่งอีเมล โดยรับค่าตัวแปร $mailData เป้น array
    public function Sendemail($users) {

        /// BEGIN MAIL SETTINGS 
        // ดู gmail port เพิ่มเติมได้ที่ https://support.google.com/a/answer/176600?hl=en

        $config['useragent'] = 'อบต.ตากตก'; // กำหนดส่งจากอะไร เช่น ใช่ชื่อเว็บเรา
        $config['protocol'] = 'smtp';  // สามารถกำหนดเป็น mail , sendmail และ smtp
        $config['smtp_host'] = 'mail.maeramad-hospital.go.th';
        $config['smtp_user'] = 'kimniyom@maeramad-hospital.go.th';
        $config['smtp_pass'] = '2FKrMHn7A';
        $config['smtp_port'] = '25';
        $config['smtp_crypto'] = 'tls'; // รูปแบบการเข้ารหัส กำหนดได้เป้น tls และ ssl
        $config['mailtype'] = 'html'; // กำหนดได้เป็น text หรือ html
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        ///// END MAIL SETTINGS
        // ส่งจากอีเมล - ชื่อ
        /*
          $this->email->from($mailData['mail_email'], $mailData['mail_name']);
          $this->email->to('demo@localhost.com', 'Demo User'); // ส่งถึง
         * 
         */

        $this->email->from("admin@abt-taktok.go.th", "อบต.ตากตก");
        $this->email->to($users->email, $users->alias); // ส่งถึง
        // หากต้องการส่งแบบให้มี cc หรือ bcc กำหนดตามด้านล่าง
//        $this->email->cc('another@another-example.com');
//        $this->email->bcc('them@their-example.com');        
        // หากต้องการแนบไฟล์ กำหนดตามนี้
//        $this->email->attach('/path/to/photo1.jpg');
//        $this->email->attach('/path/to/photo2.jpg');
//        $this->email->attach('/path/to/photo3.jpg');        
        // หรือ แนบไฟล์แบบให้แสดงในอีเมลเลย เหมาะกับรูป
//        $this->email->attach('image.jpg', 'inline');
        // หรือ แนบไฟล์แบบกำหนด url เข้าไปตรงๆ เลย      
        //$this->email->attach('http://www.ninenik.com/filename.pdf');
        // หรือแบบอัพโหลดไฟล์
//        $this->email->attach($buffer, 'attachment', 'report.pdf', 'application/pdf');

        /*
          $content = " ท่านได้สมัคสมาชิกเข้าใช้งานกระดานสนทนาบนเว็บไซต์ ";
          $content .= "<a href=www.abt-taktok.go.th>www.abt-taktok.go.th</a> <br/>";
          $content .= "<h3>>> กดที่นี้เพื่อยืนยันการเข้าใช้งาน <<</h3><br/>";
          $content .= "</hr>ทีมพัฒนา : www.theassemblers.net | <a href=www.theassemblers.net/asbwebtools>asbwebtools</a>";
         */

        //$content = "ท่านได้สมัคสมาชิกเข้าใช้งานกระดานสนทนาบนเว็บไซต์";
        //$content .= 'www.abt-taktok.go.th/asbforum/users/confirmemail';
        //$content .= '<a href="www.abt-taktok.go.th"><h3> >> กดที่นี้เพื่อยืนยันการเข้าใช้งาน << </h3></a><br/>';
        //$content .= 'ทีมพัฒนา : www.theassemblers.net | www.theassemblers.net/asbwebtools';
        $data = "";
        $content = $this->load->view('users/contentmail', $data, true);
        $this->email->subject("สมัคสมาชิกกระดานสนทนา asbforum"); // หัวข้อที่ส่ง
        $this->email->message($content);  // รายละเอียด
        $this->email->set_newline("\r\n");
        return $this->email->send();   // คืนค่าการทำงานว่าเป็น true หรือ false      
    }

    public function Confirm() {
        $token = $this->uri->segment(4);

        $check = $this->db->get_where("forum_register", array("token_key" => $token))->row();

        if (isset($check->id)) {
            $columns = array("active" => "Y");
            $this->db->where("id", $check->id);
            $this->db->update("forum_register", $columns);
            $content = "<br/><br/><div class='alert alert-success'><i class='fa fa-check'></i>ยืนยันตัวตนสำเร็จ</div>";
            $content .= "<center><br/><a href='" . site_url('asbforum/users/login') . "'><h3>เข้าใช้งาน</h3></a></center><br/><br/>";
        } else {
            $content = "<br/><br/><div class='alert alert-danger'><i class='fa fa-remove'></i>ข้อมูลไม่ถูกต้องกรุณาตรวจสอบ</div>";
            $content .= "<center><br/><a href='" . site_url('asbforum/users/register') . "'><h3>ลงทะเบียนใช้งาน</h3></a></center><br/><br/>";
        }

        $page = "users/confirm";
        $data['content'] = $content;
        $this->output($data, $page, "ยีนยันการใช้งาน");
    }

    public function Updateprofile() {
        $this->Aut();
        $id = $this->session->userdata("forum_user_id");
        $this->db->select("*");
        $this->db->from("forum_register");
        $this->db->where("id", $id);
        $query = $this->db->get();

        $this->db->where("user_id", $id);
        $this->db->order_by("id", "desc");
        $this->db->limit("1");
        $q = $this->db->get("forum_log")->row();

        $data['last_update'] = $q->d_update;
        $data['user'] = $query->row();
        $page = "users/updateprofile";
        $this->output($data, $page, "แก้ไข");
    }

    public function Saveupdateprofile() {
        $token = $this->input->post('token');
        $name = $this->input->post('name');
        $username = $this->input->post('username');
        $lname = $this->input->post('lname');
        $alias = $this->input->post('alias');
        $tel = $this->input->post('tel');

        $columns = array(
            "name" => $name,
            "username" => $username,
            "lname" => $lname,
            "alias" => $alias,
            "tel" => $tel,
            "register_date" => date("Y-m-d H:i:s"),
            "register_update" => date("Y-m-d H:i:s")
        );
        $this->db->update("forum_register", $columns);
        $this->db->where("token_key", $token);
    }

    public function Profile() {
        $this->Aut();
        $id = $this->session->userdata("forum_user_id");
        $this->db->select("*");
        $this->db->from("forum_register");
        $this->db->where("id", $id);
        $query = $this->db->get();

        $this->db->where("user_id", $id);
        $this->db->order_by("id", "desc");
        $this->db->limit("1");
        $q = $this->db->get("forum_log")->row();

        $data['last_update'] = $q->d_update;
        $data['user'] = $query->row();
        $data['countpost'] = $this->userModel->CountPost($id);
        $page = "users/profile";
        $this->output($data, $page, $data['user']->alias);
    }

    public function Getimgprofile() {
        $token = $this->input->post('token');
        $rs = $this->db->get_where("forum_register", array("token_key" => $token))->row();
        if ($rs->photo != '') {
            echo "<img src='" . base_url() . "assets/module/asbforum/uploads/$rs->photo' style='height:120px;'/>";
        } else {
            echo "<img src='" . base_url() . "assets/module/asbforum/images/profile-icon.png' style='height:120px;'/>";
        }
    }

    public function Uploadphoto($token = '') {
        $targetFolder = 'assets/module/asbforum/uploads'; // Relative to the root
        $this->db->where('token_key', $token);
        $result = $this->db->get('forum_register')->row();
        if ($result->photo) {
            if (file_exists($targetFolder . "/" . $result->photo)) {
                unlink($targetFolder . "/" . $result->photo);
            }
        }
        //$toDatabase = true;
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $NameFile = "file_" . $token;
            $Name = $NameFile . "." . $type;
            $targetFile = $targetFolder . '/' . $Name;

            //$targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            $targetFile = $targetFolder . '/' . $Name;
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'png'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array($fileParts['extension'], $fileTypes)) {
                //$file_string = addslashes(fread(fopen($thefile[tmp_name], "r"), $thefile[size]));

                $data = array(
                    'photo' => $Name,
                );
                $this->db->where('token_key', $token);
                $this->db->update('forum_register', $data);

                move_uploaded_file($tempFile, $targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function Logout() {
        $this->session->unset_userdata('forum_user_id');
        $this->session->unset_userdata('forum_user_status');
        $this->session->unset_userdata('forum_user_alias');
        $this->session->unset_userdata('forum_user_email');

        redirect('/asbforum/users/login');
    }

    public function Updateemail() {
        $email = $this->input->post('email');
        $token = $this->input->post('token');
        $password = $this->input->post('password');

        //Check Password
        $users = $this->db->get_where('forum_register', array('token_key' => $token))->row();
        if ($users->password != $password) {
            echo "1";
        } else {
            $columns = array(
                "email" => $email,
                "active" => "N",
                "register_date" => date("Y-m-d H:i:s"),
                "register_update" => date("Y-m-d H:i:s")
            );
            $this->db->where("token_key", $token);
            $this->db->update("forum_register", $columns);

            //ส่งอีเมล์
            $this->SendmailerUpdateEmail($users);

            echo "0";
        }
    }

    public function SendmailerUpdateEmail($users) {
        require("assets/module/asbforum/PHPMailer_v5.0.2/class.phpmailer.php");

        $this->db->select_max('id', 'ids');
        $result = $this->db->get('forum_config');
        $id = $result->row()->ids;
        $config = $this->db->get_where("forum_config", array("id" => $id))->row();

        $dates = date("Y-m-d");
        $times = date("H:i:s");
        $mail = new PHPMailer();

        $body = "แก้ไข Email สมาชิกเมื่อวันที่  $dates เวลา $times <br/><br/>";
        //$body .= "​Email : " . $users->email . "<br/>";
        $body .= "Alias: " . $users->alias . "<br/>";
        $body .= "<h3> <a href='" . base_url() . "asbforum/users/confirm/" . $users->token_key . "'> >> กดยืนยันที่นี้เพื่อเข้าใช้งาน << </a></h3>";
        $body .= "<hr/> ทีมพัฒนา : <a href='https://www.theassemblers.net'>theassemblers</a> | <a href='https://www.theassemblers.net/asbwebtools'>asbwebtools</a>";
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->Host = $config->smtp_server; // SMTP server
        $mail->Port = $config->port; // พอร์ท
        $mail->Username = $config->smtp_username; // account SMTP
        $mail->Password = $config->smtp_password; // รหัสผ่าน SMTP

        $mail->SetFrom($config->email_send, $config->name_send);
        $mail->AddReplyTo($users->email, "แก้ไข Email");
        $mail->Subject = "แก้ไข Email";
        $mail->MsgHTML($body);

        $mail->AddAddress($users->email, $users->alias); // ผู้รับคนที่หนึ่ง

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {

            //echo "Message sent!";
        }
    }

    public function Resetpassword() {
        $this->Aut();
        $id = $this->session->userdata("forum_user_id");
        $this->db->select("*");
        $this->db->from("forum_register");
        $this->db->where("id", $id);
        $query = $this->db->get();

        $data['user'] = $query->row();
        $page = "users/resetpassword";
        $this->output($data, $page, "resetpassword");
    }

    public function Saveresetpassword() {
        $token = $this->input->post('token');
        $password = $this->input->post('password');
        $newpassword = $this->input->post('newpassword');
        //Check Password
        $users = $this->db->get_where('forum_register', array('token_key' => $token))->row();
        if ($users->password != $password) {
            echo "1";
        } else {
            $columns = array(
                "password" => md5($newpassword),
                "register_date" => date("Y-m-d H:i:s"),
                "register_update" => date("Y-m-d H:i:s")
            );
            $this->db->where("token_key", $token);
            $this->db->update("forum_register", $columns);

            //ส่งอีเมล์
            $this->SendmailerUpdatePassword($users);

            echo "0";
        }
    }

    public function SendmailerUpdatePassword($users) {
        require("assets/module/asbforum/PHPMailer_v5.0.2/class.phpmailer.php");

        $this->db->select_max('id', 'ids');
        $result = $this->db->get('forum_config');
        $id = $result->row()->ids;
        $config = $this->db->get_where("forum_config", array("id" => $id))->row();

        $dates = date("Y-m-d");
        $times = date("H:i:s");
        $mail = new PHPMailer();

        $body = "แก้ไข รหัสผ่าน สมาชิกเมื่อวันที่  $dates เวลา $times <br/><br/>";
        //$body .= "​Email : " . $users->email . "<br/>";
        $body .= "Alias: " . $users->alias . "<br/>";
        $body .= "ท่านได้แก้ไขรหัสผ่าน " . $config->title;
        $body .= "<hr/> ทีมพัฒนา : <a href='https://www.theassemblers.net'>theassemblers</a> | <a href='https://www.theassemblers.net/asbwebtools'>asbwebtools</a>";
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->Host = $config->smtp_server; // SMTP server
        $mail->Port = $config->port; // พอร์ท
        $mail->Username = $config->smtp_username; // account SMTP
        $mail->Password = $config->smtp_password; // รหัสผ่าน SMTP

        $mail->SetFrom($config->email_send, $config->name_send);
        $mail->AddReplyTo($users->email, "แก้ไข รหัสผ่าน");
        $mail->Subject = "แก้ไข รหัสผ่าน";
        $mail->MsgHTML($body);

        $mail->AddAddress($users->email, $users->alias); // ผู้รับคนที่หนึ่ง

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {

            //echo "Message sent!";
        }
    }

    public function Post() {
        $token = $this->input->post('token');
        $sql = "SELECT p.*,c.title as cat_name 
                FROM forum_post p 
                INNER JOIN forum_category c ON p.category = c.id 
                INNER JOIN forum_register r ON p.user_id = r.id
                WHERE r.token_key = '$token' AND p.flag = '0'
                ORDER BY p.create_date DESC";
        $data['postall'] = $this->db->query($sql);
        $this->load->view("users/post", $data);
    }

    public function Lastpost() {
        $token = $this->input->post('token');
        $data['postall'] = $this->userModel->LastPostUser($token);
        $this->load->view("users/lastpost", $data);
    }

    public function Test() {
        $this->load->view('users/contentmail');
    }

    public function Viewpost() {
        $this->Aut();
        $id = $this->uri->segment(4);
        $user_id = $this->session->userdata("forum_user_id");
        $data['users'] = $this->userModel->UserDetail($user_id);
        $data['post'] = $this->userModel->viewpost($id);
        $this->output($data, "asbforum/users/viewpost", $data['post']->id);
    }

    public function Repost() {
        $report = $this->userModel->Countrepost();
        $listreport = $this->userModel->Repost();
        $user_id = $this->session->userdata('user_id');
        $str = "";
        if ($report > 0) {
            //$str .= '<li class="dropdown">';
            $str .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="_link">';
            $str .= '<span class="badge" style=" background: #cc0000;">' . $report . '</span><span class="caret"></span></a>';
            $str .= '<ul class="dropdown-menu">';
            foreach ($listreport->result() as $rl):
                $link = site_url('asbforum/post/view/' . $rl->post_id . "/" . $rl->comment_id);
                $str .= '<li style="border-bottom:#c4c4c4 solid 1px;">';
                $str .= '<a href="' . $link . '">';
                $str .= '<i class="fa fa-user"></i> <font style="color: #0099cc;"><b>' . $rl->alias . '</b> </font>' . $rl->d_update;
                $str .= ' <font style="color: #0099cc;">#' . $rl->comment_id . '</font><br/>';
                $str .= '<i class="fa fa-comment-o"></i> <font style="color: #999999;">แสดงความคิดเห็นกระทู้</font> #' . $rl->post_id;
                $str .= '</a>';
                $str .= '</li>';
            endforeach;
            $str .= '<li style="text-align:center;"><a href="">..ทั้งหมด..</a></li>';
            $str .= '</ul>';
            //$str .= '</li>';
            echo $str;
        }
    }

    public function Recomment() {
        $recomment = $this->userModel->Countrecomment();
        $str = "";
        //if ($recomment > 0) {
            //$str .= '<li class="dropdown">';
            $str .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="_link">';
            $str .= '<span class="badge" style=" background: #cc0000;">' . $recomment . '</span><span class="caret"></span></a>';
            $str .= '<ul class="dropdown-menu">';

            $str .= '<li style="text-align:center;"><a href="">..ทั้งหมด..</a></li>';
            $str .= '</ul>';
            //$str .= '</li>';
            echo $str;
        //}
    }

}
