
<script type="text/javascript">
    $(document).ready(function () {
        $('#file_upload').uploadify({
            'buttonText': 'กรุณาเลือกไฟล์ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('menager_menu/file_upload_submenu/' . $sub_id) ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '20MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            'width': '350',
            'height': '40',
            'fileTypeExts': '*.zip; *.rar; *.ppt; *.pdf;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 5, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                window.location.reload();
            }
        });
    });
</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
    array('url' => 'menuger_menu/get_mas_menu', 'label' => 'เมนูเว็บไซต์'),
    array('url' => 'menager_menu/get_sub_menu/' . $mas_id, 'label' => $mas_menu->mas_menu)
);

$active = "upload";
echo $model->breadcrumb_backend($list, $active);
?>

<h3><i class="fa fa-upload"></i> <?= $head ?></h3>

<hr/>
<h4>เรื่อง :: <?php echo $title ?></h4>

<div class="well">
    อัพโหลดได้ไม่เกินครั้งละ 20MB,<br/>
    อัพโหลดได้ไม่เกินครั้งละ 5 ไฟล์<br/><br/>

    นาสกุลไฟล์ *.zip; *.rar; *.ppt; *.pdf; *.doc

    <br /><br />
    <form>
        <div id="queue"></div>
        <div style="width:350px;">
            <input id="file_upload" name="file_upload" type="file" multiple>
        </div>
    </form><br />
</div>
<?php
if ($sub_menu->file) {
    $i = 1;
    ?>
    <a href="<?= base_url() ?>file_download/<?= $sub_menu->file ?>">
        <img src="<?= base_url() ?>images/rar-icon.png"/><?= $sub_menu->file ?></a> 
    <a href="javascript:DeleteFileOld('<?php echo $sub_menu->sub_id ?>')"><i class="fa fa-trash-o"></i></a> <br/>
    <img src="<?php echo base_url()?>qrcode/<?php echo $sub_menu->qrcode ?>" width="100"/>
    <?php
} else {
    $i = 0;
}
?>

<?php
foreach ($file->result() as $rs): $i++;
    ?>
    <img src="<?php echo base_url()?>qrcode/<?php echo $rs->qrcode ?>" width="100"/>
    <a href="<?= base_url() ?>file_download/<?= $rs->file ?>">
        <img src="<?= base_url() ?>images/rar-icon.png"/><?= $rs->file ?></a> 
    <a href="javascript:DeleteFile('<?php echo $rs->id ?>')"><i class="fa fa-trash-o"></i></a><br/>
    <?php endforeach; ?>


<script type="text/javascript">
    function DeleteFile(id) {
        var r = confirm('Are yor sure ...');
        if (r == true) {
            var url = "<?php echo site_url('menager_menu/deletefile') ?>";
            var data = {id: id};
            $.post(url, data, function (success) {
                window.location.reload();
            });
        }
    }
</script>

<script type="text/javascript">
    function DeleteFileOld(id) {
        var r = confirm('Are yor sure ...');
        if (r == true) {
            var url = "<?php echo site_url('menager_menu/deletefileold') ?>";
            var data = {id: id};
            $.post(url, data, function (success) {
                window.location.reload();
            });
        }
    }
</script>

