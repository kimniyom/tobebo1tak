<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="content-language" content="th" />
        <title>TO BE NUMBER ONE</title>
        <?php
        $this->load->model('toberegis/toberegis_model', 'model');
        $type = $this->model->Type();
        $amphur = $this->model->Amphur();
        $this->load->library('session');
        ?>
        <style>
            #_links:hover{
                background:#000000; 
                color:#FFFFFF;
            }
        </style>
        <link rel="stylesheet" href="<?= base_url() ?>css/style.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/module/toberegis/css/toberegis.css" type="text/css" media="all" />
        <script src="<?= base_url(); ?>js/jquery-1.10.1.min.js"></script>

        <!-- Bootstrap -->
        <link href="<?= base_url(); ?>assets/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets/bootstrap-3.3.7/css/bootstrap-theme.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets/bootstrap-3.3.7/css/bootstrap.css.map" rel="stylesheet">
        <script src="<?= base_url(); ?>assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>
        <!-- awesome -->
        <link href="<?= base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/imgareaselect-animated.css" />
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.imgareaselect.pack.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/script.js"></script>

        <!-- Datatable -->
        <!--
        <link rel="stylesheet" href="<?//= base_url() ?>assets/DataTables-1.10.6/media/css/jquery.dataTables.css" type="text/css" media="all" />
        -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/DataTables-1.10.6/media/css/dataTables.bootstrap.css" type="text/css" media="all" />
        <script src="<?= base_url() ?>assets/DataTables-1.10.6/media/js/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/DataTables-1.10.6/media/js/dataTables.bootstrap.js" type="text/javascript"></script>

        <script src="<?= base_url() ?>assets/DataTables-1.10.6/extensions/FixedHeader/js/dataTables.fixedHeader.js" type="text/javascript"></script>

        <!-- Upload -->
        <script src="<?= base_url() ?>lib/js/jquery.uploadify-3.1.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>lib/css/uploadify.css">

        <!-- sweet-alert-->
        <link href="<?php echo base_url() ?>assets/sweet-alert/sweetalert.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url() ?>assets/sweet-alert/sweetalert.min.js" type="text/javascript"></script>

        <!-- Css Card -->
        <link href="<?php echo base_url() ?>assets/card-css/card-css.css" rel="stylesheet" type="text/css" />

        <!-- Color Picker -->
        <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() ?>assets/colorpicker/css/colorpicker.css" />
        <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() ?>assets/colorpicker/css/layout.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>assets/colorpicker/js/colorpicker.js"></script>

        <!-- Chart -->
        <script src="<?php echo base_url() ?>assets/Highcharts-4.2.3/js/highcharts.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/Highcharts-4.2.3/js/themes/grid-light.js" type="text/javascript"></script>

        <!-- images hover effect -->
        <link href="<?php echo base_url() ?>themes/2016/css/images-hover-effect.css" rel="stylesheet" type="text/css" />

        <!-- FullCarlendar-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/fullcalendar/fullcalendar.min.css">
        <script type="text/javascript" src="<?php echo base_url() ?>assets/fullcalendar/lib/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/fullcalendar/fullcalendar.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/fullcalendar/locale/th.js"></script>   

        <!--Date TimePicker-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
        <script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

        <!-- Notify -->
        <link rel="stylesheet" href="<?php echo base_url() ?>css/animate.css">
        <script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap-notify/bootstrap-notify.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url() ?>js/library/MD5.js"></script>

    </head>

    <body class="bodys">
        <!-- container -->
        <div class="container" style="width:100%; background:url(<?= base_url() ?>images/nav-bg.png) top; background-repeat:repeat-x; padding:0px;">
        <div style="background:#090909;">
                <div class="container">
                        <a class="navbar-brand" style="color:#FFFFFF;">TO BE NUMBER ONE TAK</a>
                        <?php if($this->session->userdata('status') == "S" || $this->session->userdata('user_register') != "") { ?>
                                    <div class="dropdown pull-right" style="margin-top:5px;">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown"  aria-expanded="false">

                                        <i class="fa fa-user">
                                            
                                        </i> <?php echo ($this->session->userdata('username')) ? $this->session->userdata('username') : $this->session->userdata('user_register_name') ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                                            <li><a href="<?php echo site_url('users/logout') ?>"><i class="fa fa-sign-out"></i> ออกจากระบบ</a> </li>
                                        
                                        </ul>
                                    </div>
                        <?php } else { ?>
                                    <a href="<?php echo site_url('users/login') ?>" class="btn btn-defaule pull-right" style="color:#FFFFFF; margin-top:5px;"><i class="fa fa-sign-in"></i> เข้าสู่ระบบ</a> 
                        <?php } ?>
                </div>
          </div>

            <nav class="navbar navbar-inverse" style=" border-radius: 0px;border:none;">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="<?= site_url('') ?>" id="_link">
                                    <span class="fa fa-globe text-success"></span> หน้าเว็บไซต์</a>
                            </li>
                            <li>
                                <a href="<?= site_url('toberegis/users/checkprivilege') ?>" id="_link">
                                    <span class="fa fa-check text-success"></span> ตรวจสอบรายชื่อ</a>
                            </li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="<?= site_url('toberegis/toberegis/register') ?>" id="_link">
                                        <span class="fa fa-users text-success"></span> สมัคสมาชิก</a>
                                </li>
                            </ul>
                        <?php if($this->session->userdata('status') == "S") { ?>
                        <ul class="nav navbar-nav navbar-right">
                            <!--
                                <li>
                                    <a href="javascript:openpopupformregister()" id="_links"><i class="fa fa-users"></i> ลงทะเบียนสมาชิก</a> 
                                </li>
                            -->
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" 
                                    aria-expanded="false" id="_links">
                                    <i class="fa fa-cog"></i> ตั้งค่า <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo site_url('toberegis/occupation/index') ?>">อาชีพ,สถานบริการ,หน่วยงาน,โรงเรียน</a></li>
                                        <li><a href="<?php echo site_url('toberegis/users/createuser') ?>">ผู้ใช้งาน</a></li>
                                    </ul>
                                </li>
                        </ul>
                        <?php }  ?>
                        <!---------------------------------->
                    </div><!--/.nav-collapse -->
                </div>
            </nav>

            <div class="container" style="width:100%; background:url(<?= base_url() ?>images/nav-bg-bottom.png) bottom; background-repeat:repeat-x; margin:0px;">

                <div class="container" id="container" style=" padding-top:0px; margin-bottom: 10px; background: none; box-shadow: none; border: 0px; word-wrap: break-word;">
                    <?php
                    if ($detail == "") {
                        $this->load->view($page . ".php");
                    } else {
                        $this->load->view($page . ".php", $detail);
                    }
                    ?>
                    <br/>
                    <div align="center"><img src="<?= base_url() ?>images/section-shadow.png" height="22" class="img-responsive"/></div>
                </div>

            </div>
        </div>

        <!-- footer -->
        <nav class="navbar navbar-inverse" style=" margin-bottom: 0px; border-radius: 0px;">
            <hr style="margin-bottom:10px;"/>
            <div class="container" style="margin-bottom:10px; color:#FFFFFF;">
                <center>
                    <b>Power By</b>
                    <img src="<?= base_url() ?>images/A_LOGO_W_full.png" style="height:42px;"/>
                    <img src="<?= base_url() ?>images/codeigniter.gif" style="height:42px;"/>Codeigniter
                    <img src="<?= base_url() ?>images/php.png" style="height:42px;"/> PHP
                    <img src="<?= base_url() ?>images/javascript-128.png" style="height:42px;"/> JavaScript
                    <img src="<?= base_url() ?>images/my_sql-128.png" style="height:42px;"/> MySql
                    <img src="<?= base_url() ?>images/22-128.png" style="height:42px;"/> HTML5
                    <img src="<?= base_url() ?>images/jquery.png" style="height:42px;"/> Jquery
                    <img src="<?= base_url() ?>images/boostrap-128.png" style="height:42px;"/> Bootstrap3

                </center>
            </div>
        </nav>

        <div class="modal fade" tabindex="-1" role="dialog" id="form-register-popup">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">เลือกสถานที่ / หน่วยบริการ</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="margin:0px;">
            <div class="col-md-12 col-lg-12">
                <label>อำเภอ</label>
                <select class="form-control" id="amphur" onchange="GetOffice()">
                    <option value="">เลือก</option>
                    <?php foreach ($amphur->result() as $am){ ?>
                    <option value="<?php echo $am->distid ?>"><?php echo $am->distname ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12 col-lg-12">
                        <label>ประเภท</label>
                <select class="form-control" id="type" onchange="GetOffice()">
                    <option value="">เลือก</option>
                    <?php foreach ($type->result() as $rs){ ?>
                    <option value="<?php echo $rs->id ?>"><?php echo $rs->typename ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12 col-lg-12">
                <div id="_office">
                <label>?</label>
                <select class="form-control" id="office">
                    <option value="">เลือก</option>
                </select>
                </div>
            </div>
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-block" onclick="register()">ตกลง</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

        <script type="text/javascript">
            function openpopupformregister(){
                $("#form-register-popup").modal();
            }

            function GetOffice(){
        var url = "<?php echo site_url('toberegis/toberegis/combooffice') ?>";
        var amphur = $("#amphur").val();
        var type = $("#type").val();
        var data = {amphur: amphur,type: type};
        if(amphur != "" && type !=""){
            $.post(url,data,function(datas){
                $("#_office").html(datas);
            });
        }
    }

    function register(){
        var amphur = $("#amphur").val();
        var type = $("#type").val();
        var office = $("#office").val();
        var url = "<?php echo site_url('toberegis/toberegis/register') ?>" + "/" + amphur + "/" + type + "/" + office;
        if(amphur != "" && type !="" && office != ""){
            window.location=url;
        } else {
            alert("เลือกข้อมูลไม่ครบ");
            return false;
        }
    }
        </script>
    </body>
</html>
