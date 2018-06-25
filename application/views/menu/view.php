<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$usersModel = new User();
$users = $usersModel->view($datas->user_id);
$list = array(
    //array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
    array('url' => 'menu/filemenu/' . $this->takmoph_libraries->encode($admin_menu_id), 'label' => $group),
);

$active = $head;
?>
<?php echo $model->breadcrumb($list, $active); ?>

<h3 id="head_submenu">หัวข้อ: <?= $head ?></h3>
<hr id="hr"/>
<h4>รายละเอียด: </h4><?php echo $datas->detail ?><br/>
<hr/>

<?php if ($datas->file) { ?>
    <div class="row">
        <div class="col-lg-3 col-md-3" style=" text-align: center;">
            <?php if ($datas->qrcode) { ?>
                <img src="<?php echo base_url() ?>qrcode/<?php echo $datas->qrcode ?>" width="150"/><br/>
            <?php } ?>
            <a href="<?php echo base_url() ?>file_download/<?= $datas->file ?>" target="_blank">
                <i class="fa fa-file-zip-o"></i> ไฟล์แนบ</a>
        </div>
    </div>
    <hr/>
<?php } ?>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="pull-right">
            วันที่: <?php echo $model->thaidate($datas->d_update) ?>
            <?php if(isset($users->name)){ ?>
            โดย: <?php echo $users->name." ".$users->lname ?> 
            <?php } ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#document").ready(function () {
        $("#side-left").hide();
        $("#side-right").removeClass('col-xs-12 col-sm-12 col-md-9 col-lg-9 BR');
        $("#side-right").addClass('col-md-12 col-lg-12');
    });
</script>