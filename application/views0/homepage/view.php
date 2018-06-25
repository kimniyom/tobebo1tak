<script>
    (function (d, s, id) {
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

if (!empty($submenuID)) {
    $link = 'homepage/viewupper/' . $this->takmoph_libraries->encode($submenu->id) . '/' . $submenu->id;
    $labels = $submenu->title;
} else {
    $link = "";
    $labels = "";
}

$list = array(
    //array('url' => 'backend/homepage', 'label' => 'ตัวอย่าง'),
    array('url' => 'homepage/all/' . $this->takmoph_libraries->encode($result->homepage_id), 'label' => $result->title_name),
    array('url' => $link, 'label' => $labels)
);

$active = $head;
$users = $this->user->view($result->owner);
?>
<?php echo $model->breadcrumb($list, $active); ?>

        <h3 style=" word-wrap: break-word;" id="head_submenu">
            <?php echo $result->title; ?>
        </h3>

<hr id="hr"/>
<i class="fa fa-clock-o text-warning"></i> <?php echo $model->thaidate($result->create_date) ?>
<!-- Shaee FaceBook -->
<!-- Shaee FaceBook -->
<?php $shareUrl = current_url(); ?>
<div class="fb-share-button" data-href="<?php echo $shareUrl ?>" data-layout="button_count"></div>
<br/>

<div class="detail_page">
    <?php echo $result->detail ?>
</div>
<br/>

<hr/>
<div class="pull-right">
    <i class="fa fa-clock-o text-warning"></i> <?php echo $model->thaidate($result->create_date) ?>
    <em style=" color: #999999;">(โดย : <?php echo $users->name . ' ' . $users->lname ?>)</em>
</div>
<br/><br/>

<script type="text/javascript">
    $(document).ready(function () {
        var style = {"height": "auto"};
        $(".detail_page img").addClass('img-responsive');
        $(".detail_page img").css(style);
    });
</script>

<script type="text/javascript">
    $("#document").ready(function () {
        $("#side-left").hide();
        $("#side-right").removeClass('col-xs-12 col-sm-12 col-md-9 col-lg-9 BR');
        $("#side-right").addClass('col-md-12 col-lg-12');
    });
</script>