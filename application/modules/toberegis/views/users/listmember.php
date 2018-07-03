<style type="text/css">
    .row{
        margin-bottom: 10px;
    }
</style>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
        //array("label" => 'ผู้ใช้งาน', "url" => 'toberegis/users/index')
);
$active = $head;
?>
<?php echo $model->breadcrumb_backend($list, $active, 'toberegis/users/detailuser/' . $this->takmoph_libraries->url_encode($userid)); ?>
<div style=" clear: both;">
    <h3><i class="fa fa-user"></i> <?php echo $head ?></h3>
    <hr/>
</div>

<div class="row">
    <div class="col-md-3 col-lg-3">
        <div class="list-group">
            <div class="list-group-item active"><i class="fa fa-user"></i> ข้อมูลผู้ใช้งาน</div>
            <div class="list-group-item">ชื่อ - สกุล: <?php echo $user->name . " " . $user->lname ?></div>
            <div class="list-group-item">สถานะ: <?php echo $type->type ?></div>
            <div class="list-group-item">ลงทะเบียน: <?php echo $user->d_update ?></div>
        </div>
        <?php $this->load->view('toberegis/users/menu') ?>
    </div>
    <div class="col-md-9 col-lg-9">
        <?php if ($filter != "") { ?>
            <div class="row">
                <input type="hidden" id="ampur" value="<?php echo $ampur ?>"/>
                <?php echo $filter ?>
                <div id="_level2"></div>
                <div class="col-md-2 col-lg-2">
                    <button type="button" class="btn btn-default" id="btn" style=" margin-top: 25px;" onclick="getmember()"><i class="fa fa-check"></i> ตกลง</button>
                </div>
            </div>
            <div id="listmember"></div>
        <?php } else { ?>
            <div class="list-group">
                <?php foreach ($member->result() as $rs): ?>
                    <a href="<?php echo site_url('toberegis/toberegis/views/' . $this->takmoph_libraries->url_encode($rs->id)) ?>" class="list-group-item">
                        <?php echo ($rs->sex == "M") ? "<i class='fa fa-male'></i>" : "<i class='fa fa-female'></i>"; ?>
                        <?php echo $rs->name . ' ' . $rs->lname ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
    function Getlevel2() {
        var type = $("#type").val();
        var ampur = $("#ampur").val();
        var url = "<?php echo site_url('toberegis/users/getlevel2') ?>";
        var data = {ampur: ampur, type: type};
        $.post(url, data, function (datas) {
            $("#_level2").html(datas);
        });
    }

    //ดึงรายชื่อมาแสดง
    function getmember() {
        $("#btn").html("loading...");
        $("#btn").addClass("disabled");
        var type = $("#type").val();
        var ampur = $("#ampur").val();
        var level2 = $("#level2").val();
        if(type == ""){
            alert("ยังไม่ได้เลือกเงื่อนไข ...");
            $("#btn").html("<i class='fa fa-check'></i> ตกลง");
            $("#btn").removeClass("disabled");
            return false;
        }
        var url = "<?php echo site_url('toberegis/users/getlistmembertype') ?>";
        var data = {ampur: ampur, type: type, level2: level2};
        $.post(url, data, function (datas) {
            $("#btn").html("<i class='fa fa-check'></i> ตกลง");
            $("#btn").removeClass("disabled");
            $("#listmember").html(datas);
        });
    }
</script>