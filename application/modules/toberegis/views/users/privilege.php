<style type="text/css">
    .row{
        margin-bottom: 10px;
    }
</style>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(array("label" => 'ผู้ใช้งาน', "url" => 'toberegis/users/index')
);
    
$active = $head;
?>
<?php echo $model->breadcrumb_backend($list, $active); ?>
<div style=" clear: both;">
    <hr/>
</div>
<div class="row">
    <div class="col-md-3 col-lg-3">
        <div class="list-group">
            <div class="list-group-item active"><i class="fa fa-user"></i> ผู้ใช้งาน</div>
            <div class="list-group-item">ชื่อ - สกุล: <?php echo $user->name . " " . $user->lname ?></div>
            <div class="list-group-item">สถานะ: <?php echo $user->typename ?></div>
            <div class="list-group-item">ลงทะเบียน: <?php echo $user->d_update ?></div>
        </div>
    </div>
    <div class="col-md-9 col-lg-9">
        <h4>เลือกสิทธิ์การใช้งาน</h4>
        <hr/>
        <div class="row">
            <?php echo $filter ?>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <h4><input type="checkbox" id="news" <?php echo ($news == 1) ? "checked" : ""?>/> ข่าวประชาสัมพันธ์</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <h4><input type="checkbox" id="activity" <?php echo ($activity == 1) ? "checked" : ""?>/> รูปภาพกิจกรรม</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <button type="button" class="btn btn-success" onclick="saveprivilege()"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function getschool(privilege) {
        $("#filters").html("loading...");
        var ampur = $("#ampur").val();
        var url = "<?php echo site_url('toberegis/users/getschoolinampur') ?>";
        var data = {ampur: ampur,privilege: privilege};
        $.post(url, data, function (datas) {
            $("#filters").html(datas);
        });
    }

    function gettambon(privilege) {
        $("#filters").html("loading...");
        var ampur = $("#ampur").val();
        var url = "<?php echo site_url('toberegis/users/gettamboninampur') ?>";
        var data = {ampur: ampur,privilege: privilege};
        $.post(url, data, function (datas) {
            $("#filters").html(datas);
        });
    }

    function getprisoner(privilege) {
        $("#filters").html("loading...");
        var ampur = $("#ampur").val();
        var url = "<?php echo site_url('toberegis/users/getprisonerinampur') ?>";
        var data = {ampur: ampur,privilege: privilege};
        $.post(url, data, function (datas) {
            $("#filters").html(datas);
        });
    }

    function getcompany(privilege) {
        $("#filters").html("loading...");
        var ampur = $("#ampur").val();
        var url = "<?php echo site_url('toberegis/users/getcompanyinampur') ?>";
        var data = {ampur: ampur,privilege: privilege};
        $.post(url, data, function (datas) {
            $("#filters").html(datas);
        });
    }

    function saveprivilege() {
        var ampur = $("#ampur").val();
        var filter = $("#filter").val();
        var user_id = "<?php echo $user->id ?>";
        var news = $("#news").prop("checked") ? '1' : '0';
        var activity = $("#activity").prop("checked") ? '1' : '0';
        var flag = "<?php echo ($flag == 'save') ? 'saveprivilege' : 'updateprivilege' ?>";
        var url = "<?php echo site_url('toberegis/users') ?>" + "/" + flag;
        if (ampur == '') {
            alert("เลือกข้อมูลไม่ครบ...");
            return false;
        }
        var data = {user_id: user_id, ampur: ampur, filter: filter,news: news,activity: activity};
        $.post(url, data, function (datas) {
            var euser = datas.id;
            window.location = "<?php echo site_url('toberegis/users/detailuser') ?>" + "/" + euser;
        }, 'json');
    }
</script>