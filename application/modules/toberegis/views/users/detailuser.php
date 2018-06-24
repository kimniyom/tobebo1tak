<style type="text/css">
    .row{
        margin-bottom: 10px;
    }
</style>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
        array("label" => 'ผู้ใช้งาน', "url" => 'toberegis/users/index')
);
$active = $head;
?>
<?php echo $model->breadcrumb_backend($list, $active); ?>
<div style=" clear: both;">
    <h3><i class="fa fa-user"></i> ผู้ใช้งาน</h3>
    <hr/>
</div>
<div class="row">
    <div class="col-md-3 col-lg-3">
        <div class="list-group">
            <div class="list-group-item active"><i class="fa fa-user"></i> ข้อมูลผู้ใช้งาน</div>
            <div class="list-group-item">ชื่อ - สกุล: <?php echo $user->name . " " . $user->lname ?></div>
            <div class="list-group-item">สถานะ: <?php echo $type->type ?></div>
            <div class="list-group-item">ลงทะเบียน: <?php echo $user->d_update ?></div>
            <div class="list-group-item">
                จัดการสิทธิ์ : <a href="<?php echo site_url('toberegis/users/privilegeupdate/' . $this->takmoph_libraries->url_encode($user->id)) ?>" class='text-warning'><i class="fa fa-pencil"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-9 col-lg-9">
        <h4><i class="fa fa-unlock"></i>สิทธอ์ผู้ใช้งาน</h4>
        <hr/>
        <div class="row">
            <?php echo $filter ?>
        </div>
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <h4><input type="checkbox" disabled="disabled" id="news" <?php echo ($news == 1) ? "checked" : ""?>/> ข่าวประชาสัมพันธ์</h4>
            </div>
        
            <div class="col-md-4 col-lg-4">
                <h4><input type="checkbox" disabled="disabled" id="activity" <?php echo ($activity == 1) ? "checked" : ""?>/> รูปภาพกิจกรรม</h4>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#ampur").attr('disabled',true);
    });
       function getschool(privilege) {
        $("#filters").html("loading...");
        var ampur = $("#ampur").val();
        var url = "<?php echo site_url('toberegis/users/getschoolinampur') ?>";
        var data = {ampur: ampur,privilege: privilege};
        $.post(url, data, function (datas) {
            $("#filters").html(datas);
            $("#filter").attr('disabled',true);
        });
    }

    function gettambon(privilege) {
        $("#filters").html("loading...");
        var ampur = $("#ampur").val();
        var url = "<?php echo site_url('toberegis/users/gettamboninampur') ?>";
        var data = {ampur: ampur,privilege: privilege};
        $.post(url, data, function (datas) {
            $("#filters").html(datas);
            $("#filter").attr('disabled',true);
        });
    }

    function getprisoner(privilege) {
        $("#filters").html("loading...");
        var ampur = $("#ampur").val();
        var url = "<?php echo site_url('toberegis/users/getprisonerinampur') ?>";
        var data = {ampur: ampur,privilege: privilege};
        $.post(url, data, function (datas) {
            $("#filters").html(datas);
            $("#filter").attr('disabled',true);
        });
    }

    function getcompany(privilege) {
        $("#filters").html("loading...");
        var ampur = $("#ampur").val();
        var url = "<?php echo site_url('toberegis/users/getcompanyinampur') ?>";
        var data = {ampur: ampur,privilege: privilege};
        $.post(url, data, function (datas) {
            $("#filters").html(datas);
            $("#filter").attr('disabled',true);
        });
    }
</script>