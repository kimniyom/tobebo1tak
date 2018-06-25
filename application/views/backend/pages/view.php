


<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
    array('url' => 'backend/pages/getpage/' . $admin_menu_id, 'label' => $group),
);

$active = "upload";
echo $model->breadcrumb_backend($list, $active);
$url = array("backend/pages/update",$datas->id,$admin_menu_id);
?>

<h3 style=" color: #0099ff;">หัวข้อ: <?= $head ?></h3>
<hr/>
<div class="pull-right">
    <a href="<?php echo site_url($url)?>">
        <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> แก้ไข</button></a>
        <a href="javascript:Delete('<?php echo $datas->id ?>')">
            <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> ลบ</button></a>
</div>
<h4>รายละเอียด: </h4><?php echo $datas->detail ?><br/>
<hr/>
<?php if ($datas->file) { ?>
    <a href="<?php echo base_url() ?>file_download/<?= $datas->file ?>" target="_blank">
        <i class="fa fa-file-zip-o"></i> ไฟล์แนบ</a>
    <hr/>
<?php } ?>
<div class="pull-right">วันที่: <?php echo $model->thaidate($datas->d_update) ?></div>

<script type="text/javascript">
    function Delete(id){
        var r = confirm("Are you sure ...");
        if(r == true){
            var url = "<?php echo site_url('backend/pages/delete')?>";
            var data = {id: id};
            $.post(url,data,function(datas){
                var admin_menu_id = "<?php echo $admin_menu_id ?>";
                window.location = "<?php echo site_url() ?>/backend/pages/getpage/" + admin_menu_id;
            });
        }
    }
</script>
