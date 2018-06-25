<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <?php
        //Use Model,libraries
        $this->load->library('takmoph_libraries');
        $this->load->driver('cache');
        /*
          $this->load->model('newexpress_model');
          $this->load->model('banner_model');
          $this->load->model('menubar_model');
          $this->load->model("menu_model");
          $this->load->model('homepage_model');
          $this->load->model('sub_homepage_model');
          $this->load->model('news_model');
          $this->load->model('photo_model');
         */
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
        ?>



        <link rel="shortcut icon" href="<?php echo base_url() ?>upload_images/logo/<?php echo $style->logo ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="content-language" content="th" />
        <title><?php echo $style->webname_short ?> | <?php echo $style->webname_full ?></title>
        <meta name="description" content="<?php echo $style->webname_short ?>,<?php echo $style->webname_full ?>" />
        <meta name="keywords" content="<?php echo $style->webname_short ?>,<?php echo $style->webname_full ?>" />
        <meta name="robots" content="index, follow" />
        <meta name="author" content="">

        <style type="text/css">
            #manager{ position: absolute; bottom:5px; left:10px;z-index: 10; width: 200px; text-align: center;}
            html{<?php echo $this->background_model->background_active() ?>}
            #nav-bar ul li a:active{ background: <?php echo $style->color_head ?>;}
            #nav-bar ul li a:after{ background: <?php echo $style->color_head ?>;}
            #nav-bar ul li a:hover{ background: <?php echo $style->color_head ?>;}
            #nav-bar ul li a:focus{ background: <?php echo $style->color_head ?>;}

            #body tbody tr td {
                max-width: 120px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
        </style>
        <!-- New Themes -->
        <link href="<?php echo base_url() ?><?php echo $path ?>/css/system.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url() ?>js/jquery-1.11.3.min.js" type="text/javascript"></script>

        <!-- Bootstrap 3-->
        <link href="<?php echo base_url() ?><?php echo $path ?>/css/bootstrap-flatly.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url() ?><?php echo $path ?>/js/bootstrap.js" type="text/javascript"></script>
        <link href="<?php echo base_url() ?><?php echo $path ?>/css/half-slider.css" rel="stylesheet" type="text/css" />

        <!-- Icon aware-some -->
        <link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />

        <!-- Jquery Library -->
        <script src="<?php echo base_url() ?>js/library/configweb.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?><?php echo $path ?>/js/system.js" type="text/javascript"></script>
        
        <!-- FullCarlendar-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/fullcalendar/fullcalendar.min.css">
        <script type="text/javascript" src="<?php echo base_url() ?>assets/fullcalendar/lib/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/fullcalendar/fullcalendar.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/fullcalendar/locale/th.js"></script> 
        <!-- Datetime Picker --> 
        <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" type="text/css" media="all" />
        <script src="<?= base_url() ?>assets/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>


        <!-- Datatable -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/DataTables-1.10.10/media/css/dataTables.bootstrap.css" type="text/css" media="all" />
        <script src="<?= base_url() ?>assets/DataTables-1.10.10/media/js/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/DataTables-1.10.10/media/js/dataTables.bootstrap.js" type="text/javascript"></script>

        <!-- Assets -->
        <link href="<?php echo base_url() ?>assets/card-css/card-css.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>css/hover.css" rel="stylesheet" type="text/css" />

        <!-- Jquery.Bxslide-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/jquery.bxslider/jquery.bxslider.css" media="screen">
        <script src="<?php echo base_url() ?>assets/jquery.bxslider/jquery.bxslider.js"></script>

        <!-- fancybox -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/fancyBox2.1.5/source/jquery.fancybox.css" media="screen">
        <script src="<?php echo base_url() ?>assets/fancyBox2.1.5/source/jquery.fancybox.js"></script>

        <!-- images hover effect -->
        <link href="<?php echo base_url() ?><?php echo $path ?>/css/images-hover-effect.css" rel="stylesheet" type="text/css" />

       

    </head>

    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="nav-bar"
             style=" background: <?php echo $style->color_navbar; ?>">
            <div class="alert alert-success" id="tab-sing-in"
                 style="background: <?php echo $style->color_head; ?>;">
                <div class="container" style="color: <?php echo $style->color_text ?>">
                    <?php echo $style->webname_full ?>
                    <a href="<?php echo site_url('users/login') ?>" class="pull-right"
                       style="color: <?php echo $style->color_text ?>;"><i class="fa fa-sign-in"></i> Sign In</a>
                </div>
            </div>

            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
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
                    <a class="navbar-brand" href="#" style=" margin-top: 0px; padding-top: 5px;">
                        <img src="<?php echo base_url() ?>upload_images/logo/<?php echo $style->logo ?>" style=" height: 52px;"/>
                        <!--
                        <img src="<?//php echo base_url() ?>images/logomoph.png" style=" height: 52px;"/>
                        -->
                    </a>
                    <a class="navbar-brand" href="#" style=" margin-top: 0px; color: <?php echo $style->color_text ?>;"><?php echo $style->webname_short ?></a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="border:none;">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="<?php echo site_url() ?>" style="color: <?php echo $style->color_text ?>;"><i class="fa fa-home"></i> หน้าแรก</a>
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
                            <a href="<?php echo site_url('site/sitemap') ?>" style="color:<?php echo $style->color_text ?>;">ผังเว็บไซต์</a>
                        </li>
                        <!-- EndMenuNavbar -->
                    </ul><!--- /.nav navbar-nav pull-right-->
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <nav class="navbar navbar-default" role="navigation" style=" margin: 0px;">
            <div class="alert alert-info" style="margin: 19px;">
                <div class="container">NAVBAR</div>
            </div>
        </nav>

        <!-- Half Page Image Background Carousel Header -->
        <header id="myCarousel" class="carousel slide" style=" display: none;">
            <!-- Wrapper for Slides -->
            <div class="carousel-inner">
                <?php if ($manager->active == '1') { ?>
                    <div id="manager">
                        <img src="<?php echo base_url() ?>upload_images/manager/<?php echo $manager->images ?>" width="150" class="img-responsive img-thumbnail"/>
                        <div class="well well-sm">
                            <?php echo $manager->name ?></br>
                            <?php echo $manager->position ?>
                        </div>
                    </div>
                <?php } ?>
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
                        <div class="fill" style="background-image:url('<?php echo base_url() ?>images/images_slide/<?php echo $bn->banner ?>');"></div>
                        <div class="carousel-caption">
                            <h2></h2>
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
            #### Slide Hot News ####
        -->
        <?php
        $express_model = new newexpress_model();
        $newsexpress = $express_model->get_express();
        if ($newsexpress->num_rows() > 0) {
            ?>
            <div class="alert" id="box-express">
                <div class="container">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <!-- Wrapper for slides -->

                        <div class="carousel-inner" role="listbox">
                            <?php
                            $i = 0;
                            foreach ($newsexpress->result() as $ns):
                                $i++;
                                if ($i == 1) {
                                    $class = "item active";
                                } else {
                                    $class = "item";
                                }
                                ?>
                                <div class="<?php echo $class; ?>">
                                    <div class="text-express" style="color: #ff0033;">
                                        <font style="color: #ff0033;"><i class="fa fa-fire"></i> ประกาศด่วน</font>
                                        <?php echo $this->tak->thaidate($ns->create_date); ?>
                                        <a href="<?php echo site_url('newexpress/view/' . $this->takmoph_libraries->encode($ns->id)) ?>">
                                            <button type="button" class="btn btn-warning btn-xs">อ่าน ... <i class="fa fa-angle-double-right"></i></button></a>
                                        <br/>
                                        <?php echo $ns->title; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev" style=" background: none;">
                            <span class="fa fa-angle-left btn pull-left" aria-hidden="true" id="btn-PN"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next" style=" background: none;">
                            <span class="fa fa-angle-right btn pull-right" aria-hidden="true" id="btn-PN"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!--
        ################ 
        ## Menu And News 
        ################
        -->
        <div id="menu_and_news" style=" display: none; margin-bottom: 0px;">

            <div class="well" id="bg_gray">
                <div class="bottom-line"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style=" margin: 0px;">
                            <h3><i class="fa fa-th-large"></i> เมนู</h3>
                            <hr id="hr"/>
                            <!--
                                #
                                #
                                # Link Menu
                                #
                                #
                            -->

                            <?php
                            $menu = $this->tak->get_mas_menu();
                            $ii = 0;
                            foreach ($menu->result() as $rs):
                                $ii++;
                                $menu_model = new menu_model();
                                //$color = $menu_model->get_color($rs->menu_color);
                                ?>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding:0px 5px 5px 0px;">
                                    <?php
                                    if ($rs->mas_status == '0') {
                                        ?>
                                        <a href="<?= site_url($rs->link . '/' . $this->takmoph_libraries->encode($rs->admin_menu_id) . '/' . $rs->mas_menu) ?>" style="text-decoration: none;" data-toggle="tooltip" data-placement="top" title="<?php echo $rs->mas_menu ?>">

                                            <div id="submenu" class="btn btn-block hvr-trim" style="background:<?php echo $rs->bgcolor ?>;color:<?php echo $rs->textcolor ?>; border-radius:0px;">
                                                <div id="submenu_img"><img src="<?= base_url() ?>icon_menu/<?= $rs->menu_icon ?>" style="height:32px;"/></div>
                                                <center>
                                                    <div class="text-menu"><?= $rs->mas_menu ?></div>
                                                </center>
                                            </div>
                                        </a>

                                        <!-- ลิงค์ ข้างนอก -->
                                    <?php } else if ($rs->mas_status == '2') {
                                        ?>

                                        <a href="<?php echo $rs->link_out; ?>" target="_blank" style=" text-decoration: none;" data-toggle="tooltip" data-placement="top" title="<?php echo $rs->mas_menu ?>">
                                            <div id="submenu" class="btn btn-block hvr-trim" style="background:<?php echo $rs->bgcolor ?>;color:<?php echo $rs->textcolor ?>; border-radius:0px;">
                                                <div id="submenu_img"><img src="<?= base_url() ?>icon_menu/<?= $rs->menu_icon ?>" style="height:32px;"/></div>
                                                <center>
                                                    <div class="text-menu"> <?= $rs->mas_menu ?></div>
                                                </center>
                                            </div></a>

                                        <!-- Droupdown -->
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?php echo site_url('menu/submenu/' . $this->takmoph_libraries->encode($rs->id)); ?>" style=" text-decoration: none;" data-toggle="tooltip" data-placement="top" title="<?php echo $rs->mas_menu ?>">
                                            <div id="submenu" class="btn btn-block hvr-trim" style="background:<?php echo $rs->bgcolor ?>;color:<?php echo $rs->textcolor ?>; border-radius:0px;">
                                                <div id="submenu_img"><img src="<?= base_url() ?>icon_menu/<?= $rs->menu_icon ?>" style="height:32px;"/></div>
                                                <center>
                                                    <div class="text-menu"> <?= $rs->mas_menu ?></div>
                                                </center>
                                            </div></a>
                                    <?php } ?>

                                </div>

                            <?php endforeach; ?>


                            <!-- #######################################
                                                                Menu Down Load
                            ########################################-->

                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding:0px 5px 5px 0px;">
                                <a href="<?php echo site_url('formdownload'); ?>" style="text-decoration:">
                                    <div id="submenu" class="btn btn-info btn-block hvr-trim" style="border-radius:0px;">
                                        <div id="submenu_img"><img src="<?= base_url() ?>icon_menu/folder-icon.png" style="height:32px;"/></div>
                                        <center>
                                            <div class="text-menu"> แบบฟอร์มต่าง ๆ </div>
                                        </center>
                                    </div></a>
                            </div>

                            <?php
                            $modules = $this->modulemanager_model->Get_moduleActive();
                            foreach ($modules->result() as $md) {
                                ?>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding:0px 5px 5px 0px;">
                                    <a href="<?php echo site_url($md->module) ?>" style=" text-decoration: none;" data-toggle="tooltip" data-placement="top" title="<?php echo $md->thainame ?>">
                                        <div id="submenu" class="btn btn-default btn-block hvr-trim" style="border-radius:0px;">
                                            <div id="submenu_img"><img src="<?php echo base_url() ?>assets/module/<?php echo $md->module ?>/images/icon.png" style="height:32px;"/></div>
                                            <center>
                                                <?php echo $md->thainame ?>
                                            </center>
                                        </div></a>
                                </div>
                            <?php } ?>


                        </div>
                        <!-- End Menu Group -->
                        <!-- #######################################
                                                            END MENU GROUP
                            ########################################-->

                        <!-- ######################################
                                                                ข่าวล่าสุด
                        ##########################################-->

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <h3><i class="fa fa-newspaper-o"></i> ข่าวล่าสุด</h3>
                            <hr id="hr"/>
                            <!-- Slide News -->
                            <?php
                            $i = 0;
                            $countMenu = ($ii + 1);
                            if ($countMenu <= 6) {
                                $limit = "4";
                            } else {
                                $limit = "6";
                            }
                            $homenews = $newsModel->get_news_limit($limit);
                            foreach ($homenews->result() as $new):
                                $i++;
                                ?>
                                <div class="font_news">
                                    <a href="<?php echo site_url('news/view/' . $this->takmoph_libraries->encode($new->id) . '/' . $new->groupnews) ?>">
                                        <div class="media hvr-bounce-to-right" id="box-lastnews" style=" width: 100%; margin-bottom: 10px;">
                                            <span  class="pull-left">
                                                <?php if ($new->images != '') { ?>
                                                    <img src="<?php echo base_url() ?>upload_images/news/<?php echo $new->images; ?>" class="img-responsive img_news" style="max-width: 120px;"/>
                                                <?php } else { ?>
                                                    <img src="<?php echo base_url() ?>images/News-Mic-iPhone-icon.jpg" class="img-responsive img_news" style="max-width: 90px;"/>
                                                <?php } ?>
                                            </span>
                                            <div clas="media-body" style=" padding: 10px;">
                                                <?php echo $new->titel; ?>
                                                <br/>
                                                <font class="pull-right" style=" font-size: 12px;">
                                                <em style=" color: #999999;"><?php echo $new->groupname ?></em>&nbsp;
                                                <?php echo $this->takmoph_libraries->thaidate($new->date); ?>
                                                </font>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            <?php endforeach; ?>

                            <!-- EndSlide News -->
                        </div><!-- End Col -->

                    </div><!-- End Row -->

                </div><!-- End container -->
            </div> <!-- End Well -->

        </div>

        <div class="container" id="newsgroup" style=" display: none;">
            <?php
            $groupN = $groupnewsModel->groupnews_frontent_active();
            foreach ($groupN->result() as $Gn):
                $homenewss = $newsModel->get_news_limit_group($Gn->id, 4);
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
                if ($homenewss->num_rows() > 0):
                    ?>
                    <div style="background:<?php echo $Gn->background ?>; padding:<?php echo $padding; ?>;">
                        <h3 style="color:<?php echo $headcolor ?>"><i class="fa fa-newspaper-o"></i> <?php echo $Gn->groupname ?></h3>
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
                                        <div class="container-card" style="max-height: 200px;border-color:<?php echo $headcolor ?>">
                                            <div class="img-wrapper">
                                                <?php if (!empty($fnew)) { ?>
                                                    <img src="<?php echo base_url() ?>upload_images/news/<?php echo $fnew; ?>" class="img-responsive img-polaroid" style="height:100px;"/>
                                                <?php } else { ?>
                                                    <center>
                                                        <img src="<?php echo base_url() ?>images/News-Mic-iPhone-icon.jpg" class="img-responsive img_news" style="height:100px;"/>
                                                    </center>
                                                <?php } ?>
                                            </div>
                                            <p class="detail text-responsive" style=" font-size: 12px;">

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
                                                <button type="button" class="btn btn-danger btn-xs" id="btn-card"> อ่านข่าว ...</button>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div><!-- End Col -->

                            <?php endforeach; ?>
                        </div>
                        <div class="row" style=" clear: both;">
                            <a href="<?php echo site_url('news/newsall/' . $this->takmoph_libraries->encode($Gn->id)) ?>" class=" pull-right" style=" margin-right: 20px;">
                                <button type="button" class="btn btn-default btn-sm" style=" margin-right: 0px;">ข่าวทั้งหมด <i class="fa fa-arrow-circle-o-right"></i></button>
                            </a>
                        </div>
                        <div class="bottom-line"></div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>


        <!-- 
        ################
        # Content Page
        ################
        -->
        <div id="tooplate_content">
            <div class=" container" style=" padding-left: 0px;word-wrap: break-word;">
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

        <!--
        ####################
        ## Album
        ####################
        -->

        <div id="main-album" style=" display: none;">
            <div class="alert" id="bg_gray" style="width:100%; border-radius:0px; margin-bottom:0px;">
                <div class="container" style=" padding-left:25px;">
                    <h3><i class="fa fa-file-image-o"></i> รูปภาพ / กิจกรรม</h3>
                    <hr id="hr"/>
                    <div class="slider5" style="margin-bottom:0px; padding-bottom:0px;">
                        <?php
                        $photo = $photoModel->album_limit(10);
                        foreach ($photo->result() as $albums):
                            $firstAlbum = $photoModel->get_first_album($albums->id);
                            ?>

                            <a href="<?php echo site_url('photo/gallery/' . $albums->id) ?>" class="hover14">
                                <div class="slide">
                                    <div class="container-card" style="height:160px; text-align: center; box-shadow:none; margin-bottom:0px;">
                                        <figure>
                                            <div class="img-wrapper">
                                                <img src="<?php echo base_url() ?>upload_images/photo/<?php echo $firstAlbum ?>" class="img-responsive" style="height:160px;" title="<?php echo $albums->title ?>"/>
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

        <!--
       ####################
       ## Menu System
       ####################
        -->

        <div id="main-menu-system" style=" display: none;">
            <div class="well" id="box-menu-system"
                 style="background:<?php echo $style->color_head ?>; border-radius:0px;">
                <div class="bottom-line"></div>
                <div style="margin-top: 0px;">
                    <div class="container" style=" margin-bottom: 30px;">
                        <h3 style="color:<?php echo $style->color_text ?>; text-shadow:none;"><i class="fa fa-th"></i> ระบบงาน</h3>
                        <hr id="hr" style="border:<?php echo $style->color_text ?> solid 2px;"/>
                        <div class="row">

                            <!-- Menu Program -->
                            <?php
                            $menu_system = $this->tak->get_menu_system();
                            foreach ($menu_system->result() as $mm):
                                ?>
                                <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                                    <a href="<?= $mm->link ?>" target="_blank" style=" text-decoration: none;">
                                        <div class="hvr-grow" style=" width: 100%;">
                                            <div class="container-card" style="max-height: 150px; text-align: center;" id="menu-hover">
                                                <div class="img-wrapper">
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

        <!--########################### Footer ########################-->
        <nav class="navbar navbar-inverse" role="navigation" style=" margin: 0px; background: <?php echo $style->color_navbar; ?>" id="footer">
            <div class="container" style="color:<?php echo $style->color_text ?>;">

                <div class="row">
                    <div class="col-sm-6 col-md-5 col-lg-5"><?php echo $style->footer ?></div>
                    <div class="col-sm-6 col-md-7 col-lg-7">
                        <div class="row">
                            <?php
                            foreach ($navbar->result() as $nb):
                                ?>
                                <?php if ($nb->type == '0') { ?>
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <a href="<?php echo site_url('site/page/' . $this->takmoph_libraries->encode($nb->id)) ?>"
                                           style="color:<?php echo $style->color_text ?>;">
                                            <b><?php echo $nb->title ?></b></a>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <span class="caret"></span> <b><font style="color:<?php echo $style->color_text ?>;"><?php echo $nb->title ?></font></b>
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
                                                   style="color:<?php echo $style->color_text ?>;">- <?php echo $snSub->title ?></a> <br/>
                                               <?php endforeach; ?>
                                        </div>
                                    </div>

                                <?php } ?>
                            <?php endforeach; ?>
                            <!-- EndMenuNavbar -->
                        </div>
                    </div>
                </div>

                <hr style="border-top:solid 1px <?php echo $style->color_head ?>;"/>
                Copyright © 2015 - <?php echo date('Y') ?> AsbWeb By Theassemblerthemes.

                <div id="counter" style=" float: right;">
                    จำนวนผู้เยี่ยมชม <span class="badge"><?php echo $this->counter_model->counter(); ?></span> คน
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-inverse" role="navigation" style=" margin: 0px; background:#333333; border-radius:0px;">
            <div class="container" style="padding-top:20px;">
                <div style="font-size:10px; color:<?php echo $style->color_text ?>; text-align:center;">
                    &copy; Create By The Assembler Themes | Kimniyom | Mini CMS
                    <a href="https://www.theassemblers.net" target="_blank">www.theassemblers.net</a>
                </div>
            </div>
        </nav>
        <!--########################### EndFooter #####################-->
        <a href="#" id="back-to-top" title="Back to top">&uarr; TOP</a>
        <!-- Script to Activate the Carousel -->
        <script>
            $('.carousel').carousel({
                interval: 5000 //changes the speed
            });


            $(document).ready(function () {

                var width = $(window).width();
                if (width < 768) {
                    $(".img_news").css("width", "100px");
                    $(".font_news").css("font-size", "12px");
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

            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

            if ($('#back-to-top').length) {
                var scrollTrigger = 100, // px
                        backToTop = function () {
                            var scrollTop = $(window).scrollTop();
                            if (scrollTop > scrollTrigger) {
                                $('#back-to-top').addClass('show');
                            } else {
                                $('#back-to-top').removeClass('show');
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


    </body>
</html>
