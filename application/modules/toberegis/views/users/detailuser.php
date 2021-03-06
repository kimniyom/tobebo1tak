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
<?php echo $model->breadcrumb_backend($list, $active, 'toberegis/users/detailuser/' . $this->takmoph_libraries->url_encode($user->id)); ?>
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
        </div>
        <?php $this->load->view('toberegis/users/menu') ?>
    </div>
    <div class="col-md-9 col-lg-9">
        <h4><i class="fa fa-unlock"></i>สิทธิ์ผู้ใช้งาน</h4>
        <hr/>
        <div class="row">
            <?php echo $filter ?>
        </div>
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <h4><?php echo ($news == 1) ? "<i class='fa fa-check text-success'></i>" : "<i class='fa fa-remove text-danger'></i>" ?> ข่าวประชาสัมพันธ์</h4>
            </div>
            <div class="col-md-4 col-lg-4">
                <h4><?php echo ($activity == 1) ? "<i class='fa fa-check text-success'></i>" : "<i class='fa fa-remove text-danger'></i>" ?> รูปภาพกิจกรรม</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4><?php echo ($privatedata == 1) ? "<i class='fa fa-check text-success'></i>" : "<i class='fa fa-remove text-danger'></i>" ?> ดูข้อมูลส่วนตัวสมาชิก สูบบุหรี่,ดื่มสุรา,เหตุผลที่เข้าเป็นสมาชิก</h4>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-5 col-lg-5">
                <div class="well" style=" text-align: center;">
                    สมาชิก TO BE NUMBER ONE<br/>
                    ในเขตรับผิดชอบ
                    <div id="countperson"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-lg-3">
                <a href="<?php echo site_url('toberegis/users/getmember/'.$user->type.'/'.$user->id) ?>">
                <button type="button" class="btn btn-default btn-lg">
                    <i class="fa fa-users"></i> รายชื่อสมาชิก<br/>
                    <div id="countperson"></div>
                </button></a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#ampur").attr('disabled', true);
        //loadmenu();
    });
    function getschool(privilege) {
        $("#filters").html("loading...");
        var ampur = $("#ampur").val();
        var url = "<?php echo site_url('toberegis/users/getschoolinampur') ?>";
        var data = {ampur: ampur, privilege: privilege};
        $.post(url, data, function (datas) {
            $("#filters").html(datas);
            $("#filter").attr('disabled', true);
            countperson();
        });
    }

    function gettambon(privilege) {
        $("#filters").html("loading...");
        var ampur = $("#ampur").val();
        var url = "<?php echo site_url('toberegis/users/gettamboninampur') ?>";
        var data = {ampur: ampur, privilege: privilege};
        $.post(url, data, function (datas) {
            $("#filters").html(datas);
            $("#filter").attr('disabled', true);
            countperson();
        });
    }

    function getprisoner(privilege) {
        $("#filters").html("loading...");
        var ampur = $("#ampur").val();
        var url = "<?php echo site_url('toberegis/users/getprisonerinampur') ?>";
        var data = {ampur: ampur, privilege: privilege};
        $.post(url, data, function (datas) {
            $("#filters").html(datas);
            $("#filter").attr('disabled', true);
            countperson();
        });
    }

    function getcompany(privilege) {
        $("#filters").html("loading...");
        var ampur = $("#ampur").val();
        var url = "<?php echo site_url('toberegis/users/getcompanyinampur') ?>";
        var data = {ampur: ampur, privilege: privilege};
        $.post(url, data, function (datas) {
            $("#filters").html(datas);
            $("#filter").attr('disabled', true);
            countperson();
        });
    }

    function countperson() {
        var user_id = "<?php echo $user->id ?>";
        var type = "<?php echo $user->type ?>";
        var url = "<?php echo site_url('toberegis/users/countperson') ?>";
        var data = {user_id: user_id,type: type};
        $.post(url, data, function (datas) {
            $("#countperson").html(datas);
        });
    }
    
    function loadmenu(){
        var user_id = "<?php echo $user->id ?>";;
        var url = "<?php echo site_url('toberegis/users/loadmenu') ?>";
        var data = {user_id: user_id};
        $.post(url, data, function (datas) {
            $("#menu").html(datas);
        });
    }
</script>