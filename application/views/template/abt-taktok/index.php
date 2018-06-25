<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <?php
        //Use Model,libraries
        $this->load->library('takmoph_libraries');
        $this->load->driver('cache');
        //$this->load->model('modulemanager/modulemanager_model');
        $barmodel = new menubar_model();
        $lib = new takmoph_libraries();
        $groupnewsModel = new groupnews_model();
        $newsModel = new news_model();
        $photoModel = new photo_model();
        $style = $barmodel->get_style();
        $navbar = $barmodel->get_navbarmenu_all();
        $templateModel = $this->template_model->get_template();
        $path = $templateModel['path'];
        $manager = $this->manager_model->get_manager()->row();
        $module = new modulemanager_model();
        ?>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="content-language" content="th" />
        <meta property="og:type" content="website" />
        <meta property="fb:app_id" content="266256337158296" />
        <meta property="og:title" content="<?php echo $this->session->userdata('fbtitle'); ?>" />

        <meta property="og:image" content="<?php echo $this->session->userdata('fbimages'); ?>" />
        <meta property="og:url" content="<?php echo $this->session->userdata('fburl'); ?>" />
        <meta property="og:site_name" content="<?php echo $style->webname_short ?>" />

        <meta name="description" content="อบต,อบต.,บ้านตาก,ตาก,จังหวัดตาก,ตากตก,องค์การบริหารส่วนตำบล,เว็บไซต์,ฟรีเว็บไวต์,<?php echo $style->webname_short ?>,<?php echo $style->webname_full ?>" />
        <meta name="keywords" content="อบต,อบต.,บ้านตาก,ตาก,จังหวัดตาก,ตากตก,องค์การบริหารส่วนตำบล,เว็บไซต์,ฟรีเว็บไวต์,<?php echo $style->webname_short ?>,<?php echo $style->webname_full ?>" />
        <meta name="robots" content="index, follow" />
        <meta name="author" content="">
        <title><?php echo $style->webname_short ?> | <?php echo $style->webname_full ?></title>
        <link rel="shortcut icon" href="<?php echo base_url() ?>upload_images/logo/<?php echo $style->logo ?>">

        <?php //echo $this->background_model->background_active() ?>
        <style type="text/css">
            #body{<?php echo $this->background_model->background_active() ?>;} 

            #nav-bar ul li a:active{ background: <?php echo $style->color_head ?>;}
            #nav-bar ul li a:after{ background: <?php echo $style->color_head ?>;}
            #nav-bar ul li a:hover{ background: <?php echo $style->color_head ?>;}
            #nav-bar ul li a:focus{ background: <?php echo $style->color_head ?>;}
            #set-nav-bar{
                border-top:#eeeeee solid 2px;
            }
        </style>
        <!-- New Themes -->
        <link href="<?php echo base_url() ?><?php echo $path ?>/css/system.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url() ?>js/jquery-1.11.3.min.js" type="text/javascript"></script>

        <!-- Bootstrap 3-->
        <link href="<?php echo base_url() ?><?php echo $path ?>/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?><?php echo $path ?>/css/bootstrap-flatly.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url() ?><?php echo $path ?>/js/bootstrap.js" type="text/javascript"></script>
        <link href="<?php echo base_url() ?><?php echo $path ?>/css/half-slider.css" rel="stylesheet" type="text/css" />
        <!-- FullCarlendar-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/fullcalendar/fullcalendar.min.css">
        <script type="text/javascript" src="<?php echo base_url() ?>assets/fullcalendar/lib/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/fullcalendar/fullcalendar.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/fullcalendar/locale/th.js"></script>  

        <!-- Datetime Picker --> 
        <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" type="text/css" media="all" />
        <script src="<?= base_url() ?>assets/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

        <!-- Icon aware-some -->
        <link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />


        <!-- Datatable -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/DataTables-1.10.10/media/css/dataTables.bootstrap.css" type="text/css" media="all" />
        <script src="<?= base_url() ?>assets/DataTables-1.10.10/media/js/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/DataTables-1.10.10/media/js/dataTables.bootstrap.js" type="text/javascript"></script>

        <!-- Assets -->
        <link href="<?php echo base_url() ?><?php echo $path ?>/css/card-css.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>css/hover.css" rel="stylesheet" type="text/css" />

        <!-- Jquery.Bxslide-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/jquery.bxslider/jquery.bxslider.css" media="screen">
        <script src="<?php echo base_url() ?>assets/jquery.bxslider/jquery.bxslider.js"></script>

        <!-- fancybox -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/fancyBox2.1.5/source/jquery.fancybox.css" media="screen">
        <script src="<?php echo base_url() ?>assets/fancyBox2.1.5/source/jquery.fancybox.js"></script>

        <!-- images hover effect -->
        <link href="<?php echo base_url() ?><?php echo $path ?>/css/images-hover-effect.css" rel="stylesheet" type="text/css" />

        <!-- Scroller -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/scrollbar/jquery.mCustomScrollbar.min.css" />
        <script src="<?php echo base_url() ?>assets/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>




    </head>

    <body id="body">
        <div id="bg-main-head-color"></div>
        <div id="bg-main-head" style=" width: 100%;  margin-bottom: 0px; padding-bottom: 0px;">
            <div id="bg-cloud"></div>
            <!--
            <div class="container" id="main-contents" style=" z-index: 500;">
                <div class="btn btn-default pull-right" id="sign-in" >
                    <a href="<?//php echo site_url('users/login') ?>" style="z-index: 100;color:#FFFFFF;"><i class="fa fa-lock"></i> เข้าสู่ระบบ</a>
                </div>

                <div id="head-logo" style=" font-size: 28px; z-index: 100; color:#FFFFFF;padding-left:0px; margin-left:0px;">
                    <img src="<?//php echo base_url() ?>upload_images/logo/<?//php echo $style->logo ?>" style=" height: 52px;"/>
                    <?//php echo $style->webname_full ?>
                </div>
            </div>
            -->
            <div class="container">
                <div class="row" style=" margin: 0px; max-height: 200px; max-height: 200px;" id="bg-main-ban-head">
                    <div class="col-md-5 col-lg-5" id="bannerhead-logo">
                        <img src="<?php echo base_url('images/logo-long.png') ?>"/>
                    </div>

                    <div class="col-md-4 col-lg-4" id="bannerhead-trip">
                        <img src="<?php echo base_url('images/tak-trip.png') ?>"/>
                    </div>
                    <div class="col-md-3 col-lg-3" id="bannerhead-king">
                        <img src="<?php echo base_url() ?>images/headbanner-king.png" class="img-responsive"/>
                    </div>

                </div> 
                <nav class="navbar navbar-default" role="navigation" id="nav" style="margin-bottom:0px; background: <?php echo $style->color_head ?>; border:none;"><!--*id="nav-bar"-->
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class=" container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
                                    style=" background: <?php echo $style->color_head ?>; border:none;" id="hamberger">
                                <span class="sr-only">Toggle navigation</span>
                                <!--
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                -->
                                <font style="color:<?php echo $style->color_text ?>;"><i class="fa fa-bars"></i> Menu</font>
                            </button>
                            <a class="navbar-brand" href="#" style=" margin-top: 0px; color: <?php echo $style->color_text ?>;"><?php echo $style->webname_short ?></a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="border:none;">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="<?php echo site_url() ?>" style="color:<?php echo $style->color_text ?>;"><i class="fa fa-home"></i> หน้าแรก</a>
                                </li>

                                <!-- GetMenuBar -->

                                <?php
                                foreach ($navbar->result() as $nb):
                                    ?>
                                    <?php if ($nb->type == '0') { ?>
                                        <li>
                                            <a href="<?php echo site_url('site/page/' . $this->takmoph_libraries->encode($nb->id)) ?>"
                                               style="color:<?php echo $style->color_text ?>;">
                                                <?php echo $nb->title ?></a>
                                        </li>
                                    <?php } else if ($nb->type == '2') { ?>
                                        <li>

                                            <a href="<?php echo $nb->link ?>" target="_blank" style="color:<?php echo $style->color_text ?>;">
                                                <?php echo $nb->title ?></a>
                                        </li>
                                    <?php } else { ?>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle"
                                               data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color:<?php echo $style->color_text ?>;">
                                                <?php echo $nb->title ?> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu">

                                                <!--
                                                    ########## Subnavbar ###########
                                                -->

                                                <?php
                                                $subnav = $barmodel->get_sub_navbarmenu($nb->id);
                                                foreach ($subnav->result() as $snSub):
                                                    ?>
                                                    <?php if ($snSub->type != '2') { ?>
                                                        <li>
                                                            <a href="<?php echo site_url('site/page/' . $this->takmoph_libraries->encode($snSub->id)) ?>">
                                                                <i class="fa fa-angle-right"></i>
                                                                <?php echo $snSub->title ?>
                                                            </a>
                                                        </li>
                                                    <?php } else { ?>
                                                        <li>
                                                            <a href="<?php echo $snSub->link ?>" target="_bank">
                                                                <i class="fa fa-angle-right"></i>
                                                                <?php echo $snSub->title ?>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                <?php endforeach; ?>
                                <li>
                                    <a href="<?php echo site_url('site/sitemap') ?>" style="margin-right:10px;color:<?php echo $style->color_text ?>;">ผังเว็บไซต์</a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('takmoph_admin') ?>" style="margin-right:10px;color:<?php echo $style->color_text ?>;">เข้าสู่ระบบ</a>
                                </li>
                                <!-- EndMenuNavbar -->
                            </ul><!--- /.nav navbar-nav pull-right-->
                        </div>
                        <!-- /.navbar-collapse -->
                    </div>
                </nav>
            </div>
        </div>

        <div class="container" id="main-content" style="box-shadow:none; background:none; margin-top: 10px; padding-top: 0px; padding: 0px;">
            <!-- Navigation -->
            <!--
            #####################
            ## Menu Left 
            #####################
            -->
            <div class="row" style=" margin: 0px; padding: 0px;">
                <!--
                #####################
                ## Content right 
                #####################
                -->
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="side-right" style="word-wrap: break-word;">
                    <!-- Half Page Image Background Carousel Header carousel-fade -->
                    <header id="myCarousel" class="carousel slide" style=" display: none; margin-bottom: 20px;  box-shadow: #666666 0px 0px 3px 0px; margin-top: 2px;">
                        <!-- Wrapper for Slides -->
                        <div class="carousel-inner" style="height: 270px;">
                            <?php
                            $banner = new banner_model();
                            $banners = $banner->get_banner();

                            $n = 0;
                            foreach ($banners->result() as $bn):
                                $n++;
                                if ($n == '1') {
                                    $class = "item active";
                                } else {
                                    $class = "item";
                                }
                                ?>
                                <div class="<?php echo $class; ?>">
                                    <!-- Set the first background image using inline CSS below. -->
                                    <div class="fill" style="background-image:url('<?php echo base_url() ?>images/images_slide/<?php echo $bn->banner ?>');"> </div>
                                    <div class="carousel-caption" style=" background:none; width: 100%; position: absolute; left: 0px; bottom: 0px;">
                                        <p></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                        <!-- Controls -->
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                            <span class="icon-prev"></span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                            <span class="icon-next"></span>
                        </a>
                    </header>

                    <!--
                    ##################
                    ## Slide Hot News 
                    ##################
                    -->
                    <div class="alert" id="box-express" style=" border: none; display: none; margin-bottom: 10px; border-radius: 5px;">
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="color: #cc0000;">ประกาศด่วน</div>
                            <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10">
                                <div class="containMarquee">
                                    <span class="obj_marquee">
                                        <?php
                                        $express_model = new newexpress_model();
                                        $newsexpress = $express_model->get_express();
                                        foreach ($newsexpress->result() as $ns):
                                            ?>
                                            <?php echo $this->tak->thaidate($ns->create_date); ?>
                                            <a href="<?php echo site_url('newexpress/view/' . $this->takmoph_libraries->encode($ns->id)) ?>">
                                                <?php echo $ns->title; ?></a>
                                            <?php
                                        endforeach;
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div style=" background: #FFFFFF; padding: 5px; border-radius: 5px;word-wrap: break-word;">
                        <!-- 
                        ####################
                        ## ข่าวล่าสุด
                        ####################
                        -->
                        <!-- Slide News -->
                        <div id="menu_and_news" style="display: none; margin-top: 0px; padding-top: 0px;">
                            <?php if ($style->showlastnews == "1") { ?>
                                <div class="btn" style=" padding:2px 5px; background: #009900; color: #ffff00;"><i class="fa fa-newspaper-o"></i> ล่าสุด</div>
                                <hr id="hr" style=" border: #009900 solid 1px;"/>
                                <div class="row">
                                    <?php
                                    $i = 0;
                                    $homenews = $newsModel->get_news_limit();
                                    foreach ($homenews->result() as $new):
                                        $i++;
                                        ?>
                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                            <div class="container-card" style=" max-height: 200px;background: #FFFFFF; border: #ecf0f1 solid 1px;">
                                                <div id="div-bg-boxnew"></div>
                                                <div class="img-wrapper">
                                                    <?php if (!empty($new->images)) { ?>
                                                        <img src="<?php echo base_url() ?>upload_images/news/<?php echo $new->images; ?>" class="img-responsive img-polaroid" style="height:100px;"/>
                                                    <?php } else { ?>
                                                        <center>
                                                            <img src="<?php echo base_url() ?>images/News-Mic-iPhone-icon.jpg" class="img-responsive img_news" style="height:100px;"/>
                                                        </center>
                                                    <?php } ?>
                                                </div>
                                                <p class="detail">
                                                    <?php
                                                    echo $new->titel;
                                                    ?><br/>
                                                </p>
                                                <button type="button" class="btn btn-default disabled btn-xs" id="btn-card" style="background: <?php echo $new->background; ?>;color:<?php echo $new->headcolor; ?>;right:80px;"><?php echo $new->groupname ?></button>
                                                <a href="<?php echo site_url('news/view/' . $this->takmoph_libraries->encode($new->id) . '/' . $new->groupnews) ?>">
                                                    <button type="button" class="btn btn-info btn-xs hvr-curl-top-right" id="btn-card">รายละเอียด</button>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <!--
                                <div class="row" style=" clear: both;">
                                    <a href="<?//php echo site_url('news') ?>" class=" pull-right" style=" margin-right: 20px;">
                                        <button type="button" class="btn btn-default btn-sm" style=" margin-right: 0px;">ข่าวทั้งหมด <i class="fa fa-arrow-circle-o-right"></i></button>
                                    </a>
                                </div>
                                -->
                                <div class="bottom-line"></div>
                            <?php } ?>

                            <?php
                            $groupN = $groupnewsModel->groupnews_frontent_active();
                            foreach ($groupN->result() as $Gn):
                                $homenewss = $newsModel->get_news_limit_group($Gn->id, 4);
                                $rows = $homenewss->num_rows();
                                if ($Gn->headcolor != '') {
                                    $headcolor = $Gn->headcolor;
                                } else {
                                    $headcolor = "#eeeeee";
                                }
                                if ($Gn->background != '' || $Gn->background != '#FFFFFF') {
                                    $padding = "5px;";
                                } else {
                                    $padding = "none;";
                                }
                                if ($rows > 0):
                                    ?>
                                    <div style="background:none; padding:<?php echo $padding; ?>;">
                                        <div class="btn" style=" padding:2px 5px; padding:2px 5px; background:<?php echo $headcolor ?>; color:<?php echo $Gn->background ?>"><i class="fa fa-newspaper-o"></i> <?php echo $Gn->groupname ?></div>
                                        <hr id="hr" style="border-color:<?php echo $headcolor ?>"/>
                                        <div class="row">
                                            <?php
                                            $i = 0;
                                            foreach ($homenewss->result() as $news):
                                                $fnew = $newsModel->get_first_images_news($news->id);
                                                $i++;
                                                ?>
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-<?php echo $Gn->column ?>">

                                                    <?php
                                                    if ($Gn->column == '12') {
                                                        echo $lib->setcolumn($Gn->column, $news->images, $news->titel, $news->date, $news->id, $news->groupnews);
                                                    } else {
                                                        ?>
                                                        <div class="container-card" style="max-height: 190px;background: #FFFFFF; border: #ecf0f1 solid 1px;">
                                                            <div id="div-bg-boxnew"></div>
                                                            <div class="img-wrapper">
                                                                <?php if (!empty($fnew)) { ?>
                                                                    <img src="<?php echo base_url() ?>upload_images/news/<?php echo $fnew; ?>" class="img-responsive img-polaroid" style="height:100px;"/>
                                                                <?php } else { ?>
                                                                    <center>
                                                                        <img src="<?php echo base_url() ?>images/News-Mic-iPhone-icon.jpg" class="img-responsive img_news" style="height:100px;"/>
                                                                    </center>
                                                                <?php } ?>
                                                            </div>
                                                            <p class="detail">

                                                                <?php
                                                                //$this->session->userdata('width');
                                                                /*
                                                                  $text = strlen($news->titel);
                                                                  if ($text > 160) {
                                                                  //echo iconv_substr($news->titel,'0','100')."...";
                                                                  if ($this->session->userdata('width') > 1000 || $this->session->userdata('width') <= 768) {
                                                                  print mb_substr($news->titel, 0, 30, 'UTF-8') . "...";
                                                                  } else {
                                                                  echo $news->titel;
                                                                  }
                                                                  } else {
                                                                  echo $news->titel;
                                                                  }
                                                                 */
                                                                echo $news->titel;
                                                                ?><br/>

                                                            </p>
                                                            <a href="<?php echo site_url('news/view/' . $this->takmoph_libraries->encode($news->id) . '/' . $news->groupnews) ?>">
                                                                <button type="button" class="btn btn-info btn-xs hvr-curl-top-right" id="btn-card"> รายละเอียด</button>
                                                            </a>

                                                        </div>
                                                    <?php } ?>
                                                </div><!-- End Col -->

                                            <?php endforeach; ?>
                                        </div>
                                        <div class="row" style=" clear: both;">
                                            <a href="<?php echo site_url('news/newsall/' . $this->takmoph_libraries->encode($Gn->id)) ?>" class=" pull-right" style=" margin-right: 20px;">
                                                <button type="button" class="btn btn-default btn-sm hvr-curl-top-right" style=" margin-right: 0px;">ดูทั้งหมด <i class="fa fa-arrow-circle-o-right"></i></button>
                                            </a>
                                        </div>
                                        <div class="bottom-line"></div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </div>
                        <!-- EndSlide News -->


                        <!-- 
                         ################
                         ## Content Page
                         ################
                        
                        -->
                        <div id="tooplate_content">

                            <?php
                            if ($detail == "") {
                                $this->load->view($page . ".php");
                            } else {
                                $this->load->view($page . ".php", $detail);
                            }
                            ?>
                        </div> 
                    </div>
                    <!--
                    ####################
                    ## end of content 
                    ####################
                    -->

                </div>

                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" id="side-left">
                    <!--
                    ################ 
                    ## Menu And News 
                    ################
                    -->
                    <?php if ($manager->active == '1') { ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <center>
                                    <img src="<?php echo base_url() ?>upload_images/manager/<?php echo $manager->images ?>" width="150" class="img-responsive img-thumbnail"/>
                                    <div class="well well-sm">
                                        <p id="menager">
                                            <?php echo $manager->name ?></p>
                                        <p id="menager-position">
                                            <?php echo $manager->position ?>

                                        </p>
                                    </div>
                                </center>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-th-large"></i> <font style=" font-size: 22px;">เมนู</font>
                        </div>

                        <!--
                            #
                            #
                            # Link Menu
                            #
                            #
                        -->

                        <?php
                        $menu = $this->tak->get_mas_menu();
                        foreach ($menu->result() as $rs):
                            $menu_model = new menu_model();
                            //$color = $menu_model->get_color($rs->menu_color);
                            ?>

                            <?php
                            if ($rs->mas_status == '0') {
                                ?>
                                <a href="<?= site_url($rs->link . '/' . $this->takmoph_libraries->encode($rs->admin_menu_id) . '/' . $rs->mas_menu) ?>" style="text-decoration: none;">
                                    <div id="submenu" class="btn btn-block hvr-curl-top-right" style="color:<?php echo $style->color_head ?>; border-radius:0px;">
                                        <div class="text-menu">
                                            <img src="<?= base_url() ?>icon_menu/<?= $rs->menu_icon ?>" style="height:32px;"/>
                                            <?= $rs->mas_menu ?>
                                        </div>
                                    </div>
                                </a>

                                <!-- ลิงค์ ข้างนอก -->
                            <?php } else if ($rs->mas_status == '2') {
                                ?>

                                <a href="<?php echo $rs->link_out; ?>" target="_blank" style=" text-decoration: none;">
                                    <div id="submenu" class="btn btn-block hvr-curl-top-right" style="color:<?php echo $style->color_head ?>; border-radius:0px;">
                                        <div class="text-menu"> 
                                            <img src="<?= base_url() ?>icon_menu/<?= $rs->menu_icon ?>" style="height:32px;"/>
                                            <?= $rs->mas_menu ?>
                                        </div>
                                    </div></a>

                                <!-- Droupdown -->
                                <?php
                            } else {
                                ?>

                                <a href="<?php echo site_url('menu/submenu/' . $this->takmoph_libraries->encode($rs->id)); ?>" style=" text-decoration: none;">
                                    <div id="submenu" class="btn btn-block hvr-curl-top-right" style="color:<?php echo $style->color_head ?>; border-radius:0px;">                              
                                        <div class="text-menu"> 
                                            <img src="<?= base_url() ?>icon_menu/<?= $rs->menu_icon ?>" style="height:32px;"/> <?= $rs->mas_menu ?>
                                        </div>
                                    </div></a>
                            <?php } ?>
                        <?php endforeach; ?>

                        <!-- 
                        #######################################
                        ## Menu Down Load
                        ########################################
                        -->
                        <a href="<?php echo site_url('formdownload'); ?>" style="text-decoration:">
                            <div id="submenu" class="btn btn-block hvr-curl-top-right" style="color:<?php echo $style->color_head ?>; border-radius:0px;">
                                <div class="text-menu"> 
                                    <img src="<?= base_url() ?>icon_menu/folder-icon.png" style="height:32px;"/>
                                    แบบฟอร์มต่าง ๆ 
                                </div>
                            </div></a>
                        <!-- 
                        #######################################
                        ## END MENU GROUP
                        ########################################
                        -->
                    </div>

                    <hr/>
                    <div class="row">
                        <?php
                        $modules = $module->Get_moduleActive();
                        foreach ($modules->result() as $md) {
                            ?>
                            <div class="col-sm-6 col-md-12 col-lg-12">
                                <a href="<?php echo site_url($md->module) ?>" style=" text-decoration: none; font-size: 18px; font-weight: bold;">
                                    <div class="panel" style=" border-radius: 5px;">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-5">
                                                <div style=" text-align: center;">
                                                    <center><img src="<?php echo base_url() ?>assets/module/<?php echo $md->module ?>/images/icon.png" class=" img-responsive" style=" height: 72px;"/></center>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-7" style=" text-align: left; padding-top: 10px; padding-left: 0px;">
                                                <?php echo $md->thainame ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="panel" style=" border-radius: 5px;">
                                <table style=" width: 100%;" class="table">
                                    <tbody>
                                        <tr>
                                            <td>ผู้เยี่ยมชมทั้งหมด</td>
                                            <td><span class="badge"><?php echo number_format($this->counter_model->counter()); ?></span></td>
                                            <td>ครั้ง</td>
                                        </tr>
                                        <tr>
                                            <td>ผู้เยี่ยมชมวันนนี้</td>
                                            <td><span class="badge"><?php echo number_format($this->counter_model->getcounterDay()); ?></span></td>
                                            <td>ครั้ง</td>
                                        </tr>
                                        <tr>
                                            <td>ผู้เยี่ยมชมเดือนนี้</td>
                                            <td><span class="badge"><?php echo number_format($this->counter_model->getcounterMonth()); ?></span></td>
                                            <td>ครั้ง</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Row -->
        </div> <!-- End Container -->

        <!--
 ####################
 ## Album
 ####################
        -->
        <?php
        $photo = $photoModel->album_limit(10);
        if ($photo->num_rows() > 0) {
            ?>
            <div id="main-album" style=" display: none;">
                <div class="alert" style="width:100%; border-radius:0px; margin-bottom:0px; border: none; box-shadow: none; background:none;">
                    <div class="container">
                        <div  style=" padding-left:0px;">
                            <div style=" padding:2px 5px; background: #009900; color: #ffff00;" class="btn"><i class="fa fa-file-image-o"></i> รูปภาพ / กิจกรรม</div>
                            <hr id="hr" style=" border: #009900 solid 1px;"/>
                            <div class="slider5" style="margin-bottom:0px; padding-bottom:0px;">
                                <?php
                                foreach ($photo->result() as $albums):
                                    $firstAlbum = $photoModel->get_first_album($albums->id);
                                    ?>

                                    <a href="<?php echo site_url('photo/gallery/' . $albums->id) ?>" class="hover14">
                                        <div class="slide">
                                            <div class="container-card" style="height:160px; text-align: center; box-shadow:none; margin-bottom:0px;">
                                                <figure>
                                                    <div class="img-wrapper">
                                                        <img src="<?php echo base_url() ?>upload_images/photo/<?php echo $firstAlbum ?>" class="img-responsive" style="height:160px;"/>
                                                        <div id="album-title">
                                                            <?php echo $albums->title ?>
                                                        </div>
                                                    </div>
                                                </figure>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <center><br/>
                                <a href="<?php echo site_url('photo/page') ?>">
                                    <button type="button" class="btn btn-info btn-sm">ดูทั้งหมด ...</button></a>
                            </center>
                        </div>
                    </div>
                </div>

            </div>
        <?php } ?>
        <!--
       ####################
       ## Menu System
       ####################
        -->
        <?php
        $menu_system = $this->tak->get_menu_system();
        if ($menu_system->num_rows() > 0) {
            ?>
            <div id="main-menu-system" style=" display: none;">
                <div class="well" id="box-menu-system"
                     style="border-radius:0px; border: none; background: none;">
                    <div class="container">
                        <div class="bottom-line"></div>

                        <div style="margin-top: 0px;">
                            <div  style=" margin-bottom: 30px;">
                                <div style=" padding:2px 5px; background: #009900; color: #ffff00;" class="btn"><i class="fa fa-th"></i> ระบบงาน</div>
                                <hr id="hr" style="border: #009900 solid 1px;"/>
                                <div class="row">

                                    <!-- Menu Program -->
                                    <?php
                                    foreach ($menu_system->result() as $mm):
                                        ?>
                                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                                            <a href="<?= $mm->link ?>" target="_blank" style=" text-decoration: none; ">
                                                <div class="hvr-grow" style=" width: 100%;">
                                                    <div class="container-card" style="max-height: 150px; text-align: center;border: none;" id="menu-hover">
                                                        <div class="img-wrapper" >
                                                            <img src="<?php echo base_url() ?>icon_menu/<?php echo $mm->system_images ?>" class="img-responsive" style="height:100px;"/>
                                                        </div>
                                                        <p class="detail" style=" margin: 0px; padding: 2px; font-weight: bold; padding-top: 10px;">
                                                            <?php echo $mm->system_title ?><br/>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!--
########################
## Footer 
########################
        -->
        <!--
        <nav class="navbar navbar-inverse" role="navigation" id="footer" style=" border-top: <?php echo $style->color_head ?> solid 5px;">
            <div class=" container"></div>
        </nav>
        -->

        <div id="footerfull">
            <div class=" container" style=" margin-top: 50px; padding-top: 10px; background: none;" id="bgclassblack">
                <div style="color: #009900;">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12"><?php echo $style->footer ?></div>
                    </div>
                </div>
            </div>
        </div>



        <nav class="navbar navbar-inverse" role="navigation" id="footer-credit" style=" border: none;">
            <div class="container" style=" padding: 20px 10px;">
                <div class="row" style=" margin: 0px;">
                    <?php
                    foreach ($navbar->result() as $nb):
                        ?>
                        <?php if ($nb->type == '0') { ?>
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <a href="<?php echo site_url('site/page/' . $this->takmoph_libraries->encode($nb->id)) ?>"
                                   style="color:#cccccc;">
                                    <b><?php echo $nb->title ?></b></a>
                            </div>
                        <?php } else { ?>
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <span class="caret"></span> <b><font style="color: #cccccc;"><?php echo $nb->title ?></font></b>
                                <br/>
                                <!--
                                    ########## Subnavbar ###########
                                -->
                                <div style="padding-left:10px;">
                                    <?php
                                    $subnav = $barmodel->get_sub_navbarmenu($nb->id);
                                    foreach ($subnav->result() as $snSub):
                                        ?>
                                        <a href="<?php echo site_url('site/page/' . $this->takmoph_libraries->encode($snSub->id)) ?>"
                                           style="color: #999999;">- <?php echo $snSub->title ?></a> <br/>
                                       <?php endforeach; ?>
                                </div>
                            </div>

                        <?php } ?>
                    <?php endforeach; ?>
                    <!-- EndMenuNavbar -->
                </div>
            </div>
        </nav>

        <nav class="navbar navbar-inverse" role="navigation" id="footer-credit" style=" border: none; background: #000000;">
            <div style="padding-top:20px;">
                <div style="font-size:10px; color: #009900; text-align:center;">
                    &copy; Create By The Assembler Themes | Kimniyom | Mini CMS
                    <a href="https://www.theassemblers.net" target="_blank">www.theassemblers.net</a>
                </div>
            </div>
        </nav>
        <!--
        #####################
        ## EndFooter 
        #####################
        -->

        <a href="#" id="back-to-top" title="Back to top">&uarr; TOP</a>
        <!-- Script to Activate the Carousel -->
        <script>
            $('.carousel').carousel({
                interval: 5000 //changes the speed
            });

            $(document).ready(function () {

                var width = $(window).width();
                if (width < 1024) {
                    $("#bannerhead-king").hide();
                }
                if (width < 768) {
                    $("#myCarousel").hide();//Set Banner Show
                    $(".img_news").css("width", "100px");
                    $(".font_news").css("font-size", "12px");
                    $("#footerfull").css("background", "none");
                    /*$("#bg-main-ban-head").hide();*/

                    $("#bannerhead-logo").removeClass("col-md-5 col-lg-5");
                    $("#bannerhead-logo").addClass("col-md-12 col-lg-12");
                    $("#bannerhead-logo img").addClass("img-responsive");
                    $("#bannerhead-trip").hide();


                }





                /*
                 $('.slider5').bxSlider({
                 auto: true,
                 minSlides: 1,
                 pause: 4000,
                 moveSlides: 1,
                 maxSlides: 4,
                 slideWidth: 260,
                 slideMargin: 13,
                 touchEnabled: true,
                 pager: false,
                 controls: false,
                 captions: true,
                 autoHover: true
                 });
                 */

                var size = $(window).width();
                if (size >= 768) {
                    $('.slider5').bxSlider({
                        slideWidth: 300,
                        minSlides: 4,
                        maxSlides: 4,
                        moveSlides: 4,
                        slideMargin: 10,
                        captions: true,
                        auto: true,
                        touchEnabled: true,
                        pager: false
                    });
                } else {
                    $('.slider5').bxSlider({
                        slideWidth: 300,
                        minSlides: 3,
                        maxSlides: 3,
                        moveSlides: 3,
                        slideMargin: 10,
                        captions: true,
                        auto: true,
                        touchEnabled: true,
                        pager: false
                    });
                }
            });

            $("document").ready(function ($) {
                var nav = $('#nav');
                //nav.removeClass("nav navbar-fixed-top");
                $(window).scroll(function () {

                    if ($(this).scrollTop() > 200) {
                        //$("#boxlogohospital").hide();
                        nav.addClass("navbar-fixed-top");
                        nav.css({'box-shadow': '#000000 0px 0px 10px 0px'});
                        //nav.fadeIn();
                    } else {
                        //$("#boxlogohospital").show();
                        nav.removeClass("navbar-fixed-top");
                        nav.css({'box-shadow': 'none'});
                    }
                });

                $(".breadcrumb li a").css({'font-size': '16px'});
                $(".breadcrumb .active").css({'font-size': '16px'});

            });

            if ($('#back-to-top').length) {
                var scrollTrigger = 100, // px
                        backToTop = function () {
                            var scrollTop = $(window).scrollTop();
                            if (scrollTop > scrollTrigger) {
                                $('#back-to-top').addClass('show');
                                $("#bg-cloud").hide();
                            } else {
                                $('#back-to-top').removeClass('show');
                                $("#bg-cloud").show();
                            }
                        };
                backToTop();
                $(window).on('scroll', function () {
                    backToTop();
                });
                $('#back-to-top').on('click', function (e) {
                    e.preventDefault();
                    $('html,body').animate({
                        scrollTop: 0
                    }, 700);
                });
            }
        </script>

        <script type="text/javascript">
            (function ($) {
                $(window).on("load", function () {
                    $(".list-group").mCustomScrollbar({
                        theme: "minimal-dark",
                        axis: "y" // horizontal scrollbar
                    });
                });
            })(jQuery);
        </script>
        <!-- Jquery Library -->
        <script src="<?php echo base_url() ?>js/library/configweb.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?><?php echo $path ?>/js/system.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>js/library/MD5.js" type="text/javascript"></script>
    </body>
</html>
