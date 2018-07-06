
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
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
/*
  $list = array(
  array('url' => '', 'label' => 'menu1'),
  array('url' => '', 'label' => 'menu2')
  );
 * 
 */

$active = $head;
$list = "";
echo $model->breadcrumb($list, $active);
?>

<hr id="hr"/>
<div class="row">
    <div class="col-sm-12 col-md-3 col-lg-3">
        <div style="padding:2px 5px; font-weight: bold; font-size:28px; color: #ff0000;"><i class="fa fa-newspaper-o"></i> ประเภทหน่วยงาน</div>
        <hr id="hr" style="border-color: #E13300;"/>
        <div class="list-group">
            <?php
            $typeactivity = $this->activity->GettypeAll();
            foreach ($typeactivity->result() as $rs):
                if ($type_id == $rs->id) {
                    $icon = "<div style='background:#E13300; float: left; left:0px;top:0px;width:5px;height:100%; position: absolute;'></div>";
                } else {
                    $icon = "";
                }
                ?>
                <a href="<?php echo site_url('toberegis/tobeactivity/all/' . $this->takmoph_libraries->url_encode($rs->id)) ?>" class="list-group-item" style=" border-radius: 0px;"><?php echo $icon ?> <?php echo $rs->type ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-sm-12 col-md-9 col-lg-9">
        <div id="album-views">
            <div style="padding:2px 5px; font-weight: bold; font-size:28px; color: #ff0000;"><?php echo $head; ?></div>
            <hr id="hr" style="border-color: #E13300;"/>
            <i class="fa fa-eye text-warning"></i> อ่าน
            <span class="badge"><?php echo $activity->views; ?></span>
            <!-- Shaee FaceBook -->
            <div class="fb-share-button" data-href="<?php echo $shareUrl ?>" data-layout="button_count"></div>
            <center>
                <p style="color:#999999;">
                    <?php
                    if (!empty($activity->detail)) {
                        echo $activity->detail;
                    } else {
                        echo "";
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
                        <a href="<?php echo base_url() ?>upload_images/tobeactivity/<?php echo $rs->images; ?>"
                           class="fancybox" rel="ligthbox">
                            <div class="container-card" style="height:250px;">
                                <div class="img-wrapper">
                                    <?php if (!empty($rs->images)) { ?>
                                        <img src="<?php echo base_url() ?>upload_images/tobeactivity/thumb/<?php echo $rs->images; ?>" class="img-responsive img-polaroid" style="height:250px;"/>
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
                <i class="fa fa-calendar-o"></i> <?php echo $model->thaidate($activity->date); ?>
                <i class="fa fa-user"></i> <?php echo $user->name . " " . $user->lname; ?>
            </div>
        </div>
    </div>
</div>

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
    $("#document").ready(function () {
        $("#side-left").hide();
        $("#side-right").removeClass('col-xs-12 col-sm-12 col-md-9 col-lg-9 BR');
        $("#side-right").addClass('col-md-12 col-lg-12');
    });
</script>

