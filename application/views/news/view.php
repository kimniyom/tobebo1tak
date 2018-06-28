<style type="text/css">
    /*#im-resize{ width: 85px; height: 48px; margin-bottom: 5px;}*/
</style>

<script type="text/javascript">
    $(document).ready(function () {
        SetImgResponsive(".detail-new");
        Settitleimg();
    });

    function SetImgResponsive(BoxID) {
        var BoxPost = BoxID;
        var tn_array = $(BoxPost + ' img').map(function () {
            return $(this).attr("id");
        });

        for (var i = 0; i < tn_array.length; i++) {
            var tagimg = tn_array[i];
            var widthimg = $(BoxPost).width();
            var img = $(BoxPost + " #" + tagimg).width();
            if (img >= widthimg) {
                $(BoxPost + " #" + tagimg).addClass("img-responsive");
                $(BoxPost + " #" + tagimg).css({"width": "auto", "height": "auto"});
            }
        }

    }

    function Settitleimg() {
        var firstIMG = "<?php echo $images_first ?>";
        if (firstIMG != "") {
            var img = document.getElementById('img-new');
            var widthIMG = img.clientWidth;
            var widthbox = $(".detail-new").width();
            if (widthIMG >= widthbox) {
                $("#img-new").addClass("img-responsive");
            } else {
                $("#img-new").css({"width": "auto", "height": "auto"});
            }
        }
    }
</script>

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

</script>



<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$groupnewsModel = new groupnews_model();
$list = array(
    array('url' => 'news/newsall/' . $this->takmoph_libraries->encode($group->id), 'label' => $group->groupname),
        //array('url' => '', 'label' => 'menu2')
);

$active = "รายละเอียด";
$shareUrl = current_url();
?>
<?php echo $model->breadcrumb($list, $active); ?>

<hr id="hr"/>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
        <div class="row" style=" margin-bottom: 0px;">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                
                <?php if ($news->qrcode) { ?>
                    <a href="<?php echo base_url() ?>qrcode/<?php echo $news->qrcode ?>" class="fancybox">
                        <img src="<?php echo base_url() ?>qrcode/<?php echo $news->qrcode ?>" class="img img-responsive" width="80"/></a>
                <?php } else { ?>
                    <img src="<?php echo base_url() . "assets/module/toberegis/images/logotak.png" ?>" class="img img-responsive" width="80"/>
                <?php } ?>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                <i class="fa fa-eye text-primary"></i> อ่าน : <?php echo $news->views ?>
                <i class="fa fa-newspaper-o text-danger"></i> <?php echo $this->tak->thaidate($news->date) ?>
                <!-- Shaee FaceBook -->
                <div class="fb-share-button" data-layout="button_count"></div>
                <br/><i class="fa fa-user text-warning"></i> โดย : <?php echo $news->name . ' ' . $news->lname ?>
                <div style="font-size:20px; border-radius: 0px; color: #E13300; padding-bottom: 5x; margin-bottom: 5px;">
                    :: เรื่อง <?php echo $news->titel ?>
                </div>
            </div>
        </div>
        <hr style=" margin-top: 5px;"/>
        <?php if ($images_first != "") { ?>
            <div class="detail-new">
                <center><img src="<?= base_url() ?>upload_images/news/<?= $images_first ?>" id="img-new"/></center><br />
            </div>
        <?php } ?>
        <div class="detail-new">
            <?php echo $news->detail ?>
        </div>
        <!-- ##################
            Images News
        ####################-->
        <?php if ($images_first != "") : ?>
        <div class="row" style=" margin-top: 50px;">
                <div class="col-lg-12">
                    <h4 style=" margin: 0px; color:#ff0000; font-weight: bold;">
                        <i class="fa fa-image"></i> อัลบั้มภาพ</h4>
                    <hr />
                    <?php foreach ($images->result() as $rs): ?>
                        <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                            <a href="<?php echo base_url() ?>upload_images/news/<?= $rs->images ?>" class="fancybox" rel="ligthbox">
                                <div class="container-card" style="max-height: 100px;">
                                    <div class="img-wrapper">
                                        <img src="<?php echo base_url() ?>upload_images/news/thumb/<?= $rs->images ?>" class="img-responsive" style="height:100px;"/>
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

        <!--
            ############# ข่าว HOT ############
        -->

        <div class="row">
            <div class="col-lg-12">
                <h4 style="color: #ff0000; font-weight: bold;"><i class="fa fa-fire"></i> เรื่องน่าสนใจ</h4>
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
                                    <img src="<?php echo base_url() ?>upload_images/news/thumb/<?php echo $images; ?>" class="img-responsive img-polaroid" style="height:100px;"/>
                                <?php } else { ?>
                                    <center>
                                        <img src="<?php echo base_url() ?>images/News-Mic-iPhone-icon.jpg" class="img-responsive img_news" style="height:100px;"/>
                                    </center>
                                <?php } ?>
                            </div>
                            <p class="details">
                                <?php
                 
                                    echo $hots->titel;
                                ?>
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
                    <div id="div-bg-boxnew"></div>
                    <div class="img-wrapper">
                        <?php if (!empty($images)) { ?>
                            <img src="<?php echo base_url() ?>upload_images/news/thumb/<?php echo $images; ?>" class="img-responsive img-polaroid" style="height:100px;"/>
                        <?php } else { ?>
                            <center>
                                <img src="<?php echo base_url() ?>images/News-Mic-iPhone-icon.jpg" class="img-responsive img_news" style="height:100px;"/>
                            </center>
                        <?php } ?>
                    </div>
                    <p class="details">
                        <?php
                            echo $news->titel;
                        ?>
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
