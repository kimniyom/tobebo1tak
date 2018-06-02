<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>AsbAdmin</title>

        <link rel="stylesheet" href="<?= base_url() ?>css/style.css" type="text/css" media="all" />
        <script src="<?= base_url(); ?>js/jquery-1.10.1.min.js"></script>

        <!-- Bootstrap -->
        <link href="<?= base_url(); ?>assets/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets/bootstrap-3.3.7/css/bootstrap.css.map" rel="stylesheet">
        <script src="<?= base_url(); ?>assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>
        <link href="<?= base_url(); ?>css/yamm3-master/yamm/yamm.css" rel="stylesheet">
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


        <?php
        $this->load->model('menubar_model', 'menu');
        $this->load->model('takmoph_model', 'tak');
        $this->load->model('counter_model');
        $model = new menubar_model();
        $style = $model->get_style();

        $menu_admin_type = $this->tak->get_menu_admin_type('0');
        ?>
    </head>

    <body >

        <nav class="navbar yamm navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Asb admin 0.8</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="<?= site_url('') ?>" id="_link">
                                <span class="fa fa-globe"></span> หน้าเว็บไซต์</a>
                        </li>

                        <li><a href="<?= site_url('takmoph_admin') ?>" id="_link">
                                <span class=" glyphicon glyphicon-home"></span> เมนูหลัก</a>
                        </li>


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="_link">
                                <i class="fa fa-desktop"></i> จัดการหน้าเว็บ <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url('backend/homepage/index') ?>"><i class="fa fa-archive text-primary"></i> ข้อมูลหน้าเว็บ</a></li>
                                <?php if ($this->session->userdata('status') == 'S') { ?>
                                    <li><a href="<?php echo site_url('backend/menubar/index') ?>"><i class="fa fa-magic text-warning"></i> Menu Bar</a></li>
                                    <li><a href="<?php echo site_url('backend/footer/index') ?>"><i class="fa fa-list-ol text-success"></i> Footer</a></li>
                                    <li><a href="<?php echo site_url('backend/manager/index') ?>"><i class="fa fa-user text-danger"></i> รูปผู้บริหาร</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li><a href="javascript:delete_cache()" id="_link"><i class="fa fa-trash text-warning"></i> ลบแคช</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="_link">
                                คุณ : <?= $this->session->userdata('name') ?><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php if ($this->session->userdata('status' == "A")) { ?>
                                    <li><a href="<?php echo site_url('backend/users/profile/' . $this->session->userdata('user_id')) ?>"><i class="fa fa-user"></i> โปรไฟล์</a></li>
                                    <li><a href="<?php echo site_url('backend/users/updateprofile/' . $this->session->userdata('user_id')) ?>"><i class="fa fa-pencil"></i> แก้ไขโปรไฟล์</a></li>
                                    <li class=" divider"></li>
                                <?php } ?>
                                <li class=""><a href="<?php echo site_url('users/logout') ?>"><i class="fa fa-power-off text-danger"></i> ออกจากระบบ</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!---------------------------------->
                </div><!--/.nav-collapse -->

            </div>
        </div>
    </nav>

    <!-- container -->
    <div class="container" style="width:100%; background:url(<?= base_url() ?>images/nav-bg.png) top; background-repeat:repeat-x; padding:0px;">
        <div class="container" style="width:100%; background:url(<?= base_url() ?>images/nav-bg-bottom.png) bottom; background-repeat:repeat-x; margin:0px;">
            <div align="center"><div class="clean_line"></div></div>


            <div class="container" style=" padding-top: 20px; padding-left: 0px; padding-right: 0px;">
                <!--
                <ul class="breadcrumb">
                    <li><a href="#">Home</a> <span class="divider"></span></li>
                    <li><a href="#">Library</a> <span class="divider"></span></li>
                    <li class="active">Data</li>
                </ul>
                -->
            </div>


            <div class="container" id="container" style=" padding-top: 20px; margin-bottom: 10px; background: none; box-shadow: none; border: 0px; word-wrap: break-word;">
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
        <div class="container" style="color:#FFFFFF; padding: 0px;">
            <div class="row" style="margin: 0px; padding: 0px; margin-top: 20px;">

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8" style=" padding: 0px; margin: 0px;">
                    <div id="counter-chart" style="height:200px;"></div>
                </div>
                <div class="col-md-6 col-lg-4" style=" padding-right: 0px;">
                    <div class="panel panel-default" style=" margin-right: 0px;">
                        <div class="panel-heading">สถิติการเข้าใช้งาน</div>
                        <div class="panel-body">
                            <table style=" width: 100%; color: #333333;">
                                <tbody>
                                    <tr>
                                        <td>จำนวนผู้เยี่ยมชมทั้งหมด</td>
                                        <td><span class="badge"><?php echo number_format($this->counter_model->counter()); ?></span></td>
                                        <td>คน</td>
                                    </tr>
                                    <tr>
                                        <td>จำนวนผู้เยี่ยมชมวันนนี้</td>
                                        <td><span class="badge"><?php echo number_format($this->counter_model->getcounterDay()); ?></span></td>
                                        <td>คน</td>
                                    </tr>
                                    <tr>
                                        <td>จำนวนผู้เยี่ยมชมเดือนนี้</td>
                                        <td><span class="badge"><?php echo number_format($this->counter_model->getcounterMonth()); ?></span></td>
                                        <td>คน</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <center><a href="http://www.theassemblers.net">theassemblers.net</a></center>
                </div>
            </div>
        </div>
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

    <script type="text/javascript">
        check_user();
        function check_user() {
            var status = "<?php echo $this->session->userdata('status'); ?>";
            if (status == '') {
                window.location = "<?php echo site_url('users/login') ?>";
            }
        }

        function delete_cache() {
            var url = "<?php echo site_url('backend/caching/index') ?>";
            var data = {a: 1};
            $.post(url, data, function (success) {
                alert("Delete Cache Success ...");
                window.location.reload();
            });
        }
    </script>

    <!-- Chart Counter -->

    <?php
    $monthvalue = $this->counter_model->group_month();
    $counter = $this->counter_model->counter();
    $month = $this->counter_model->getmonth();
    ?>
    <script>
        $(function () {
            // Create the chart
            $('#counter-chart').highcharts({
                chart: {
                    type: 'spline',
                    inverted: false
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: '<font style="color:#FFFFFF;">จำนวนผู้เข้าเว็บไซต์</font>',
                    x: -20 //center
                },
                subtitle: {
                    text: 'ทั้งหมด <?php echo $counter ?> คน',
                    x: -20
                },
                xAxis: {
                    categories: [<?php echo $month ?>]
                },
                yAxis: {
                    title: {
                        text: 'คน'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                tooltip: {
                    valueSuffix: 'คน'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                        name: 'จำนวน',
                        data: [<?php echo $monthvalue ?>]
                    }]
            });

        });


        function prints(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>

</body>
</html>
