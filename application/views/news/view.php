
<style type="text/css">
    #im-resize{ width: 85px; height: 48px; margin-bottom: 5px;}
</style>

<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.5&appId=266256337158296";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    $(document).ready(function () {
        $(".detail_news img").addClass("img-responsive");
        $(".detail_news img").css({"width": "auto", "height": "auto"});
    });

</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$groupnewsModel = new groupnews_model();
$list = array(
    array('url' => 'news/newsall/' . $this->takmoph_libraries->encode($group->id), 'label' => $group->groupname),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
$shareUrl = current_url();
?>
<?php echo $model->breadcrumb($list, $active); ?>

        <h3 id="head_submenu"><?php echo $group->groupname ?></h3>


<hr id="hr"/>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
        <i class="fa fa-eye text-primary"></i> อ่าน : <?php echo $news->views ?>
        <i class="fa fa-newspaper-o text-danger"></i> <?php echo $this->tak->thaidate($news->date) ?>
        <!-- Shaee FaceBook -->
        <div class="fb-share-button" data-layout="button_count"></div>

        <div style="font-size:18px; border-radius: 0px; color: #E13300; padding-bottom: 10px; margin-bottom: 10px;">
            :: เรื่อง <?php echo $news->titel ?>
        </div>
        <?php if ($images_first != "") { ?>
            <center><img src="<?= base_url() ?>upload_images/news/<?= $images_first ?>" class="img-polaroid img-responsive" /></center><br />
        <?php } ?>
        <div class="detail_news">
            <?php echo $news->detail ?>
        </div>
        <!-- ##################
            Images News
        ####################-->
        <?php if ($images_first != "") : ?>
            <div class="row">
                <div class="col-lg-12">
                    <h4 style=" margin: 0px; color:#ff0000; font-weight: bold;">
                        <i class="fa fa-image"></i> Gallery</h4>
                    <hr />
                    <?php foreach ($images->result() as $rs): ?>
                        <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                            <a href="<?php echo base_url() ?>upload_images/news/<?= $rs->images ?>" class="fancybox" rel="ligthbox">
                                <div class="container-card" style="max-height: 100px;">
                                    <div class="img-wrapper">
                                        <img src="<?php echo base_url() ?>upload_images/news/<?= $rs->images ?>" class="img-responsive" style="height:100px;"/>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <hr/>
        <!--
        <script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=58c7f257afeab30011bc0958&product=inline-share-buttons"></script>
        <div class="sharethis-inline-share-buttons"></div>
       -->
        <div class="alert alert-success" style=" text-align:right; border-radius: 0px; background: none; border: none; color: #000;">
            <i class="fa fa-user text-warning"></i> โดย : <?php echo $news->name . ' ' . $news->lname ?>
            <i class="fa fa-newspaper-o text-danger"></i> <?php echo $this->tak->thaidate($news->date) ?>
        </div>

        <!--
            ############# ข่าว HOT ############
        -->

        <div class="row">
            <div class="col-lg-12">
                <h4 id="head_submenu" style=" color: #ff0000; font-weight: bold; margin-left: 15px;"><i class="fa fa-fire"></i> HOT</h4>
                <hr/>
                <?php
                $i = 0;
                foreach ($hot->result() as $hots): $i++;
                    $images = $this->news->get_first_images_news($hots->id);
                    ?>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        <div class="container-card set-views-card" style=" max-height: 200px;">
                            <div id="div-bg-boxnew"></div>
                            <div class="img-wrapper">
                                <?php if (!empty($images)) { ?>
                                    <img src="<?php echo base_url() ?>upload_images/news/<?php echo $images; ?>" class="img-responsive img-polaroid" style="height:100px;"/>
                                <?php } else { ?>
                                    <center>
                                        <img src="<?php echo base_url() ?>images/News-Mic-iPhone-icon.jpg" class="img-responsive img_news" style="height:100px;"/>
                                    </center>
                                <?php } ?>
                            </div>
                            <p class="detail" id="details">
                                <?php
                                //$this->session->userdata('width');
                                $text = strlen($hots->titel);
                                if ($text > 160) {
                                    //echo iconv_substr($news->titel,'0','100')."...";
                                    if ($this->session->userdata('width') > 1000 || $this->session->userdata('width') <= 768) {
                                        print mb_substr($hots->titel, 0, 40, 'UTF-8') . "...";
                                    } else {
                                        echo $hots->titel;
                                    }
                                } else {
                                    echo $hots->titel;
                                }
                                ?><br/>
                            </p>
                            <a href="<?php echo site_url('news/view/' . $this->takmoph_libraries->encode($hots->id) . '/' . $hots->groupnews) ?>">
                                <button type="button" class="btn btn-danger btn-xs" id="btn-card"> รายละเอียด ...</button>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
        <div class="list-group">
            <div class="list-group-item active">
                ประเภท
            </div>
            <?php
            $groupnews = $groupnewsModel->get_groypnews_active();
            foreach ($groupnews->result() as $rs):
                ?>
                <a href="<?php echo site_url('news/newsall/' . $this->takmoph_libraries->encode($rs->id)) ?>" class="list-group-item"><?php echo $rs->groupname ?></a>
            <?php endforeach; ?>
        </div>
        <h4 id="head_submenu" style=" color: #3399ff; font-weight: bold; margin-left: 15px;"><i class="fa fa-newspaper-o"></i> ล่าสุด</h4>
        <hr/>
        <?php
        $i = 0;
        foreach ($near->result() as $news): $i++;
            $images = $this->news->get_first_images_news($news->id);
            ?>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-12" style=" padding: 0px;">
                <div class="container-card set-views-card" style="max-height: 200px;">
                    <div class="img-wrapper">
                        <?php if (!empty($images)) { ?>
                            <img src="<?php echo base_url() ?>upload_images/news/<?php echo $images; ?>" class="img-responsive img-polaroid" style="height:100px;"/>
                        <?php } else { ?>
                            <center>
                                <img src="<?php echo base_url() ?>images/News-Mic-iPhone-icon.jpg" class="img-responsive img_news" style="height:100px;"/>
                            </center>
                        <?php } ?>
                    </div>
                    <p class="detail">
                        <?php
                        $this->session->userdata('width');

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
                        ?><br/>
                    </p>
                    <a href="<?php echo site_url('news/view/' . $this->takmoph_libraries->encode($news->id) . '/' . $news->groupnews) ?>">
                        <button type="button" class="btn btn-primary btn-xs" id="btn-card"> รายละเอียด ...</button>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        var width = $(window).width();
        var url = "<?php echo site_url('site/set_desktop') ?>";
        var data = {width: width};

        $.post(url, data, function (success) {
        });
    });

    $(document).ready(function () {
        //FANCYBOX
        //https://github.com/fancyapps/fancyBox
        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none"
        });
    });
</script>

<script type="text/javascript">
    $("#document").ready(function () {
        $("#side-left").hide();
        $("#side-right").removeClass('col-xs-12 col-sm-12 col-md-9 col-lg-9 BR');
        $("#side-right").addClass('col-md-12 col-lg-12');
    });
</script>
