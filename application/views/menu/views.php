


<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    //array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
    array('url' => 'menu/submenu/' . $this->takmoph_libraries->encode($group->id), 'label' => $groupmenu),
);

$active = $head;
$users = $this->user->view($datas->owner);
?>

<?php echo $model->breadcrumb($list, $active); ?>


<h3 id="head_submenu">หัวข้อ: <?= $datas->sub_name ?></h3>
<hr id="hr"/>
<?php
if (!empty($datas->detail)) {
    echo $datas->detail;
}
?>
<div class="row">

    <?php
    if ($datas->file) {
        $i = 1;
        ?>
        <div class="col-lg-3 col-md-3 col-sm-6" style="text-align: center;">
            <?php if ($datas->qrcode) { ?>
                <img src="<?php echo base_url() ?>qrcode/<?php echo $datas->qrcode ?>" width="150"/><br/>
            <?php } ?>
            <a href="<?= base_url() ?>file_download/<?= $datas->file ?>">
                <img src="<?= base_url() ?>images/rar-icon.png"/> <?= $datas->file ?></a>

        </div>
        <?php
    } else {
        $i = 0;
    }
    ?>

    <?php
    foreach ($file->result() as $rs): $i++;
        ?>

        <div class="col-lg-3 col-md-3 col-sm-6" style=" text-align: center;">
            <?php if ($rs->qrcode) : ?>
                <img src="<?php echo base_url() ?>qrcode/<?php echo $rs->qrcode ?>" width="150"/><br/>
            <?php endif ?>
            <a href="<?= base_url() ?>file_download/<?= $rs->file ?>">
                <img src="<?= base_url() ?>images/rar-icon.png"/> <?= $rs->file ?></a>
        </div>

    <?php endforeach; ?>
</div>
<hr/>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="pull-right">วันที่: <?php
            if ($datas->d_update)
                echo $model->thaidate($datas->d_update);
            else
                echo "";
            ?>
            <em style=" color: #999999;">(โดย : <?php echo $users->name . ' ' . $users->lname ?>)</em>
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
