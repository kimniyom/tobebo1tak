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
            <?php echo $filter ?>
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