<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Webboard</title>
        <?php
        $this->load->model('asbforum/asbforum_model', 'forum');
        $this->load->model('asbforum/user_model', 'userModel');
        ?>
        <link rel="stylesheet" href="<?= base_url() ?>css/style.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/module/asbforum/css/asbforum.css" type="text/css" media="all" />
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
        <script src="<?php echo base_url() ?>assets/Highcharts-4.2.3/js/themes/gray.js" type="text/javascript"></script>

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

        <script type="text/javascript">
            $(document).ready(function () {
                Repost();
                Recomment();
            });

            function Repost() {
                var url = "<?php echo site_url('asbforum/users/repost') ?>";
                var data = {};
                $.post(url, data, function (datas) {
                    $("#countreposts").html(datas);
                });
            }

            function Recomment() {
                var url = "<?php echo site_url('asbforum/users/recomment') ?>";
                var data = {};
                $.post(url, data, function (datas) {
                    $("#countrecomment").html(datas);
                });
            }
        </script>
    </head>

    <body class="bodys">
        <!-- container -->
        <div class="container" style="width:100%; background:url(<?= base_url() ?>images/nav-bg.png) top; background-repeat:repeat-x; padding:0px;">
            <div class=" container">
                <h3>กระดานสนทนา อบต.ตากตก</h3>
            </div>
            <nav class="navbar navbar-inverse" style=" border-radius: 0px;">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">webboard</a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="<?= site_url('') ?>" id="_link">
                                    <span class="fa fa-globe"></span> หน้าเว็บไซต์</a>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="_link">
                                    <i class="fa fa-commenting-o"></i> หมวด <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php
                                    $category_forum = $this->forum->Category();
                                    foreach ($category_forum->result() as $catforum):
                                        ?>
                                        <li><a href="<?php echo site_url('asbforum/post/category/' . $catforum->id) ?>"> <?php echo $catforum->title ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <li>
                                <a href="<?= site_url('') ?>" id="_link">
                                    <span class="fa fa-info-circle"></span> ข้อตกลงการใช้งาน</a>
                            </li>
                            <li><a href="<?php echo site_url('asbforum/post') ?>" id="_link"><i class="fa fa-plus-circle"></i> ตั้งกระทู้</a></li>
                            <form class="navbar-form navbar-left">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search" style=" color: #666666;">
                                </div>
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </form>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <?php if (!empty($this->session->userdata('forum_user_id'))) { ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="_link">
                                        <i class="fa fa-user"></i> คุณ : <?= $this->session->userdata('forum_user_alias') ?><span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo site_url('asbforum/users/profile/' . $this->session->userdata('user_id')) ?>"><i class="fa fa-user"></i> โปรไฟล์</a></li>
                                        <li><a href="<?php echo site_url('asbforum/users/updateprofile/' . $this->session->userdata('user_id')) ?>"><i class="fa fa-pencil"></i> แก้ไขโปรไฟล์</a></li>
                                        <li><a href="<?php echo site_url('asbforum/users/resetpassword/' . $this->session->userdata('user_id')) ?>"><i class="fa fa-key"></i> แก้ไขรหัสผ่าน</a></li>
                                        <li class=" divider"></li>
                                        <li class=""><a href="<?php echo site_url('asbforum/users/logout') ?>"><i class="fa fa-power-off text-danger"></i> ออกจากระบบ</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown" id="countreposts"></li>
                                <!--
                                <li class="dropdown" id="countrecomment"></li>
                                -->

                                <?php
                                /*
                                  $report = $this->userModel->Countrepost();
                                  $listreport = $this->userModel->Repost();
                                  if ($report > 0) {
                                 * 
                                 */
                                ?>
                                <!--
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="_link">
                                            <span class="badge" style=" background: #cc0000;" id="countrepost"><?php //echo $this->userModel->Countrepost()  ?></span><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                <?php //foreach ($listreport->result() as $rl): ?>
                                                <li>
                                                    <a href="<?php //echo site_url('asbforum/users/profile/' . $this->session->userdata('user_id'))  ?>">
                                                        <i class="fa fa-user"></i> <font style="color: #0099cc;"><b><?php //echo $rl->alias  ?></b> </font><?php //echo $rl->d_update  ?> 
                                                        <p class="pull-right" style="color: #0099cc;">#<?php //echo $rl->comment_id  ?></p><br/>
                                                        <i class="fa fa-comment-o"></i> <font style="color: #999999;">แสดงความคิดเห็นกระทู้</font> <?php //echo $rl->title  ?>
                                                    </a>
                                                </li>
                                <?php //endforeach; ?>
                                        </ul>
                                    </li>
                                -->
                                <?php //} ?>
                            <?php } else { ?>
                                <li>
                                    <a href="<?php echo site_url('asbforum/users/login') ?>">เข้าสู่ระบบ</a> 
                                </li>
                                <li>
                                    <a href="<?php echo site_url('asbforum/users/register') ?>">ลงทะเบียนใช้งาน</a> 
                                </li>
                            <?php } ?>
                        </ul>
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

    </body>
</html>
