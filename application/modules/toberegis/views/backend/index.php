<style type="text/css">
    .admin-asbforum .btn{
        margin-bottom:20px;
    }
</style>
<?php
$this->load->library('takmoph_libraries');
$this->load->library('encrypt');
$model = new takmoph_libraries();
$list = "";
$active = "กระดานสนทนา";

?>

<?php echo $model->breadcrumb_backend($list, $active); ?>
        <h3 id="head_submenu">
            <i class="fa fa-file-text-o fa-2x text-warning"></i>
            <?php
            echo $active;
            ?>
        </h3>

<hr id="hr"/>
<div class="admin-asbforum">
    <h4><i class="fa fa-cog"></i><i class="fa fa-comment"></i> ตัวจัดการเว็บบอร์ด v 0.1</h4>
    <hr/>
    <div class="row">
        <div class="col-md-2 col-lg-2">
            <a href="<?php echo site_url('asbforum/config/index')?>">
            <button class="btn btn-default btn-block">
                <i class="fa fa-cog" style=" font-size: 50px;"></i><hr/>
                ตั้งค่าอีเมล์
            </button></a>
        </div>
        <div class="col-md-2 col-lg-2">
            <a href="<?php echo site_url('asbforum/backend/user')?>">
            <button class="btn btn-default btn-block">
                <i class="fa fa-users" style=" font-size: 50px;"></i><hr/>
                ผู้ใช้งาน
            </button></a>
        </div>
        <div class="col-md-2 col-lg-2">
            <a href="<?php echo site_url('asbforum/backend/category')?>">
            <button class="btn btn-default btn-block">
                <i class="fa fa-folder" style=" font-size: 50px;"></i><hr/>
                ประเภทกระทู้
            </button></a>
        </div>
        <div class="col-md-2 col-lg-2">
            <button class="btn btn-default btn-block">
                <i class="fa fa-comment" style=" font-size: 50px;"></i><hr/>
                กระทู้ทั้งหมด
            </button>
        </div>
        <div class="col-md-2 col-lg-2">
            <a href="<?php echo site_url('asbforum/backend/alertdelpost')?>">
            <button class="btn btn-default btn-block">
                <i class="fa fa-trash-o" style=" font-size: 50px;"></i><hr/>
                กระทู้แจ้งลบ
            </button></a>
        </div>
        <div class="col-md-2 col-lg-2">
            <a href="<?php echo site_url('asbforum/backend/alertdelcomment')?>">
            <button class="btn btn-default btn-block">
                <i class="fa fa-trash-o" style=" font-size: 50px;"></i><hr/>
                คอมเม้นแจ้งลบ
            </button></a>
        </div>
        <div class="col-md-2 col-lg-2">
            <a href="<?php echo site_url('asbforum/backend/agreement')?>">
            <button class="btn btn-default btn-block">
                <i class="fa fa-hand-paper-o" style=" font-size: 50px;"></i><hr/>
                ข้อตกลง
            </button></a>
        </div>
        <div class="col-md-2 col-lg-2">
            <a href="<?php echo site_url('asbforum/backend/typealert')?>">
            <button class="btn btn-default btn-block">
                <i class="fa fa-bullhorn" style=" font-size: 50px;"></i><hr/>
                ประเภทแจ้งเตือน
            </button></a>
        </div>
    </div>
</div>

