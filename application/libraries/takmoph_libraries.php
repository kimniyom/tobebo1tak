<?php

//Create By Kimniyom

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class takmoph_libraries {

    var $skey = "SuPerEncKey2016"; // you can change it

    function breadcrumb($list = null, $active = null) {
        $icon = ' <i class="fa fa-angle-double-right"></i> ';
        $url = "";
        $label = "";

        $str = '<ol class="breadcrumb" style="background: none; margin-bottom:0px;  top:0px; left:0px; margin-left:0px; padding:0px;">';
        $str .= '<li><i class="fa fa-home"></i> <a href="' . site_url('') . '">หน้าแรก</a></li>';
        if (!empty($list)) {
            foreach ($list as $result):
                $url = site_url($result['url']);
                $label = $result['label'];
                if (!empty($label)) {
                    $str .= $icon;
                    $str .= '<li><a href = "' . $url . '">' . $label . '</a></li >';
                }
            endforeach;
        }
        $str .= $icon;
        $str .='<li class="active">' . $active . '</li>';
        $str .= '</ol>';

        return $str;
    }

    function breadcrumb_backend($list = null, $active = null, $urlhome = null) {
        if (!empty($urlhome)) {
            $home = $urlhome;
        } else {
            $home = "takmoph_admin";
        }
        $icon = ' <i class="fa fa-angle-double-right"></i> ';
        $url = "";
        $label = "";

        $str = '<ol class="breadcrumb pull-right" style="background: none; margin-bottom:0px;">';
        $str .= '<li><i class="fa fa-home"></i> <a href="' . site_url($home) . '">หน้าแรก</a></li>';
        if (!empty($list)) {
            foreach ($list as $result):
                $url = site_url($result['url']);
                $label = $result['label'];

                if (!empty($label)) {
                    $str .= $icon;
                    $str .= '<li><a href = "' . $url . '">' . $label . '</a></li >';
                }
            endforeach;
        }
        $str .= $icon;
        $str .='<li class="active">' . $active . '</li>';
        $str .= '</ol>';

        return $str;
    }

    function thaidate($dateformat = "") {
        $year = substr($dateformat, 0, 4);
        $month = substr($dateformat, 5, 2);
        $day = substr($dateformat, 8, 2);
        $thai = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

        if (strlen($dateformat) <= 10) {
            return $thaidate = (int) $day . " " . $thai[(int) $month] . " " . ($year + 543);
        } else {
            return $thaidate = (int) $day . " " . $thai[(int) $month] . " " . ($year + 543) . " เวลา " . substr($dateformat, 10);
        }
    }

    function url_encode($url = null) {
        return base64_encode(base64_encode(base64_encode($url)));
    }

    function url_decode($url = null) {
        return base64_decode(base64_decode(base64_decode($url)));
    }

    public function safe_b64encode($string) {

        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    /*
      public  function encode($value){

      if(!$value){return false;}
      $text = $value;
      $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
      $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
      $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
      return trim($this->safe_b64encode($crypttext));
      }

      public function decode($value){

      if(!$value){return false;}
      $crypttext = $this->safe_b64decode($value);
      $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
      $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
      $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
      return trim($decrypttext);
      }
     */

    function encode($url = null) {
        return base64_encode(base64_encode(base64_encode($url)));
    }

    function decode($url = null) {
        return base64_decode(base64_decode(base64_decode($url)));
    }

    function random_string($length) {
        return substr(str_repeat(md5(rand()), ceil($length / 32)), 0, $length);
    }

    function setcolumn($column = null, $images = null, $title = null, $date = null, $id = null, $group = null) {
        if (!empty($images)) {
            $img = "<img src='" . base_url() . "upload_images/news/" . $images . "' class='img-responsive img-polaroid' style='height:100px;'/>";
        } else {
            $img = "<img src='" . base_url() . "images/News-Mic-iPhone-icon.jpg' class='img-responsive img_news' style='max-width: 90px;'/>";
        }
        /*
          $text = strlen($title);
          if ($text > 250) {
          //echo iconv_substr($news->titel,'0','100')."...";
          $settitle = mb_substr($title, 0, 150, 'UTF-8') . "...";
          } else {
          $settitle = $title;
          }
         */
        $str = "
          <div class='font_news'>
            <a href='" . site_url('news/view/' . $id . '/' . $group) . "'>
                <div class='media hvr-bounce-to-right' id='box-lastnews' style='width: 100%; margin-bottom: 10px;'>
                    <span  class='pull-left'>" . $img . "</span>
                    <div clas='media-body'><font class='text-responsive'>" . $title . "</font><br/>
                        <font class='pull-right' style='font-size: 12px; margin-right:10px;'>" . $this->thaidate($date) . "</font>
                    </div>
                </div>
            </a>
          </div>";
        return $str;
    }

    function GetAge($dob){
        if($dob){
            $dob = date("Y-m-d",strtotime($dob));
            $dobObject = new DateTime($dob);
            $nowObject = new DateTime();
            $diff = $dobObject->diff($nowObject);
            return $diff->y;
        } else {
            return "-";
        }
    }

}
