<style type="text/css">
    .row{
        margin-bottom: 10px;
    }
    h4{
        color: #00cc99;
    }
</style>
<script src="<?php echo base_url() ?>assets/module/toberegis/js/app.js"></script>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
        array("label" => 'ผู้ใช้งาน',"url" => 'toberegis/users/index')
);
$active = $head;
?>

<?php echo $model->breadcrumb_backend($list, $active); ?>
<div style=" clear: both;">
    <input type="hidden" name="" id="urlsave" value="<?php echo site_url('toberegis/users/saveuser') ?>"/>
    <input type="hidden" name="" id="urlredir" value="<?php echo site_url('toberegis/users/privilege') ?>"/>
    <input type="hidden" name="" id="urlchecknulluser" value="<?php echo site_url('toberegis/users/checknulluser') ?>"/>
    <h3><i class="fa fa-user"></i> ผู้ใช้งาน</h3>
    <hr/>
</div>
<h4>ข้อมูลผู้ใช้งาน</h4>
<div class="row">
    <div class="col-md-2 col-lg-2">ชื่อ</div>
    <div class="col-md-5 col-lg-4">
        <input type="text" name="name" id="name" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-lg-2">นามสกุล</div>
    <div class="col-md-5 col-lg-4">
        <input type="text" name="lname" id="lname" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-lg-2">สิทธิ์การใช้งาน</div>
    <div class="col-md-2 col-lg-2">
        <select class="form-control" id="type">
            <option value="">== เลือกสถานะ ==</option>
            <?php foreach ($type->result() as $types): ?>
                <option value="<?php echo $types->id ?>"><?php echo $types->type ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<h4>ข้อมูลเข้าใช้งาน</h4>
<div class="row">
    <div class="col-md-2 col-lg-2">Username</div>
    <div class="col-md-5 col-lg-4">
        <input type="text" name="username" id="username" class="form-control" placeholder="ภาษาอังกฤษหรือตัวเลขเท่านั้น a-z,A-Z,0-9...">
    </div>
    <div class="col-md-5 col-lg-4">
        <div id="usernull" style=" text-align: left; color: #ff3300;"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-lg-2">Password</div>
    <div class="col-md-5 col-lg-4">
        <input type="password" name="password" id="password" class="form-control" placeholder="ภาษาอังกฤษหรือตัวเลขเท่านั้น a-z,A-Z,0-9...">
    </div>
</div>

<hr/>
<div class="row">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-10 col-lg-10">
        <button type="button" class="btn btn-success" onclick="saveuser()"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
        <button type="button" class="btn btn-danger" onclick="javascript:window.location.reload();"><i class="fa fa-remove"></i> ยกเลิก</button>
    </div>
</div>



