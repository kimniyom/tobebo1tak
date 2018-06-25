
<?php
$this->load->library('takmoph_libraries');
$this->load->model('homepage_model');
$this->load->model('sub_homepage_model');
$model = new takmoph_libraries();
$navbarModel = new menubar_model();
$homepage = new homepage_model();
$sub_homepage = new sub_homepage_model();
$mas_homepage = $homepage->get_menu();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
?>


<div class="row" style=" margin: 0px; padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 0px;">
        <h3 id="head_submenu"><i class="fa fa-magic"></i> <?php echo $head ?></h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-right: 0px;">
        <?php echo $model->breadcrumb_backend($list, $active); ?>
    </div>
</div>

<hr id="hr"/>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <div class="container-card" style="height:150px;">
            <figure>
                <div class="img-wrapper">
                    <div id="example-bg"><?php echo $background ?></div>
                </div>
            </figure>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
        <h3 style="color:red">*ภาพพื้นหลังจะแสดงตามรูปแบบ Template</h3>
        <p id="bg-name" style=" font-size: 16px;">รูปภาพ / สีที่ท่านเลือก <?php echo $bgname ?></p>
    </div>
</div>

<h4>
    <i class="fa fa-image"></i>
    ภาพพื้นหลัง
</h4>
<hr/>

<div class="row">
    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
        <div class="well">
            <button type="button" class="btn btn-default btn-block" onclick="get_background()">ใช้รูปภาพเป็นพื้นหลัง</button>
            <button type="button" class="btn btn-default btn-block" onclick="get_color();">ใช้สีเป็นพื้นหลัง</button>
        </div>
    </div>
    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
        <div class="well">
            <div id="bg-web"></div>
        </div>
    </div>
</div>

<script>
    get_background();
    function get_background() {
        var url = "<?php echo site_url('backend/background/page') ?>";
        var data = {};
        $.post(url, data, function (html) {
            $("#bg-web").html(html);
        });
    }

    function get_color() {
        var url = "<?php echo site_url('backend/background/bg_color') ?>";
        var data = {};

        $.post(url, data, function (html) {
            $("#bg-web").html(html);
        });
    }

    function select_bg(id, bg) {
        var url = "<?php echo site_url('backend/background/set_background') ?>";
        $("#bg-name").html("รูปภาพ / สีที่ท่านเลือก "  + bg);
        var data = {
            id: id,
            bg: bg
        };
        $.post(url, data, function (html) {
            $("#example-bg").html(html);
        });
    }

</script>
