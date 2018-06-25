<?php $shareUrl = current_url(); ?>

<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.5&appId=1637139006560611";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<div class="container" id="album-views">
    <?php
    $this->load->library('takmoph_libraries');
    $this->load->model('photo_model', 'photo');
    $model = new takmoph_libraries();

    $list = array(
        array('url' => 'photo/page', 'label' => 'อัลบั้ม / กิจกรรม'),
            //array('url' => '', 'label' => 'menu2')
    );

        $active = $head;
    //echo $model->breadcrumb($list, $active);
    ?>
    
    <?php echo $model->breadcrumb($list, $active); ?>

   
            <h3 id="head_submenu">
                <img src="<?php echo base_url() ?>images/Album-icon.png" style="width:48px;"/> <?php echo $active ?>
            </h3>
        
    <hr id="hr"/>

    <i class="fa fa-eye text-warning"></i> อ่าน
    <span class="badge"><?php echo $this->photo->read_album($album->id); ?></span>
    <!-- Shaee FaceBook -->
    <div class="fb-share-button" data-href="<?php echo $shareUrl ?>" data-layout="button_count"></div>
    <center>
        <h4><?php echo $head; ?></h4>
        <p style="color:#999999;">รายละเอียด : <?php
            if (!empty($album->detail)) {
                echo $album->detail;
            } else {
                echo "-";
            }
            ?></p>
        <hr/>
    </center>
    <div class="row">
        <?php
        $i = 0;
        foreach ($gallery->result() as $rs): $i++;
            ?>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3" style="text-align:center;">
                <a href="<?php echo base_url() ?>upload_images/photo/<?php echo $rs->images; ?>"
                   class="fancybox" rel="ligthbox">
                    <div class="container-card" style="height:250px;">
                        <div class="img-wrapper">
                            <?php if (!empty($rs->images)) { ?>
                                <img src="<?php echo base_url() ?>upload_images/photo/thumb/<?php echo $rs->images; ?>" class="img-responsive img-polaroid" style="height:250px;"/>
                            <?php } else { ?>
                                <center>
                                    <img src="<?php echo base_url() ?>upload_images/photo/no-sign_1334604348.png" class="img-responsive img_news"/>
                                </center>
                            <?php } ?>
                        </div>
                    </div></a>
            </div>
        <?php endforeach; ?>
    </div>
    <hr/>
    <div class="pull-right">
        <i class="fa fa-calendar-o"></i> <?php echo $model->thaidate($album->create_date); ?>
        <i class="fa fa-user"></i> <?php echo $album->name . " " . $album->lname; ?>
    </div>
</div>
<br/>

<script type="text/javascript">
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
    $("#document").ready(function(){
       $("#side-left").hide();
       $("#side-right").removeClass('col-xs-12 col-sm-12 col-md-9 col-lg-9 BR');
       $("#side-right").addClass('col-md-12 col-lg-12');
    });
</script>

