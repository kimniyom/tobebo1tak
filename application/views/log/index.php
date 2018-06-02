<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = "";

$active = $head;
?>
<div class="row" style=" margin: 0px; padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 0px;">
        <h3 id="head_submenu"><i class="fa fa-list-alt"></i> <?php echo $head ?></h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-right: 0px;">
        <?php echo $model->breadcrumb_backend($list, $active); ?>
    </div>
</div>
<hr id="hr"/>

<div class="row">
    <div class="col-md-3 col-lg-3">
        <div class="btn btn-default btn-block" onclick="loglogin('0')">
            <div class="row">
                <div class="col-md-8 col-lg-8">
                    <i class="fa fa-user"></i>เข้าใช้งาน
                </div>
                <div class="col-md-4 col-lg-4">
                    <?php echo $countlog->total ?> ครั้ง
                </div>
            </div>
        </div>
        <div class="btn btn-success btn-block" onclick="loglogin('1')">
            <div class="row">
                <div class="col-md-8 col-lg-8">
                    <i class="fa fa-check"></i>เข้าใช้งานสำเร็จ
                </div>
                <div class="col-md-4 col-lg-4">
                    <?php echo $countlog->login_true ?> ครั้ง
                </div>
            </div>
        </div>
        <div class="btn btn-danger btn-block" onclick="loglogin('2')">
            <div class="row">
                <div class="col-md-8 col-lg-8">
                    <i class="fa fa-remove"></i>เข้าใช้งานไม่สำเร็จ
                </div>
                <div class="col-md-4 col-lg-4">
                    <?php echo $countlog->login_false ?> ครั้ง
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9 col-lg-9">
        <div id="logcontent">

        </div>
    </div>
</div>

<script type="text/javascript">
    loglogin(0);
    function loglogin(param) {
        var url = "<?php echo site_url('backend/log/loglogin') ?>" + "/" + param;
        $("#logcontent").load(url);
    }
</script>