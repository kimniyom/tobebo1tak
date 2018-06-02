<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <?php
        //Use Model,libraries
        $this->load->library('takmoph_libraries');
        $this->load->driver('cache');
        $barmodel = new menubar_model();
        $lib = new takmoph_libraries();
        $groupnewsModel = new groupnews_model();
        $newsModel = new news_model();
        $photoModel = new photo_model();
        $style = $barmodel->get_style();
        $navbar = $barmodel->get_navbarmenu_all();
        $templateModel = $this->template_model->get_template();
        $path = $templateModel['path'];
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
            #body{<?php echo $this->background_model->background_active() ?>}
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
        <link href="<?php echo base_url() ?><?php echo $path ?>/css/bootstrap-flatly.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url() ?><?php echo $path ?>/js/bootstrap.js" type="text/javascript"></script>
        <link href="<?php echo base_url() ?><?php echo $path ?>/css/half-slider.css" rel="stylesheet" type="text/css" />

        <!-- Icon aware-some -->
        <link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />

        <!-- Jquery Library -->
        <script src="<?php echo base_url() ?>js/library/configweb.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?><?php echo $path ?>/js/system.js" type="text/javascript"></script>

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

    </head>

    <body id="body">
        <div class="container" id="main-content">
            <div class="btn btn-default pull-right" id="sign-in">
                <a href="<?php echo site_url('users/login') ?>"><i class="fa fa-lock"></i> Sign In</a>
            </div>
            <div id="head-logo">
                <img src="<?php echo base_url() ?>upload_images/logo/<?php echo $style->logo ?>" style=" height: 52px;"/>
                <?php echo $style->webname_full ?>
            </div>
            <!-- Navigation -->
            <nav class="navbar navbar-inverse" role="navigation" id="nav-bar">
                <div id="set-nav-bar">
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
                                           style=" color: <?php echo $style->color_text ?>;">
                                            <?php echo $nb->title ?></a>
                                    </li>
                                <?php } else { ?>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" style=" color: <?php echo $style->color_text ?>;"
                                           data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <?php echo $nb->title ?> <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" style=" background: <?php echo $style->color_navbar ?>;">

                                            <!--
                                                ########## Subnavbar ###########
                                            -->

                                            <?php
                                            $subnav = $barmodel->get_sub_navbarmenu($nb->id);
                                            foreach ($subnav->result() as $snSub):
                                                ?>
                                                <li>
                                                    <a href="<?php echo site_url('site/page/' . $this->takmoph_libraries->encode($snSub->id)) ?>"
                                                       style="color: <?php echo $style->color_text ?>;">
                                                        <i class="fa fa-angle-right"></i>
                                                        <?php echo $snSub->title ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                            <?php endforeach; ?>
                            <!-- EndMenuNavbar -->
                        </ul><!--- /.nav navbar-nav pull-right-->
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container -->
            </nav>

            <!-- Half Page Image Background Carousel Header -->
            <header id="myCarousel" class="carousel slide carousel-fade" style=" display: none;">
                <!-- Wrapper for Slides -->
                <div class="carousel-inner" style="height: 370px;">
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
            ##################
            ## Slide Hot News 
            ##################
            -->
            <div class="alert" id="box-express">
                <div >
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <!-- Wrapper for slides -->

                        <div class="carousel-inner" role="listbox">
                            <?php
                            $express_model = new newexpress_model();
                            $newsexpress = $express_model->get_express();
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
                                        <a href="<?php echo site_url('newexpress/view/' . $ns->id) ?>">
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

            <div class="row" style=" margin: 0px;">
                <!--
                #####################
                ## Menu Left 
                #####################
                -->
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <!--
                    ################ 
                    ## Menu And News 
                    ################
                    -->
                    <div class="well BL" id="bg_gray" style=" background: none;">
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
                        foreach ($menu->result() as $rs):
                            $menu_model = new menu_model();
                            //$color = $menu_model->get_color($rs->menu_color);
                            ?>

                            <?php
                            if ($rs->mas_status == '0') {
                                ?>
                                <a href="<?= site_url($rs->link . '/' . $rs->admin_menu_id . '/' . $rs->mas_menu) ?>" style="text-decoration: none;">
                                    <div id="submenu" class="btn btn-block hvr-trim" style="background:<?php echo $rs->bgcolor ?>;color:<?php echo $rs->textcolor ?>; border-radius:0px;">
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
                                    <div id="submenu" class="btn btn-block hvr-trim" style="background:<?php echo $rs->bgcolor ?>;color:<?php echo $rs->textcolor ?>; border-radius:0px;">
                                        <div class="text-menu"> 
                                            <img src="<?= base_url() ?>icon_menu/<?= $rs->menu_icon ?>" style="height:32px;"/>
                                            <?= $rs->mas_menu ?>
                                        </div>
                                    </div></a>

                                <!-- Droupdown -->
                                <?php
                            } else {
                                ?>

                                <a href="<?php echo site_url('menu/submenu/' . $rs->id); ?>" style=" text-decoration: none;">
                                    <div id="submenu" class="btn btn-block hvr-trim" style="background:<?php echo $rs->bgcolor ?>;color:<?php echo $rs->textcolor ?>; border-radius:0px;">                              
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
                            <div id="submenu" class="btn btn-info btn-block hvr-trim" style="border-radius:0px;">
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


                        <!-- 
                        ####################
                        ## ข่าว HOT
                        ####################
                        -->
                        <h3><i class="fa fa-fire"></i> ข่าว HOT</h3>
                        <hr id="hr"/>
                        <div class="row">
                            <?php
                            $i = 0;
                            $newsHot = $newsModel->hot();
                            foreach ($newsHot->result() as $hotNews):
                                $i++;
                                ?>

                                <?php
                                if ($i == '1') {
                                    $images_host = $newsModel->get_first_images_news($hotNews->id);
                                    ?>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="container-card link-hot" style=" max-height: 170px;">
                                            <div class="img-wrapper">
                                                <?php if (!empty($images_host)) { ?>
                                                    <img src="<?php echo base_url() ?>upload_images/news/<?php echo $images_host; ?>" class="img-responsive img-polaroid" style="height:100px;"/>
                                                <?php } else { ?>
                                                    <center>
                                                        <img src="<?php echo base_url() ?>images/News-Mic-iPhone-icon.jpg" class="img-responsive img_news" style="height:100px;"/>
                                                    </center>
                                                <?php } ?>
                                            </div>
                                            <p class="detail" style=" font-size: 12px; padding: 10px;">
                                                <a href="<?php echo site_url('news/view/' . $hotNews->id) ?>">
                                                    <i class="fa fa-fire"></i>
                                                    <?php
                                                    //$this->session->userdata('width');
                                                    $text = strlen($hotNews->titel);
                                                    if ($text > 160) {
                                                        //echo iconv_substr($news->titel,'0','100')."...";
                                                        if ($this->session->userdata('width') > 1000 || $this->session->userdata('width') <= 768) {
                                                            print mb_substr($hotNews->titel, 0, 30, 'UTF-8') . "...";
                                                        } else {
                                                            echo $hotNews->titel;
                                                        }
                                                    } else {
                                                        echo $hotNews->titel;
                                                    }
                                                    ?></a>
                                                <br/>
                                            </p>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                                        <div class="container-card link-hot" style=" max-height: 60px;">
                                            <p class="detail" style=" font-size: 12px; padding: 10px;">
                                                <a href="<?php echo site_url('news/view/' . $hotNews->id) ?>">
                                                    <i class="fa fa-fire"></i>
                                                    <?php
                                                    //$this->session->userdata('width');
                                                    $text = strlen($hotNews->titel);
                                                    if ($text > 160) {
                                                        //echo iconv_substr($news->titel,'0','100')."...";
                                                        if ($this->session->userdata('width') > 1000 || $this->session->userdata('width') <= 768) {
                                                            print mb_substr($hotNews->titel, 0, 30, 'UTF-8') . "...";
                                                        } else {
                                                            echo $hotNews->titel;
                                                        }
                                                    } else {
                                                        echo $hotNews->titel;
                                                    }
                                                    ?></a>
                                                <br/>
                                            </p>
                                        </div>
                                    </div>
                                <?php } ?>

                            <?php endforeach; ?>
                        </div>
                        <!-- End HOT News -->

                    </div> <!-- End Well -->


                </div>
                <!--
                #####################
                ## Content right 
                #####################
                -->
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 BR">
                    <!-- 
                    ####################
                    ## ข่าวล่าสุด
                    ####################
                    -->
                    <!-- Slide News -->
                    <div id="menu_and_news" style="display: none; margin-top: 0px; padding-top: 0px;">
                        <h3><i class="fa fa-newspaper-o"></i> ข่าวล่าสุด</h3>
                        <hr id="hr"/>
                        <div class="row">
                            <?php
                            $i = 0;
                            $homenews = $newsModel->get_news_limit();
                            foreach ($homenews->result() as $new):
                                $i++;
                                ?>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                    <div class="container-card" style=" max-height: 200px;">
                                        <div class="img-wrapper">
                                            <?php if (!empty($new->images)) { ?>
                                                <img src="<?php echo base_url() ?>upload_images/news/<?php echo $new->images; ?>" class="img-responsive img-polaroid" style="height:100px;"/>
                                            <?php } else { ?>
                                                <center>
                                                    <img src="<?php echo base_url() ?>images/News-Mic-iPhone-icon.jpg" class="img-responsive img_news" style="height:100px;"/>
                                                </center>
                                            <?php } ?>
                                        </div>
                                        <p class="detail" style=" font-size: 12px;">
                                            <?php
                                            //$this->session->userdata('width');
                                            $text = strlen($new->titel);
                                            if ($text > 160) {
                                                //echo iconv_substr($news->titel,'0','100')."...";
                                                if ($this->session->userdata('width') > 1000 || $this->session->userdata('width') <= 768) {
                                                    print mb_substr($new->titel, 0, 30, 'UTF-8') . "...";
                                                } else {
                                                    echo $new->titel;
                                                }
                                            } else {
                                                echo $new->titel;
                                            }
                                            ?><br/>
                                        </p>
                                        <button type="button" class="btn btn-default disabled btn-xs" id="btn-card" style="background: <?php echo $new->background;?>;color:<?php echo $new->headcolor;?>;right:80px;"><?php echo $new->groupname ?></button>
                                        <a href="<?php echo site_url('news/view/' . $new->id.'/'.$new->groupnews) ?>">
                                            <button type="button" class="btn btn-danger btn-xs" id="btn-card">อ่านข่าว ...</button>
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
                                            $i++;
                                            ?>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-<?php echo $Gn->column ?>">

                                                <?php
                                                if ($Gn->column == '12') {
                                                    echo $lib->setcolumn($Gn->column, $news->images, $news->titel, $news->date, $news->id,$news->groupnews);
                                                } else {
                                                    ?>
                                                    <div class="container-card" style="max-height: 200px;border-color:<?php echo $headcolor ?>">
                                                        <div class="img-wrapper">
                                                            <?php if (!empty($news->images)) { ?>
                                                                <img src="<?php echo base_url() ?>upload_images/news/<?php echo $news->images; ?>" class="img-responsive img-polaroid" style="height:100px;"/>
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
                                                        <a href="<?php echo site_url('news/view/' . $news->id.'/'.$news->groupnews) ?>">
                                                            <button type="button" class="btn btn-danger btn-xs" id="btn-card"> อ่านข่าว ...</button>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div><!-- End Col -->

                                        <?php endforeach; ?>
                                    </div>
                                    <div class="row" style=" clear: both;">
                                        <a href="<?php echo site_url('news/newsall/'.$Gn->id) ?>" class=" pull-right" style=" margin-right: 20px;">
                                            <button type="button" class="btn btn-default btn-sm" style=" margin-right: 0px;">ข่าวทั้งหมด <i class="fa fa-arrow-circle-o-right"></i></button>
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
                    <!--
                    ####################
                    ## end of content 
                    ####################
                    -->

                </div>
            </div>
            <!--
            ####################
            ## Album
            ####################
            -->

            <div id="main-album" style=" display: none;">
                <div class="alert" id="bg_gray" style="width:100%; border-radius:0px; margin-bottom:0px;">
                    <div  style=" padding-left:0px;">
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
                        <div  style=" margin-bottom: 30px;">
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

            <!--
            ########################
            ## Footer 
            ########################
            -->
            <nav class="navbar navbar-inverse" role="navigation" style="background: <?php echo $style->color_navbar; ?>" id="footer">
                <div  style="color:<?php echo $style->color_text ?>;">
                    <?php echo $style->footer ?>
                    <hr style="border-top:solid 1px <?php echo $style->color_head ?>;"/>
                    Copyright © 2015 - <?php echo date('Y') ?> AsbWeb By Theassemblerthemes.

                    <div id="counter" style=" float: right;">
                        จำนวนผู้เยี่ยมชม <span class="badge"><?php echo $this->counter_model->counter(); ?></span> คน
                    </div>
                </div>
            </nav>
            <nav class="navbar navbar-inverse" role="navigation" id="footer-credit">
                <div style="padding-top:20px;">
                    <div style="font-size:10px; color:<?php echo $style->color_text ?>; text-align:center;">
                        &copy; Create By The Assembler Themes | Kimniyom | Mini CMS
                        <a href="http://www.theassembler.net" target="_blank">www.theassembler.net</a>
                    </div>
                </div>
            </nav>
            <!--
            #####################
            ## EndFooter 
            #####################
            -->
        </div> <!-- End Container -->

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

        </script>
    </body>
</html>
